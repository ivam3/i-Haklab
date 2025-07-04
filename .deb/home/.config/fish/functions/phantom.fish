function phantom
    set phantom_limit (/system/bin/dumpsys activity settings |\
        grep max_phantom_processes | awk -F "=" '{print $NF}')
    
    if test $phantom_limit = "32"
        adb shell pm grant com.termux android.permission.PACKAGE_USAGE_STATS
        adb shell pm grant com.termux android.permission.DUMP
        adb shell "/system/bin/device_config put activity_manager max_phantom_processes 2147483647"
        set phantom_limit (/system/bin/dumpsys activity settings |\
            grep max_phantom_processes | awk -F "=" '{print $NF}')
    end
    
    echo "The limit of phantom process is: $phantom_limit"
end
