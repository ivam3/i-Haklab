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
    const url = `${API}/${method}${Object.keys(params).length ? '?' + new URLSearchParams(params).toString() : ''}`
    const req = https.get(url, (res) => {
      let body = ''
      res.on('data', (c) => { body += c })
      res.on('end', () => {
        try {
          const json = JSON.parse(body)
          if (!json.ok) return reject(new Error(`${method}: ${json.description || 'telegram error'}`))
          resolve(json.result)
        } catch (e) { reject(e) }
      })
    })
    req.on('error', reject)
    req.setTimeout(30000, () => req.destroy(new Error('telegram timeout')))
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

const walkie = require(WALKIE_CLIENT)

function startWalkieToTelegram() {
  const abort = { aborted: false, socket: null }
  const onMessage = async (msg) => {
    if (!msg || msg.message == null) return
    if (msg.from === WALKIE_ID) return
    await sendTelegram(CHAT_ID, `[${msg.from || 'walkie'}]: ${msg.message}`)
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
      const updates = await api('getUpdates', { offset, timeout: 30 })
      for (const u of updates || []) {
        offset = u.update_id + 1
        const m = u.message
        if (!m || !m.text) continue
        if (!CHAT_ID) {
          if (m.chat && (m.chat.id || m.chat.id === 0)) saveChat(m.chat.id)
        }
        if (CHAT_ID && m.chat && m.chat.id !== Number(CHAT_ID)) continue
        if (m.text.startsWith('/')) continue
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

startWalkieToTelegram()
startTelegramToWalkie()
