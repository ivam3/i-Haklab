# Define una matriz asociativa llamada "icons" que contiene iconos
typeset -gA icons

function init_icons() {
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
  HOME_ICON          '\uF015'$s             # 
  SERVER_ICON        '\uF233'$s             # 
  ETC_ICON             '\u2699'               # ⚙
)
}
# Lamentablemente, esto es una parte de la API pública. Su uso se desaconseja enfáticamente.
function print_icon() {
  eval "$_intro"
  init_icons
  local var=DEMON_$1
  if (( $+parameters[$var] )); then
    echo -n - ${(P)var}
  else
    echo -n - $icons[$1]
  fi
}

# Imprime una lista de iconos configurados. 
# 
# * $ 1 cadena - Si "original", se imprimen los iconos originales, 
# de lo contrario "print_icon" se usa, lo que lleva a los usuarios 
# anular en cuenta. 
function get_icon_names() {
  eval "$_intro"
  init_icons
  local key
  for key in ${(@kon)icons}; do
    echo -n - "DEMON_$key: "
    print -nP "%K{red} %k"
    if [[ $1 == original ]]; then
      echo -n - $icons[$key]
    else
      print_icon $key
    fi
    print -P "%K{red} %k"
  done
}