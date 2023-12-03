# Binary Safe String functions


If you use PHP's mbstring.func_overload, or the server you are running on has it enabled, you are in trouble. Especially if you are relying on being able to parse binary data and protocols.

## Introduction

To the question "Should I use multi-byte overloading (mbstring.func_overload)?". user 'gphilip' said it well on this 
StackOverflow post: 
http://stackoverflow.com/questions/222630/should-i-use-multi-byte-overloading-mbstring-func-overload

  > My answer is: definitely not!
  > 
  > The problem is that there is no easy way to "reset" 
  > str* functions once they are overloaded.
  > 
  > For some time this can work well with your project,
  > but almost surely you will run into an external library
  > that uses string functions to, for example, implement a
  > binary protocol, and they will fail. They will fail and
  > you will spend hours trying to find out why they are
  > failing.

## Description

This class is a wrapper for string functions, in cases where the mbstring.func_overload tripe have been enabled. 
Be warned, use this class ONLY if you have to, as it *will* affect performance a bit. For some functions, a lot, 
though that is due to problems in mb_string, not this class.
Function calls in PHP are fairly expensive on their own, and if func_overload is enabled, it'll use mb_string 
functions exclusively in place of the built-in PHP string, to parse them as 'latin1', which is also expensive, cpu 
wise.

### Why the potential performance impact?

PHP, like Java, have length aware strings, meaning the object header knows how long your string is. They are binary 
safe, and not null (0x00) terminated.

mb_string functions ignore that, and parse the entirety of the string, to figure out what is what. strlen(string) 
simply tells you how many bytes are in it, mb_strlen will parse it, to find multi byte characters, and tell you
how many characters there are. That is great for handling multi-byte encoded strings correctly, such as UTF-8, it
sucks for binary data handling, as multi-byte sequences are bound to occur by random chance, in any large enough 
binary data set.
