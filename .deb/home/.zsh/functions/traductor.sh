#!/bin/sh

function traductor {
   gawk -f (curl -Ls git.io/translate | psub) -- -shell
}
