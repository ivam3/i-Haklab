## Disclaimer ##

Any actions and or activities related to the code provided is solely your responsibility.The misuse of the information in this website can result in criminal charges brought against the persons in question. The authors will not be held responsible in the event any criminal charges be brought against any individuals misusing the information in this tool to break the law.

# SlowHTTPTest #

[![Build Status](https://travis-ci.org/shekyan/slowhttptest.svg?branch=master)](https://travis-ci.org/shekyan/slowhttptest)

SlowHTTPTest is a highly configurable tool that simulates some Application Layer Denial of Service attacks by prolonging HTTP connections in different ways.

Use it to test your web server for DoS vulnerabilites, or just to figure out how many concurrent connections it can handle.
SlowHTTPTest works on majority of Linux platforms, OS X and Cygwin - a Unix-like environment and command-line interface for Microsoft Windows, and comes with a Dockerfile to make things even easier.

Check out [Wiki](https://github.com/shekyan/slowhttptest/wiki) for installation and usage details.

Latest official image is available at [Docker Hub](https://hub.docker.com/repository/docker/shekyan/slowhttptest):
`docker pull shekyan/slowhttptest:latest`

# Running test ##

Slowloris and Slow HTTP POST DoS attacks rely on the fact that the HTTP protocol, by design, requires requests to be completely received by the server before they are processed. If an HTTP request is not complete, or if the transfer rate is very low, the server keeps its resources busy waiting for the rest of the data. If the server keeps too many resources busy, this creates a denial of service. This tool is sending partial HTTP requests, trying to get denial of service from target HTTP server.

Slow Read DoS attack aims the same resources as slowloris and slow POST, but instead of prolonging the request, it sends legitimate HTTP request and reads the response slowly. The command to run the attack to check if the server is the following one:

         ]> run slowhttptest -c 500 -H -g -o ./output_file -i 10 -r 200 -t GET -u http://yourwebsite-or-server-ip.com -x 24 -p 2


# The command is described as next:

-c: Specifies the target number of connections to establish during the test (in this example 500, normally with 200 should be enough to hang a server that doesn't have protection against this attack).

-H: Starts slowhttptest in SlowLoris mode, sending unfinished HTTP requests.

-g: Forces slowhttptest to generate CSV and HTML files when test finishes with timestamp in filename.

-o: Specifies custom file name, effective with -g.

-i: Specifies the interval between follow up data for slowrois and Slow POST tests (in seconds).

-r: Specifies the connection rate (per second).

-t: Specifies the verb to use in HTTP request (POST, GET etc).

-u: Specifies the URL or IP of the server that you want to attack.

-x: Starts slowhttptest in Slow Read mode, reading HTTP responses slowly.

-p: Specifies the interval to wait for HTTP response onprobe connection, before marking the server as DoSed (in seconds).
