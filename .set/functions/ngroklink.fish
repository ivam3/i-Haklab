function ngroklink
   curl -sSL http://localhost:4040/api/tunnels|cut -d '"' -f14|awk -F '/' '{print $argv3}'|cut -d ':' -f1,2,3
end
