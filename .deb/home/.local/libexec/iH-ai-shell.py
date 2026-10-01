#!/usr/bin/env python3
"""i-Haklab AI shell assistant (stdlib only).

Terminal assistant that turns natural language into the exact shell command
you need. It uses a local Ollama model when available (offline, free) and
falls back to Groq Cloud otherwise. No pip dependencies, no external downloads:
it only uses the Python standard library.

Usage (normally via the `ai` wrapper in ~/.local/bin/ai):
    ai-shell.py "describe the task" [--model M] [--run] [--no-run]
                [--cloud] [--local] [--history|-H] [--clear-history] [--help]

Backend selection:
    auto (default): Ollama when OLLAMA_HOST answers, otherwise Groq Cloud.
    --local: force Ollama (offline). --cloud: force Groq (needs a key).
"""
import json
import os
import re
import subprocess
import sys
import urllib.request
import urllib.error

LOCAL_MODEL_DEFAULT = "qwen2.5-coder:1.5b"
GROQ_MODEL_DEFAULT = os.environ.get("GROQ_MODEL", "llama-3.3-70b-versatile")
OLLAMA_HOST = os.environ.get("OLLAMA_HOST", "http://127.0.0.1:11434").rstrip("/")
GROQ_BASE_URL = os.environ.get("GROQ_BASE_URL", "https://api.groq.com/openai/v1").rstrip("/")
GROQ_API_KEY = os.environ.get("GROQ_API_KEY", "")
HIST_FILE = os.path.join(os.environ.get("HOME", "."), ".local/share/iH-ai/history.json")
TIMEOUT = int(os.environ.get("IH_AI_TIMEOUT", "120"))


def detect_shell_env():
    if os.environ.get("PREFIX") or os.path.exists("/data/data/com.termux"):
        return "termux"
    return "linux"


SHELL_HINTS = {
    "termux": (
        "Environment: Termux on Android (no root). $PREFIX=/data/data/com.termux/files/usr, "
        "$HOME=/data/data/com.termux/files/home. No sudo, no /usr/bin/env; files outside "
        "$PREFIX/$HOME do not exist. Package manager: apt (via pkg). Example: "
        "'install nmap' -> 'pkg install nmap'. i-Haklab suite: 'i-Haklab <sub>' "
        "(help, about <tool>, show alltools, setapikey)."
    ),
    "linux": (
        "Environment: Linux terminal (bash/zsh). Use standard GNU/Linux commands: "
        "ls, grep, find, curl, etc."
    ),
}

SYSTEM_PROMPT = (
    "You translate natural language requests into exactly ONE shell command. "
    "{shell_hint} Reply with ONLY the raw command text: no markdown fences, "
    "no quotes around it, no explanations, no second alternatives. "
    "If the request is ambiguous, pick the most common interpretation."
)


def ollama_up():
    try:
        req = urllib.request.Request(f"{OLLAMA_HOST}/api/tags")
        with urllib.request.urlopen(req, timeout=5) as r:
            return r.status == 200
    except Exception:
        return False


def ask_ollama(prompt, model):
    payload = json.dumps({
        "model": model,
        "prompt": f"{SYSTEM_PROMPT.format(shell_hint=SHELL_HINTS[detect_shell_env()])}\n\nRequest: {prompt}\nCommand:",
        "stream": False,
    }).encode("utf-8")
    req = urllib.request.Request(
        f"{OLLAMA_HOST}/api/generate", data=payload,
        headers={"Content-Type": "application/json"},
    )
    with urllib.request.urlopen(req, timeout=TIMEOUT) as r:
        return json.load(r).get("response", "")


def ask_groq(prompt):
    if not GROQ_API_KEY:
        return None
    payload = json.dumps({
        "model": GROQ_MODEL_DEFAULT,
        "messages": [
            {"role": "system", "content": SYSTEM_PROMPT.format(
                shell_hint=SHELL_HINTS[detect_shell_env()])},
            {"role": "user", "content": prompt},
        ],
        "temperature": 0.1,
    }).encode("utf-8")
    req = urllib.request.Request(
        f"{GROQ_BASE_URL}/chat/completions", data=payload,
        headers={"Content-Type": "application/json",
                 "Authorization": f"Bearer {GROQ_API_KEY}"},
    )
    with urllib.request.urlopen(req, timeout=TIMEOUT) as r:
        data = json.load(r)
        return data["choices"][0]["message"]["content"]


def clean_command(text):
    """Extract a single runnable command; return None when unsafe."""
    if not text:
        return None
    t = text.strip()
    fence = re.search(r"```(?:\w+)?\s*\n(.*?)```", t, re.DOTALL)
    if fence:
        t = fence.group(1)
    lines = [ln.strip() for ln in t.splitlines() if ln.strip()]
    if not lines:
        return None
    cmd = lines[0]
    # Drop a leading prose intro line ("...:") and use the next one.
    if len(lines) > 1 and re.match(r"^[A-Z].*:$", cmd) and not cmd.startswith(("ls", "pkg", "apt", "cd", "find", "grep", "curl", "mkdir", "echo", "sudo", "git", "pip", "npm", "ollama", "i-Haklab")):
        cmd = lines[1]
    cmd = re.sub(r"^\$\s+", "", cmd)
    cmd = cmd.strip("`\"' ")
    if not cmd or len(cmd) > 1000 or cmd.lower().startswith(("sorry", "i cannot", "i can't", "as an ai")):
        return None
    return cmd


def load_history():
    try:
        with open(HIST_FILE, "r", encoding="utf-8") as f:
            data = json.load(f)
            return data if isinstance(data, list) else []
    except (OSError, ValueError):
        return []


def save_history(entries):
    os.makedirs(os.path.dirname(HIST_FILE), exist_ok=True)
    with open(HIST_FILE, "w", encoding="utf-8") as f:
        json.dump(entries, f, ensure_ascii=False, indent=1)


def log_history(query, command, backend, model):
    import datetime
    entries = load_history()
    entries.append({
        "ts": datetime.datetime.now().isoformat(timespec="seconds"),
        "backend": backend, "model": model,
        "query": query, "command": command,
    })
    save_history(entries[-500:])


def show_history():
    entries = load_history()
    if not entries:
        print("(_>) No history yet.")
        return
    for i, e in enumerate(entries, 1):
        print(f"{i}. [{e.get('ts', '?')}/{e.get('backend', '?')}] {e.get('query', '')}\n   ➤ {e.get('command', '')}")


def print_help():
    print(__doc__)


def parse_args(argv):
    query_parts, model, mode, run = [], None, "auto", None
    show_hist, clear_hist = False, False
    i = 0
    while i < len(argv):
        a = argv[i]
        if a in ("-m", "--model") and i + 1 < len(argv):
            model = argv[i + 1]
            i += 2
        elif a == "--cloud":
            mode = "cloud"
            i += 1
        elif a == "--local":
            mode = "local"
            i += 1
        elif a == "--run":
            run = True
            i += 1
        elif a == "--no-run":
            run = False
            i += 1
        elif a in ("--history", "-H"):
            show_hist = True
            i += 1
        elif a == "--clear-history":
            clear_hist = True
            i += 1
        elif a in ("-h", "--help"):
            print_help()
            sys.exit(0)
        else:
            query_parts.append(a)
            i += 1
    return " ".join(query_parts).strip(), model or LOCAL_MODEL_DEFAULT, mode, run, show_hist, clear_hist


def main(argv):
    query, model, mode, run, show_hist, clear_hist = parse_args(argv)
    if clear_hist:
        save_history([])
        print("(_>) History cleared.")
        return 0
    if show_hist:
        show_history()
        return 0
    if not query:
        print("Usage: ai \"describe the task\" [--model M] [--run|--no-run] [--cloud|--local]", file=sys.stderr)
        return 1

    backend, raw = None, None
    try:
        if mode == "local" or (mode == "auto" and ollama_up()):
            backend = f"ollama/{model}"
            raw = ask_ollama(query, model)
        else:
            backend = f"groq/{GROQ_MODEL_DEFAULT}"
            try:
                raw = ask_groq(query)
            except urllib.error.HTTPError as e:
                print(f"(_>) Groq HTTP error {e.code}: check your API key (`i-Haklab setapikey` -> groq).", file=sys.stderr)
                return 1
            if raw is None:
                print("(_>) Neither local Ollama nor GROQ_API_KEY is available.", file=sys.stderr)
                print("    - Local: install ollama and run `ollama pull qwen2.5-coder:1.5b`.", file=sys.stderr)
                print("    - Cloud: `i-Haklab setapikey` -> groq (free key at https://console.groq.com).", file=sys.stderr)
                return 2
    except (urllib.error.URLError, TimeoutError, ConnectionError) as e:
        print(f"(_>) Backend failure ({backend}): {e}", file=sys.stderr)
        return 1

    cmd = clean_command(raw or "")
    if not cmd:
        print("(_>) The AI did not return a valid command; raw response:", file=sys.stderr)
        print((raw or "").strip()[:1000], file=sys.stderr)
        return 1

    print(f"[{backend}] {query}\n➤ {cmd}")
    log_history(query, cmd, backend, model)

    if run is True:
        return subprocess.run(cmd, shell=True).returncode
    if run is False:
        return 0
    try:
        ans = input("Run it? [y/N]: ").strip().lower()
    except (EOFError, KeyboardInterrupt):
        print()
        return 1
    if ans in ("y", "yes"):
        return subprocess.run(cmd, shell=True).returncode
    return 0


if __name__ == "__main__":
    sys.exit(main(sys.argv[1:]))
