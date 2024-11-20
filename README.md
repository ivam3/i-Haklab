<div align="center">
<img
  src="/.img/I-haklab.png"
  alt="Logo de I-haklab"/>
</div>

![linea](.img/linea.gif)
<div align="center">
<a href="https://git.io/typing-svg"><img src="https://readme-typing-svg.demolab.com?font=Rubik+Wet+Paint&size=35&pause=1000&color=F77432&background=13520F00&center=verdadero&vCenter=FALSO&repeat=&random=&width=500&lines=I-Haklab+v.3+2024+by+%40Ivam3" alt="Typing SVG" /></a>
</div>


> [!NOTE]
>  The main objective of the creation of this laboratory is to transport the applications, tools and/or frameworks of a Linux computer environment to the palm of the user's hand thanks to the portability that the Android operating system can provide us. We hope that this project will help contribute to the cybersecurity community and that people can develop efficient countermeasures. The use of i-Haklab without prior mutual consistency may lead to illegal activity. It is the end user's responsibility to obey all applicable local, state, and federal laws. The authors take no responsibility and are not responsible for any misuse or damage caused by this program

<div align="center">

[![Typing SVG](https://readme-typing-svg.demolab.com?font=Itim&size=45&pause=1000&color=F7BF36&center=verdadero&vCenter=FALSO&repeat=verdadero&random=FALSO&width=435&height=100&lines=%F0%9F%91%87+Social+networks+%F0%9F%91%87)](https://git.io/typing-svg) 

</div>

<div align="center">
  <a href="https://www.youtube.com/c/Ivam3byCinderella" target="_blank">
    <img src="https://raw.githubusercontent.com/maurodesouza/profile-readme-generator/master/src/assets/icons/social/youtube/default.svg" width="52" height="40" alt="youtube logo"  />
  </a>
  <a href="http://github.com/ivam3" target="_blank">
    <img src="https://raw.githubusercontent.com/maurodesouza/profile-readme-generator/master/src/assets/icons/social/tryhackme/default.svg" width="52" height="40" alt="tryhackme logo"  />
  </a>
  <a href="https://whatsapp.com/channel/0029VaM2Qbd9MF8wiloJx510" target="_blank">
    <img src="https://raw.githubusercontent.com/maurodesouza/profile-readme-generator/master/src/assets/icons/social/whatsapp/default.svg" width="52" height="40" alt="whatsapp logo"  />
  </a>
  <a href="https://t.me/Ivam3bCinderella" target="_blank">
    <img src="https://raw.githubusercontent.com/maurodesouza/profile-readme-generator/master/src/assets/icons/social/telegram/default.svg" width="52" height="40" alt="telegram logo"  />
  </a>
  <!--<a href="https://t.me/ivam3_Bot" target="_blank">-->
  <!--  <img src="https://raw.githubusercontent.com/maurodesouza/profile-readme-generator/master/src/assets/icons/social/telegram/default.svg" width="52" height="40" alt="telegram logo"  />-->
  <!--</a>-->
  <!--<a href="https://www.facebook.com/ivam3" target="_blank">-->
  <!--  <img src="https://raw.githubusercontent.com/maurodesouza/profile-readme-generator/master/src/assets/icons/social/telegram/default.svg" width="52" height="40" alt="telegram logo"  />-->
  <!--<a href="https://www.instagram.com/_ivam3" target="_blank">-->
  <!--  <img src="https://raw.githubusercontent.com/maurodesouza/profile-readme-generator/master/src/assets/icons/social/telegram/default.svg" width="52" height="40" alt="telegram logo"  />-->
  <!--<a href="https://x.com/_ivam3" target="_blank">-->
  <!--  <img src="https://raw.githubusercontent.com/maurodesouza/profile-readme-generator/master/src/assets/icons/social/telegram/default.svg" width="52" height="40" alt="telegram logo"  />-->
  <!--</a>-->
  </a>
  </a>
</div>


##### To get help join to our support groups over [Telegram group](https://t.me/iHaklab) or over our IRC group running in [i-Haklab]() the command :
```bash
i-Haklab weechat
```

### 🤔 What is Termux?
> [Termux](https://github.com/termux/termux-app) is a terminal emulator application that shares the same environment of the Android operating system by starting the command line of the program `shell` using the system call `execve` and redirecting the input, output and standard error flows to the screen. [Termux](https://github.com/termux/termux-app) has a vast number of packages under the `apt` manager compiled with Android NDK and patched for compatibility, generally available on GNU/Linux systems.


### 🤔 What is i-Haklab?
> [i-Haklab]() is a hacking laboratory for [Termux](https://github.com/termux/termux-app) that contains [open source tools](https://github.com/ivam3/termux-packages) for osint, pentesting, scan/find vulnerabilities, exploitation and post-exploitation recommended for me [Ivam3](https://wlo.link/@Ivam3) with automation commands, a many guides, books and tutorials to learn how to use tools. [i-Haklab]() use oh my fish insteractive shell to provide core infrastructure to allow you to install packages which extend or modify the look of your termux. To get help about shell and its use going to [OMF official site](https://fishshell.com/docs/current/tutorial.html).


### 📦 INSTALLATION.
- OPTION 1 (RECOMMEND): ADDING AT APT SOURCES LIST
```bash
yes|apt install wget gnupg && \
mkdir -p $PREFIX/etc/apt/sources.list.d && \
wget https://raw.githubusercontent.com/ivam3/termux-packages/gh-pages/ivam3-termux-packages.list -O \
$PREFIX/etc/apt/sources.list.d/ivam3-termux-packages.list && \
curl -fsSL "https://raw.githubusercontent.com/ivam3/termux-packages/gh-pages/dists/stable/public_key.gpg" \
|gpg --dearmor|tee "$PREFIX/etc/apt/trusted.gpg.d/ivam3.gpg" >/dev/null && \
apt update && apt install i-haklab
```

- OPTION 2: CLONING THIS REPOSITORY:
```bash
git clone https://github.com/ivam3/i-Haklab \
cd i-Haklab \
chmod +x setup \
bash setup
```

### 🧠 i-Haklab will ...
- Provides a diferent types of prompt with command:
```bash
omf theme
```
- Provides a login session by password(default=Ivam3byCinderella) or fingerprint(depends features device). It could set running:
```bash
i-Haklab passwd set
```
Or change it running:
```bash
i-Haklab passwd new
```
- Let you change the banner running:
```bash
i-Haklab setbanner
```
- Let you change the username running:
```bash
i-Haklab setuser
```
- Let you update Termux system package by package running:
```bash
i-Haklab aptup
```
- Provide you test your bandwidth network running:
```bash
i-Haklab speedtest
```
- Bring you a main activity from apk file running:
```bash
i-Haklab apkactivity
```
- Create a Termux backup and/or restore it running:
```bash
i-Haklab backup
```
- Automate brute force attacks running:
```bash
i-Haklab bruteforce
```
- Let you interact with all OpenAI modules running:
```bash
i-Haklab chatGPT
```
- Add your API key running:
```bash
i-Haklab setapikey
```
- Encode|decode secret message into a ASCII file running:
```bash
i-Haklab ESmsg
```
- Bring you a fake indentity card with real email and phone number running:
```bash
i-Haklab fakeID
```
- Provide you a port forwarding tunnel with a custom subdomain running:
```bash
i-Haklab tunnel
```
- Automate metasploit common process running:
```bash
i-Haklab msf
```
- Provide you the ngrok link running:
```bash
i-Haklab ngroklink
```
- Provide you a ngrok ssh connection running:
```bash
i-Haklab ngrokssh
```
- Hide a Reverse Shell with a Video File by Exploiting Linux OS running:
```bash
i-Haklab payvid
```
- Let you get information about telephone number running:
```bash
i-Haklab phonescan
```
- Provide you with a web site server running over your device with [Termux](https://github.com/termux/termux-app), wich will you can share several files over all internet. Enable it running:
```bash
i-Haklab share
```
- Test usb device connected via OTG running:
```bash
i-Haklab usbtest
```
- Provide you with deliberately vulnerable web site servers as [bWAPP](http://www.itsecgames.com/), [DVWA](https://dvwa.co.uk/) and [MUTILLIDAE](https://github.com/webpwnized/mutillidae) to practice your hacking skills searching, finding and exploiting the most common vulnerabilities. Enable those running:
```bash
i-Haklab servers4test
```
- Provide you more than [100 tools/frameworks](https://github.com/ivam3/termux-packages) with an easy install/remove over command `apt`. You can get the list of all availables running :
```bash
i-Haklab show alltools
```
![i-Haklab show alltools](./.img/alltools.jpg)
##### If you want to suggest some tool, do it in the section of suggestions of our [Telegram BOT](https://t.me/Ivam3_Bot).


### 🪄 COMMANDS
> There are several commands in [i-Haklab]() that facilitate the use of [Termux](https://github.com/termux/termux-app):

- [i-Haklab](): it is the main command that helps with automations of various processes such as visualization of user guides for the tools, download of hacking books, access to the community tutorials, payload creation automation, metaploit handler activation, brute force attacks among others. See all features running:

 <details>
<summary>**List** ↩️   </summary>

```bash
i-Haklab help
```
- Ask to Cinderella. A virtual assist exclusively about Termux themes:
```bash
cinderella
```
- Mannage android main settings over Termux:
```bash
cmd
```
- Search repositories in github over CLi:
```bash
gitbrowswering
```
- Returns the private ip of your local network:
```bash
LOCALHOST
```
- Manage internal/external storage with graphical interface:
```bash
adminfiles
```
- Run OSINT setoolkit:
```bash
osrframework
```
- Enable proxy connection by proxychains4:
```bash
proxy
```
- Provides information about the mounted memory:
```bash
df
```
- Provides recursive information about the weight of directories and files:
```bash
du
```
- Use the easy and faster Fuzzy finder:
```bash
fzf
```
- Get your public internet protocol(IP):
```bash
mypip
```
- Privide you with a root enviroment as root user(on rooted device) or fake root user(on NOT rooted device):
```bash
sudo root
````
- Or just run any command(s) with:
```bash
sudo <some command>
```
- Enable the php server:
```bash
serverphp
```
- Enable the apache server:
```bash
serverapache start/stop/restart
```
- Enables postgresql database:
```bash
postgresql start/stop/restart
```
- Remove current session cache, temporal files & residual APT packages:
```bash
rmcache
```
- Init a shell to translate any text:
```bash
traductor
```
- We know that each Android is different and this can generate various errors in the installation processes of ruby gems, python modules, among others. Automates the solving processes running:
```bash
fixer
```
- Block the termux screen and it will only be unlocked with said password or your fingerprint. It is worth mentioning that these access codes are encrypted for your security.
```bash
lock
```
</details>


### 🎴 DESKTOP ENVIROMENT
> [i-Haklab]() automates the installation and configuration of a graphical environment with the xfce4 windows manager, which opens up the possibility of running tools such as wireshark and burpsuite. For this, the installation of the [Termux:Wayland](https://github.com/termux/termux-x11) application is required. Once installed it to run this enviroment just execute:
```bash
apt install termux-desktop-xfce \
i-Haklab Xwayland
```
![TermuxWayland](/.img/TermuxWayland.jpg)


### 📖 IRC CHAT Ivam3byCinderella
> IRC (Internet Relay Chat) is an application layer protocol that facilitates communication in the form of text. The chat process works on a client/server networking model. Under the command <i-Haklab> we will find the <weechat> argument, with which you can join the official IRC Ivam3byCinderella where u can contact another i-Haklab.


### 📕 BOOKS AVAILABLES
![booksTermux](/.img/books_Termux.jpg)
##### If you want to suggest some book do it in the section of suggestions of our [Telegram BOT](https://t.me/Ivam3_Bot).

<div align="center">

![alt text](/.img/png.png)  

</div>


### 🔥 UPDATE AT NEWEST VERSION 
> [i-Haklab]() is constantly updating tools and improvements. To stay updated you just have to run:
```bash
apt update i-haklab
```


##### Join to our community [Ivam3byCinderella](https://wlo.link/@Ivam3) and check all stuffs we have for you.
