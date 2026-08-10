#!/usr/bin/env node
const https = require('https')
const fs = require('fs')
const path = require('path')
const os = require('os')

const CONFIG_DIR = process.env.WALKIE_TG_CONFIG || path.join(os.homedir(), '.config', 'walkie-tg')
const TOKEN_FILE = path.join(CONFIG_DIR, 'token')
const CONFIG_FILE = path.join(CONFIG_DIR, 'config.json')
const CHAT_FILE = path.join(CONFIG_DIR, 'chat.json')
const WALKIE_CLIENT = process.env.WALKIE_SH_CLIENT ||
  path.join(os.homedir(), '.local', 'share', 'walkie', 'node_modules', 'walkie-sh', 'src', 'client.js')

const WALKIE_ID = process.env.WALKIE_TG_ID || 'tg-bot'
const MEDIA_DIR = process.env.WALKIE_TG_MEDIA || path.join(os.homedir(), '.walkie-media')

function log(...args) {
  process.stdout.write(`[${new Date().toISOString()}] ${args.join(' ')}\n`)
}

function fail(msg) {
  log(msg)
  process.exit(1)
}

function loadConfig() {
  let cfg = {}
  try { cfg = JSON.parse(fs.readFileSync(CONFIG_FILE, 'utf8')) } catch {}
  let chat = null
  try {
    const c = JSON.parse(fs.readFileSync(CHAT_FILE, 'utf8'))
    if (c.chatId) chat = c.chatId
  } catch {}
  return { cfg, chat }
}

function readToken() {
  if (process.env.WALKIE_TG_TOKEN) return process.env.WALKIE_TG_TOKEN.trim()
  try {
    const t = fs.readFileSync(TOKEN_FILE, 'utf8').trim()
    if (t) return t
  } catch {}
  fail('No hay token. Crea un bot con @BotFather y guarda el token en ' + TOKEN_FILE + ' (chmod 600) o exporta WALKIE_TG_TOKEN')
}

const { cfg, chat: savedChat } = loadConfig()
const TOKEN = readToken()
const CHANNEL = process.env.WALKIE_TG_CHANNEL || cfg.channel
const SECRET = process.env.WALKIE_TG_SECRET || cfg.secret
let CHAT_ID = process.env.WALKIE_TG_CHAT || savedChat || cfg.chatId

if (!CHANNEL) fail('Falta el canal walkie. Exporta WALKIE_TG_CHANNEL o usa config.json')
if (!SECRET) fail('Falta el secreto. Exporta WALKIE_TG_SECRET o usa config.json')

const API = `https://api.telegram.org/bot${TOKEN}`

function api(method, params = {}) {
  return new Promise((resolve, reject) => {
    const url = `${API}/${method}`
    const body = JSON.stringify(params)
    const req = https.request(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' }
    }, (res) => {
      let buf = ''
      res.on('data', (c) => { buf += c })
      res.on('end', () => {
        try {
          const json = JSON.parse(buf)
          if (!json.ok) return reject(new Error(`${method}: ${json.description || 'telegram error'}`))
          resolve(json.result)
        } catch (e) { reject(e) }
      })
    })
    req.on('error', reject)
    req.setTimeout(70000, () => req.destroy(new Error('telegram timeout')))
    req.write(body)
    req.end()
  })
}

function saveChat(id) {
  if (CHAT_ID === id) return
  CHAT_ID = id
  fs.mkdirSync(CONFIG_DIR, { recursive: true })
  fs.writeFileSync(CHAT_FILE, JSON.stringify({ chatId: id }, null, 2), { mode: 0o600 })
  log('Chat de Telegram auto-detectado y guardado:', id)
}

function sendTelegram(chatId, text) {
  if (!chatId || !text) return Promise.resolve()
  return api('sendMessage', { chat_id: chatId, text }).catch((e) => log('sendMessage fallo:', e.message))
}

function mimeFor(file) {
  const ext = path.extname(file).toLowerCase()
  const map = {
    '.jpg': 'image/jpeg', '.jpeg': 'image/jpeg', '.png': 'image/png', '.gif': 'image/gif',
    '.webp': 'image/webp', '.bmp': 'image/bmp', '.pdf': 'application/pdf',
    '.mp4': 'video/mp4', '.mp3': 'audio/mpeg', '.txt': 'text/plain',
    '.json': 'application/json', '.zip': 'application/zip', '.tar': 'application/x-tar'
  }
  return map[ext] || 'application/octet-stream'
}

function sendMultipart(method, fields, filePath) {
  return new Promise((resolve, reject) => {
    fs.readFile(filePath, (err, data) => {
      if (err) return reject(err)
      const boundary = '----walkie' + Date.now().toString(16)
      const chunks = []
      const part = (name, value) => {
        chunks.push(Buffer.from(
          `--${boundary}\r\nContent-Disposition: form-data; name="${name}"\r\n\r\n${value}\r\n`
        ))
      }
      for (const [k, v] of Object.entries(fields)) part(k, String(v))
      const fname = path.basename(filePath)
      chunks.push(Buffer.from(
        `--${boundary}\r\nContent-Disposition: form-data; name="${method === 'sendPhoto' ? 'photo' : 'document'}"; filename="${fname}"\r\nContent-Type: ${mimeFor(fname)}\r\n\r\n`
      ))
      chunks.push(data)
      chunks.push(Buffer.from(`\r\n--${boundary}--\r\n`))
      const body = Buffer.concat(chunks)

      const req = https.request(`${API}/${method}`, {
        method: 'POST',
        headers: {
          'Content-Type': `multipart/form-data; boundary=${boundary}`,
          'Content-Length': body.length
        }
      }, (res) => {
        let buf = ''
        res.on('data', (c) => { buf += c })
        res.on('end', () => {
          try {
            const json = JSON.parse(buf)
            if (!json.ok) return reject(new Error(`${method}: ${json.description || 'telegram error'}`))
            resolve(json.result)
          } catch (e) { reject(e) }
        })
      })
      req.on('error', reject)
      req.setTimeout(70000, () => req.destroy(new Error('telegram timeout')))
      req.end(body)
    })
  })
}

function downloadFile(url, dest) {
  return new Promise((resolve, reject) => {
    const req = https.get(url, (res) => {
      if (res.statusCode !== 200) {
        res.resume()
        return reject(new Error(`download ${res.statusCode}`))
      }
      const ws = fs.createWriteStream(dest)
      res.pipe(ws)
      ws.on('finish', () => ws.close(() => resolve(dest)))
      ws.on('error', reject)
    })
    req.on('error', reject)
  })
}

function sendMediaFromPath(chatId, filePath, caption) {
  const method = /\.(jpe?g|png|gif|webp|bmp)$/i.test(filePath) ? 'sendPhoto' : 'sendDocument'
  const fields = { chat_id: chatId }
  if (caption) fields.caption = caption
  return sendMultipart(method, fields, filePath).catch((e) => log(method + ' fallo:', e.message))
}

function parseMediaMarker(text) {
  if (!text) return null
  const m = String(text).match(/^(photo|file):(\S+)(?:\s*\|\s*(.*))?$/)
  if (!m) return null
  let filePath = m[2]
  if (filePath === '~' || filePath.startsWith('~/')) {
    filePath = path.join(os.homedir(), filePath.slice(2))
  }
  return { kind: m[1], filePath, caption: (m[3] || '').trim() }
}

const walkie = require(WALKIE_CLIENT)

function startWalkieToTelegram() {
  const abort = { aborted: false, socket: null }
  const START_TS = Date.now()
  const STALE_MS = 60 * 1000
  const onMessage = async (msg) => {
    if (!msg || msg.data == null) return
    if (msg.from === WALKIE_ID) return
    if (msg.from === 'system') return
    if (msg.ts && msg.ts < START_TS - STALE_MS) return
    if (msg.ts && msg.ts > Date.now() + STALE_MS) return
    const text = String(msg.data)
    const marker = parseMediaMarker(text)
    if (marker) {
      log('walkie -> Telegram media:', marker.kind, marker.filePath)
      if (fs.existsSync(marker.filePath) && fs.statSync(marker.filePath).isFile()) {
        const caption = marker.caption ? `[${msg.from}]: ${marker.caption}` : `[${msg.from}]`
        await sendMediaFromPath(CHAT_ID, marker.filePath, caption)
        return
      }
      log('media no encontrado, reenviando como texto:', marker.filePath)
    }
    log('walkie -> Telegram:', `[${msg.from}]`, text.slice(0, 80))
    await sendTelegram(CHAT_ID, `[${msg.from || 'walkie'}]: ${text}`)
  }

  walkie.request({ action: 'join', channel: CHANNEL, secret: SECRET, clientId: WALKIE_ID, persist: true })
    .catch((e) => log('join fallo:', e.message))

  walkie.streamMessages(CHANNEL, SECRET, WALKIE_ID, abort, onMessage, true)
    .catch((e) => log('streamMessages terminado:', e.message))

  process.on('SIGINT', () => { abort.aborted = true; process.exit(0) })
  process.on('SIGTERM', () => { abort.aborted = true; process.exit(0) })
  log('walkie -> Telegram  (canal:', CHANNEL + ')')
}

function startTelegramToWalkie() {
  let offset = 0
  const send = (text) => {
    return walkie.request({ action: 'send', channel: CHANNEL, secret: SECRET, message: text, clientId: WALKIE_ID })
      .catch((e) => log('walkie send fallo:', e.message))
  }

  const poll = async () => {
    try {
      const updates = await api('getUpdates', { offset, timeout: 25 })
      for (const u of updates || []) {
        offset = u.update_id + 1
        const m = u.message
        if (!m) continue
        if (!CHAT_ID) {
          if (m.chat && (m.chat.id || m.chat.id === 0)) saveChat(m.chat.id)
        }
        if (CHAT_ID && m.chat && m.chat.id !== Number(CHAT_ID)) continue
        const caption = m.caption || ''
        let fileId = null
        let kind = null
        let ext = '.bin'
        if (m.photo && m.photo.length > 0) {
          fileId = m.photo[m.photo.length - 1].file_id
          kind = 'photo'
          ext = '.jpg'
        } else if (m.document) {
          fileId = m.document.file_id
          kind = 'file'
          ext = path.extname(m.document.file_name || '.bin') || '.bin'
        } else if (m.video) {
          fileId = m.video.file_id
          kind = 'file'
          ext = '.mp4'
        } else if (m.voice) {
          fileId = m.voice.file_id
          kind = 'file'
          ext = '.ogg'
        }

        if (fileId) {
          try {
            const f = await api('getFile', { file_id: fileId })
            const dest = path.join(MEDIA_DIR, `tg_${Date.now()}${ext}`)
            await downloadFile(`https://api.telegram.org/file/bot${TOKEN}/${f.file_path}`, dest)
            const marker = `${kind}:${dest}${caption ? ' | ' + caption : ''}`
            await send(marker)
            log('Telegram -> walkie media:', marker)
          } catch (e) {
            log('media fallo:', e.message)
          }
          continue
        }

        if (!m.text || m.text.startsWith('/')) continue
        await send(m.text)
        log('Telegram -> walkie:', m.text)
      }
    } catch (e) {
      log('getUpdates error:', e.message)
    }
    setTimeout(poll, 300)
  }
  if (!CHAT_ID) log('Esperando primer mensaje para auto-detectar el chat_id...')
  else log('Telegram -> walkie  (chat id:', CHAT_ID + ')')
  poll()
}

fs.mkdirSync(MEDIA_DIR, { recursive: true, mode: 0o700 })
startWalkieToTelegram()
startTelegramToWalkie()
