#!/data/data/com.termux/files/usr/bin/bash

#set colored=true to turn on colored error messages
#set colored=false to turn off colored error messages
colored=true

#red=1 green=2 yellow=3
color() {
	if [ $colored == "true" ]; then
		echo "$(tput setaf $1)${*:2}$(tput sgr0)"
	else
		echo "${*:2}"
	fi
}

show_usage() {
	echo -e "\n`color 3 Usage:`\n"
	echo 'sudo su [-]'
	echo -e "  `color 2 Drop to root shell`\n"
	echo 'sudo <command> [<args>]'
	echo -e "  `color 2 Run command as root with optional arguments`\n"
	exit
}

SYSBIN=/system/bin
SYSXBIN=/system/xbin
BB=$SYSXBIN/busybox
PRE=/data/data/com.termux/files
ROOT_HOME=$PRE/home/.suroot
BINPRE=$PRE/usr/bin
LDLP="export LD_LIBRARY_PATH=$PRE/usr/lib"
CMDLINE="PATH=$PATH:$SYSXBIN:$SYSBIN;$LDLP;HOME=$ROOT_HOME;cd $PWD"

if [ -x $SYSXBIN/su ]; then
	SU=$SYSXBIN/su
elif [ -x /su/bin/su ]; then
	SU=/su/bin/su
elif [ -x /sbin/su ]; then
	SU=/sbin/su
else
	echo -e "\n`color 1 su` executable not found"
	echo -e "`color 1 sudo` requires `color 1 su`\n"
	exit
fi

if [ ! -d $ROOT_HOME ]; then
	if [ -x $BB ] && [ $($BB --list | grep -w mount) == "mount" ]; then
		MOUNTEX="$BB mount"
	elif [ -x $SYSBIN/mount ]; then
		MOUNTEX="$SYSBIN/mount"
	else
		echo -e "\nCannot find `color 1 mount` executable"
		echo -e "`color 2 Unable to setup sudo`\n"
		exit
	fi
	MOUNT_RW="$MOUNTEX -o rw,remount,rw /system"
	MOUNT_RO="$MOUNTEX -o ro,remount,ro /system"
	$SU -c "$MOUNT_RW"
	$SU -c "mkdir $ROOT_HOME"
	$SU -c "chmod 700 $ROOT_HOME"
	BASHRC="'PS1=\"# \"\nexport TERM=$TERM\n$LDLP\nexport PATH=$PATH:$SYSXBIN:$SYSBIN'"
	$SU -c "echo -e $BASHRC > $ROOT_HOME/.bashrc"
	$SU -c "chmod 700 $ROOT_HOME/.bashrc"
	$SU -c "$MOUNT_RO"
fi

ARGS=$(printf '%q ' "$@")

if [ -z "$*" ]; then
	show_usage
elif [ $1 == "su" ]; then
	CMDLINE="$CMDLINE;$BINPRE/bash"
elif [ -x "$BINPRE/$1" ]; then
	CMDLINE="$CMDLINE;$BINPRE/$ARGS"
elif [ -x $SYSBIN/$1 ] || [ -x $SYSXBIN/$1 ] || [ -x $1 ]; then
	CMDLINE="$CMDLINE;$ARGS"
else
	echo -e "\nCommand `color 1 $1` not found"
	echo -e "`color 2 Check your spelling and try again`\n"
fi

pre_env_chk=`$SU --help|grep -e --preserve-environment`
if [ -n "$pre_env_chk" ]; then
        $SU --preserve-environment -c "$CMDLINE"
else
        $SU -c "$CMDLINE"
fi

# Reset echo
stty sane
