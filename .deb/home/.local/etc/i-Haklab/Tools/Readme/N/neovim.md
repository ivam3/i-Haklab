### What is neovim?
Neovim is a text editor rewrite of vim in Lua with the goal of modularizing the code to make it 
more maintainable and easier to contribute to. As the official website says :
“Neovim is built for users who want the good parts of Vim, and more.”

For more info join to : https://neovim.info

i-Haklab pre-configue neovim with text predictible in bash, python, ruby, C++ and markdown but,
you can reconfigigure it manually following the guide in :

> https://victorh028.github.io/NVIM/#

Neovim Cheat Sheet in i-Haklab


esc               **mode normal**
 |                   ╰──➤  
 |                   ╰──➤  
 |                   ╰──➤ b    Realiza un salto palabra en sentido contr 
 |                   ╰──➤ e    Realiza un salto palabra por palabra   
 |                   ╰──➤ 0    Resliza un salto al comienso de la linea
 |                   ╰──➤ $    Realiza un salto al final de la linea   
 |                   ╰──➤ gg   Da un salto al inicio del archivo 
 |                   ╰──➤ G    Da un salto al final de la linea 
 |                   ╰──➤ d    Delete the current line
 |                   ╰──➤ r    Replace one character
 |                   ╰──➤ R    Heplace all the line
 |                   ╰──➤ .    Repeat the last action
 |                   ╰──➤ u    Undo the last modification one by one 
 |                   ╰──➤ U    Restore all the modifications
 |                   ╰──➤ gc   Comment/uncomment line 
 |
 ╰──➤        +  <ctrl>
 |                   ╰──➤ t    Open a terminal in neovim
 |                   ╰──➤ d    Go to the next page
 |
 ╰──➤        +  <leader>   
                     ╰──➤ w    Save file
                     ╰──➤ x    Save file and exit
                     ╰──➤ -    Split the window horizontally
                     ╰──➤ |    Split the window vertically
                     ╰──➤ n    Open prompt to interact with chatGPT (openAI) # Requires API key

a                 **mode editor** 
                    ╰──➤  
                    ╰──➤ esc  Return to mode normal 

v or V            **mode visual**
                    ╰──➤  
                    ╰──➤ c    cut the selected text
                    ╰──➤ y    copy the selected text
                    ╰──➤ p    paste the selected text

:                 **mode command** (only in mode normal)
                    ╰──➤ PlugUpdate   Update the plugins
                    ╰──➤ PlugInstall  Install the plugins
                    ╰──➤ PlugStatus   Get neovim status 


# Config 
`~/.config/nvim/init.lua`


