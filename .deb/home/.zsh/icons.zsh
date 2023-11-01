# Define una matriz asociativa llamada "icons" que contiene iconos
typeset -gA icons

if [[ $ICON_SPACING == true ]]; then
    local s=
    local q=' '
  else
    local s=' '
    local q=
  fi

icons=(
  OK_ICON            '\u2714'               # ✔
  FAIL_ICON          '\u2718'               # ✘
  SWAP_ICON          '\uF464'$s             #  
  RAM_ICON           '\uF0E4'$s             #  
  SSH_ICON           '\uF489'$s             # 
  VPN_ICON           '\UF023'               # 
  TIME_ICON          '\U23f1'               # ⏱ 
)
