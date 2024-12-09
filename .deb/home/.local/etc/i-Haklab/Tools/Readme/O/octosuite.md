
Octosuite has been installed succesfully!
To launch it, just enter ``octosuite`` in your terminal, that should open a session.

> Upon launch, Octosuite will attempt to create 3 directories (.logs, output, downloads) if they don't already exist.
* .logs: is where the logs of each session will be kept.
* output: is where csv files will be kept.
* downloads: is where the source code from the ``source`` command will be stored.

>> Termux users (non-rooted) will have to manually create the directories.

Now it's time to start investigating.
Octosuite features work with subcommands.
The following are basic commands that will get you started.

## Basic commands
| Command | Description |
|---------|:-----------:|
| help    | Help menu   |
| exit    | Close session|
| clear   | Clear screen |
| about   | Program info |
| author  | Author info |


> **Note**:
The following are subcommands for the ``help`` command. This means that you can use other commands together with ``help``.
>> The syntax for subcommands is 
``[core command]:[subcommand]``

**Example**:

To list all user investigation commands, you use the following command:
```
help:user
```

## Help subcommands
| Command | Description |
|---------|:-----------:|
| csv | (coming soon) |
| org | List all organization investigation commands |
| logs    | List all logs management commands |
| repo    | List all repository investigation commands |
| user    | List all user investigation commands
| search  | List all target discovery commands
| source | (beta) List all source code downloaing commands (for developers)
| version  | List all version management commands |

> **Note**:
If an invalid command is entered, Octosuite will not print out anything, it will instead return the command prompt.

>> This will go on as long as invalid commands are being entered.