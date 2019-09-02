function myip
	proxychains4 w3m cualesmiip.com | grep "IP real"
end
