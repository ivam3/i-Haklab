# DoS-A-Tool v.1.5

        Denail of Service Attack Tool (DoS-A-Tool)

A distributed denial-of-service (DDoS) attack is an attack in which multiple compromised computer systems attack a target, such as a server, website or other network resource, and cause a denial of service for users of the targeted resource. The flood of incoming messages, connection requests or malformed packets to the target system forces it to slow down or even crash and shut down, thereby denying service to legitimate users or systems.

# INSTALLATION
        $ yes|apt install git perl

        $ git clone https://github.com/ivam3/DoS-A-Tool.git

        $ cd DoS-A-Tool

        $ chmod 751 DoS-A-Tool

# USAGE

- For get a help menu :

        $ perl DoS-A-Tool --help

- Start attack :

        $ perl DoS-A-Tool 0.0.0.0
        $ perl DoS-A-Tool 0.0.0.0 --port 1985
        $ perl DoS-A-Tool 0.0.0.0 --port 1985 --size 1000 --time 43200
        $ perl DoS-A-Tool 0.0.0.0 --port 1985 --time 43200 --bandwidth 25000 --delay 500

- Defaults:
  * random destination UDP ports are used unless --port is specified.
  * random-sized packets are sent unless --size or --bandwidth is specified.
  * flood is continuous unless --time is specified.
  * flood is sent at line speed unless --bandwidth or --delay is specified.

- Usage guidelines:
  * --size parameter is ignored if both the --bandwidth and the --delay
    parameters are specified.
  * Packet size is set to 256 bytes if the --bandwidth parameter is used.
    without the --size parameter
  * --time duration of the execution of the attack in seconds.
  * --bandwidth specify the bandwidth to use in kbps.
  * --delay interval in milliseconds(msec) between sending packets.

  * The specified packet size is the size of the IP datagram (including IP and
    UDP headers). Interface packet sizes might vary due to layer-2 encapsulation.

- Warnings and Disclaimers:
  * Flooding third-party hosts or networks is commonly considered a criminal activity.
  * Flooding your own hosts or networks is usually a bad idea
  * Higher-performace flooding solutions should be used for stress/performance tests
  * Use primarily in lab environments for QoS tests.

To get help join to : https://t.me/Ivam3_Bot

# Coded by Ivam3
