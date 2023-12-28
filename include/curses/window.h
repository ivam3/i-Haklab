//
// Autor : @demon_rip  
#pragma once 

#include <cstdint>


namespace Key {

typedef uint64_t Type;

const Type None = -1;

// modifier masks
const Type Special = Type{1} << 63;
const Type Alt     = Type{1} << 62;
const Type Ctrl    = Type{1} << 61;
const Type Shift   = Type{1} << 60;

// useful names
const Type Null      = 0;
const Type Space     = 32;
const Type Backspace = 127;

// ctrl-?
const Type Ctrl_A            = 1;
const Type Ctrl_B            = 2;
const Type Ctrl_C            = 3;
const Type Ctrl_D            = 4;
const Type Ctrl_E            = 5;
const Type Ctrl_F            = 6;
const Type Ctrl_G            = 7;
const Type Ctrl_H            = 8;
const Type Ctrl_I            = 9;
const Type Ctrl_J            = 10;
const Type Ctrl_K            = 11;
const Type Ctrl_L            = 12;
const Type Ctrl_M            = 13;
const Type Ctrl_N            = 14;
const Type Ctrl_O            = 15;
const Type Ctrl_P            = 16;
const Type Ctrl_Q            = 17;
const Type Ctrl_R            = 18;
const Type Ctrl_S            = 19;
const Type Ctrl_T            = 20;
const Type Ctrl_U            = 21;
const Type Ctrl_V            = 22;
const Type Ctrl_W            = 23;
const Type Ctrl_X            = 24;
const Type Ctrl_Y            = 25;
const Type Ctrl_Z            = 26;
const Type Ctrl_LeftBracket  = 27;
const Type Ctrl_Backslash    = 28;
const Type Ctrl_RightBracket = 29;
const Type Ctrl_Caret        = 30;
const Type Ctrl_Underscore   = 31;

// duplicados útiles
const Type Tab    = 9;
const Type Enter  = 13;
const Type Escape = 27;

// valores especiales, más allá de un byte
const Type Insert   = Special | 256;
const Type Delete   = Special | 257;
const Type Home     = Special | 258;
const Type End      = Special | 259;
const Type PageUp   = Special | 260;
const Type PageDown = Special | 261;
const Type Up       = Special | 262;
const Type Down     = Special | 263;
const Type Left     = Special | 264;
const Type Right    = Special | 265;
const Type F1       = Special | 266;
const Type F2       = Special | 267;
const Type F3       = Special | 268;
const Type F4       = Special | 269;
const Type F5       = Special | 270;
const Type F6       = Special | 271;
const Type F7       = Special | 272;
const Type F8       = Special | 273;
const Type F9       = Special | 274;
const Type F10      = Special | 275;
const Type F11      = Special | 276;
const Type F12      = Special | 277;
const Type Mouse    = Special | 278;
const Type EoF      = Special | 279;

}
