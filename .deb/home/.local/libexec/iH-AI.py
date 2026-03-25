#!/usr/bin/env python3
import sys
import json
import urllib.request
import urllib.error
import os

# Configuration
HIST_FILE = sys.argv[1]
PROVIDER = sys.argv[2] # 'openai', 'gemini', 'anthropic'
MODEL = sys.argv[3]
API_KEY = sys.argv[4]

def load_history():
    if os.path.exists(HIST_FILE):
        with open(HIST_FILE, 'r') as f:
            return json.load(f)
    return []

def save_history(history):
    with open(HIST_FILE, 'w') as f:
        json.dump(history, f)

def stream_openai(history):
    url = "https://api.openai.com/v1/chat/completions"
    headers = {
        "Content-Type": "application/json",
        "Authorization": f"Bearer {API_KEY}"
    }
    data = json.dumps({
        "model": MODEL,
        "messages": history,
        "stream": True
    }).encode('utf-8')
    
    req = urllib.request.Request(url, data=data, headers=headers)
    full_resp = ""
    try:
        with urllib.request.urlopen(req) as response:
            for line in response:
                line = line.decode('utf-8').strip()
                if line.startswith("data: "):
                    content = line[6:]
                    if content == "[DONE]": break
                    try:
                        chunk = json.loads(content)
                        delta = chunk['choices'][0].get('delta', {}).get('content', '')
                        print(delta, end='', flush=True)
                        full_resp += delta
                    except: pass
    except Exception as e:
        print(f"\nError OpenAI: {e}")
    return full_resp

def stream_gemini(history):
    # Gemini uses a different history format
    contents = []
    for msg in history:
        role = "user" if msg['role'] == "user" else "model"
        if msg['role'] == "system": continue # Gemini handles system differently in some versions
        contents.append({"role": role, "parts": [{"text": msg['content']}]})
        
    url = f"https://generativelanguage.googleapis.com/v1beta/models/{MODEL}:streamGenerateContent?key={API_KEY}"
    headers = {"Content-Type": "application/json"}
    data = json.dumps({"contents": contents}).encode('utf-8')
    
    req = urllib.request.Request(url, data=data, headers=headers)
    full_resp = ""
    try:
        with urllib.request.urlopen(req) as response:
            for line in response:
                line = line.decode('utf-8').strip()
                if not line: continue
                # Cleaning the line from "[, ]" parts of the stream JSON
                if line.startswith(",") or line.startswith("[") or line.startswith("]"):
                   line = line.strip("[], ")
                if not line: continue
                try:
                    chunk = json.loads(line)
                    text = chunk['candidates'][0]['content']['parts'][0]['text']
                    print(text, end='', flush=True)
                    full_resp += text
                except: pass
    except Exception as e:
        print(f"\nError Gemini: {e}")
    return full_resp

def stream_anthropic(history):
    url = "https://api.anthropic.com/v1/messages"
    # Filter system prompt
    system_prompt = next((m['content'] for m in history if m['role'] == 'system'), "")
    messages = [m for m in history if m['role'] != 'system']
    
    headers = {
        "x-api-key": API_KEY,
        "anthropic-version": "2023-06-01",
        "content-type": "application/json",
        "anthropic-dangerous-direct-browser-access": "true"
    }
    data = json.dumps({
        "model": MODEL,
        "system": system_prompt,
        "messages": messages,
        "stream": True,
        "max_tokens": 1024
    }).encode('utf-8')
    
    req = urllib.request.Request(url, data=data, headers=headers)
    full_resp = ""
    try:
        with urllib.request.urlopen(req) as response:
            for line in response:
                line = line.decode('utf-8').strip()
                if line.startswith("data: "):
                    content = line[6:]
                    try:
                        chunk = json.loads(content)
                        if chunk['type'] == 'content_block_delta':
                            delta = chunk['delta'].get('text', '')
                            print(delta, end='', flush=True)
                            full_resp += delta
                    except: pass
    except Exception as e:
        print(f"\nError Anthropic: {e}")
    return full_resp

def main():
    history = load_history()
    print(f"\n🤖 \033[32m{MODEL}\033[0m: ", end='', flush=True)
    
    if PROVIDER == "openai":
        reply = stream_openai(history)
    elif PROVIDER == "gemini":
        reply = stream_gemini(history)
    elif PROVIDER == "anthropic":
        reply = stream_anthropic(history)
    else:
        print("Provider not supported.")
        return

    if reply:
        history.append({"role": "assistant", "content": reply})
        # Limit history
        if len(history) > 20:
           history = [history[0]] + history[-19:]
        save_history(history)
    print()

if __name__ == "__main__":
    main()
