function phantom-ps
    # GETTING THE ACTUAL LIMIT OF PHANTOM PROCESS
    set phantom_limit (/system/bin/dumpsys activity settings |\
        grep max_phantom_processes | awk -F "=" '{print $NF}')

    if test $phantom_limit = "32"
        # GETTING THE IP OF THE DEVICE
        set IP (ifconfig 2>/dev/null \
            | grep -oE '([0-9]{1,3}\.){3}[0-9]{1,3}' \
            | grep -v 255 \
            | grep -v 127 | tail -n 1)

        echo "IP: $IP"

        set PAIR_PORT ""
        while test -z "$PAIR_PORT"
            read -P "(>_) Pairing port: " PAIR_PORT
        end

        set PAIR_CODE ""
        while test -z "$PAIR_CODE"
            read -P "(>_) Pairing code: " PAIR_CODE
        end

        set -l OUT (adb pair "$IP:$PAIR_PORT" "$PAIR_CODE" 2>&1)
        if string match -q '*Successfully paired to*' -- "$OUT"
            echo "paired to $IP:$PAIR_PORT"
        else if string match -q '*unable to*' -- "$OUT"
            echo "fail ($(string trim -- $OUT))"
            exit 1
        else
            echo "fail (unknown error)"
            exit 1
        end

        # GETTING THE LISTEN PORT OF THE DEVICE
        echo "searching for debug port ..."
        set LPORTS (nmap -sT -p 10000-65535 --open -T4 -oG - $(LOCALHOST) \
            | grep "Ports:" \
            | grep -oP '\d{5}(?=/open/tcp)' \
            | sort -u)

        for p in $LPORTS 
            set -l OUT (adb connect "$IP:$p" 2>&1)

            if string match -q '*connected to*' -- "$OUT"
                echo "connected to $IP:$p"
                break
            else
                if string match -q '*unable to connect*' -- "$OUT"
                    echo "fail (unable to connect)"
                else if string match -q '*unable to*' -- "$OUT"
                    echo "fail ($(string trim -- $OUT))"
                else
                    echo "fail (unknown error)"
                end
            end

            sleep 1
        end

        adb shell pm grant com.termux android.permission.PACKAGE_USAGE_STATS 2>&1
        adb shell pm grant com.termux android.permission.DUMP 2>&1
        adb shell "/system/bin/device_config put activity_manager max_phantom_processes 2147483647" 2>&1
        
        set phantom_limit (/system/bin/dumpsys activity settings |\
            grep max_phantom_processes | awk -F "=" '{print $NF}')
    end
    
    echo "Phantom processes limit: $phantom_limit"
end
