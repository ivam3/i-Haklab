# OrbitalDump

A simple multi-threaded distributed SSH brute-forcing tool written in Python.

![image](https://user-images.githubusercontent.com/21986859/120943808-33072b00-c6ff-11eb-8386-b64a0ba2a12c.png)

## How it Works

When the script is executed without the `--proxies` switch, it acts just like any other multi-threaded SSH brute-forcing scripts. When the `--proxies` switch is added, the script pulls a list (usually thousands) of SOCKS4 proxies from [ProxyScrape](https://proxyscrape.com/) and launch all brute-force attacks over the SOCKS4 proxies so brute-force attempts will be less likely to be rate-limited by the target host.

## Installation

You can install OrbitalDump through pip.

```shell
pip install -U --user orbitaldump
orbitaldump
```

Alternatively, you can clone this repository and run the source code directly.

```shell
git clone https://github.com/k4yt3x/orbitaldump.git
cd orbitaldump
python -m orbitaldump
```

## Usages

A simple usage is shown below. This command below:

- `-t 10`: launch 10 brute-forcing threads
- `-u usernames.txt`: read usernames from usernames.txt (one username per line)
- `-p passwords.txt`: read passwords from passwords.txt (one password per line)
- `-h example.com`: set brute-forcing target to `example.com`
- `--proxies`: launch attacks over proxies from ProxyScrape

```shell
python -m orbitaldump -t 10 -u usernames.txt -p passwords.txt -h example.com --proxies
```

## Full Usages

You can obtain the full usages by executing OrbitalDump with the `--help` switch. The section below might be out-of-date.

```console
usage: orbitaldump [--help] [-t THREADS] [-u USERNAME] [-p PASSWORD] -h HOSTNAME [--port PORT] [--timeout TIMEOUT] [--proxies]

optional arguments:
  --help                show this help message and exit
  -t THREADS, --threads THREADS
                        number of threads to use (default: 5)
  -u USERNAME, --username USERNAME
                        username file path (default: None)
  -p PASSWORD, --password PASSWORD
                        password file path (default: None)
  -h HOSTNAME, --hostname HOSTNAME
                        target hostname (default: None)
  --port PORT           target port (default: 22)
  --timeout TIMEOUT     SSH timeout (default: 6)
  --proxies             use SOCKS proxies from ProxyScrape (default: False)
```
