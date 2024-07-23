#include "../../include/screen/box.hpp"
#include <algorithm>

namespace haklab {
/// @return   la caja más grande  que contiene ambos |a| y |b|.
/// @ingroup screen
// static
Box Box::Intersection(Box a, Box b) {
  return Box{
      std::max(a.x_min, b.x_min),
      std::min(a.x_max, b.x_max),
      std::max(a.y_min, b.y_min),
      std::min(a.y_max, b.y_max),
  };
}

/// @return   la caja más pequeña que contiene ambos |a| y |b|..
/// @ingroup screen
// static
Box Box::Union(Box a, Box b) {
  return Box{
      std::min(a.x_min, b.x_min),
      std::max(a.x_max, b.x_max),
      std::min(a.y_min, b.y_min),
      std::max(a.y_max, b.y_max),
  };
}

/// @return    si (x,y) está contenido dentro de la caja.
/// @ingroup screen
bool Box::Contain(int x, int y) const {
  return x_min <= x &&  //
         x_max >= x &&  //
         y_min <= y &&  //
         y_max >= y;
}

/// @return si la caja esta vasia.
/// @ingroup screen
bool Box::IsEmpty() const {
  return x_min > x_max || y_min > y_max;
}

/// @return si |other| es lo mismo que |this|
/// @ingroup screen
bool Box::operator==(const Box& other) const {
  return (x_min == other.x_min) && (x_max == other.x_max) &&
         (y_min == other.y_min) && (y_max == other.y_max);
}

/// @return si |other| y |this| son diferte .
/// @ingroup screen
bool Box::operator!=(const Box& other) const {
  return !operator==(other);
}

}  // namespace haklab
