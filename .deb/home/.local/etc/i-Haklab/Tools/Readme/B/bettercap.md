**bettercap** is the Swiss Army knife for 802.11, BLE and Ethernet networks reconnaissance and attacks.

## How to Install

A [precompiled version is available](https://github.com/bettercap/bettercap/releases) for each release, alternatively you can use the latest version of the source code from this repository in order to build your own binary.

Make sure you have a correctly configured **Go >= 1.8** environment, that `$GOPATH/bin` is in `$PATH`, that the `libpcap-dev` and `libnetfilter-queue-dev` (this one is only required on Linux) package installed for your system and then:

    $ go get github.com/bettercap/bettercap
    $ cd $GOPATH/src/github.com/bettercap/bettercap
    $ make build && sudo make install

This command will download bettercap, install its dependencies, compile it and move the `bettercap` executable to `/usr/local/bin`. 

Now you can use `sudo bettercap -h` to show the basic command line options and just `sudo bettercap` to start an 
[interactive session](https://github.com/bettercap/bettercap/wiki/Interactive-Mode) on your default network interface, otherwise you can [load a caplet](https://github.com/bettercap/bettercap/wiki/Caplets).

Once bettercap is installed, you can download/update system caplet with the command:

    sudo bettercap -eval "caplets.update; q"

## Update

In order to update to an unstable but bleeding edge release from this repository, run the commands below:

    $ go get -u github.com/bettercap/bettercap
    $ cd $GOPATH/src/github.com/bettercap/bettercap
    $ make build && sudo make install

## Documentation and Examples

The project is documented [in this wiki](https://github.com/bettercap/bettercap/wiki).

## License

`bettercap` is made with ♥  by [the dev team](https://github.com/orgs/bettercap/people) and it's released under the GPL 3 license.
