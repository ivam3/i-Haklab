#ifndef HAK_SCREEN_COLOR_INFO_HPP
#define HAK_SCREEN_COLOR_INFO_HPP

#include <cstdint>
#include "color.hpp"

namespace tcol {

struct ColorInfo {
  const char* name;
  uint8_t index_256;
  uint8_t index_16;
  uint8_t red;
  uint8_t green;
  uint8_t blue;
  uint8_t hue;
  uint8_t saturation;
  uint8_t value;
};

ColorInfo GetColorInfo(Color::Palette256 index);
ColorInfo GetColorInfo(Color::Palette16 index);

}  // namespace  tcol   

#endif  // HAK_SCREEN_COLOR_INFO_HPP
