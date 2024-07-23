#ifndef HAK_SCREEN_BOX_HPP
#define HAK_SCREEN_BOX_HPP

namespace haklab {

struct Box {
  int x_min{};
  int x_max{};
  int y_min{};
  int y_max{};

  static auto Intersection(Box a, Box b) -> Box;
  static auto Union(Box a, Box b) -> Box;
  bool Contain(int x, int y) const;
  bool IsEmpty() const;
  bool operator==(const Box& other) const;
  bool operator!=(const Box& other) const;
};

}  // namespace  haklab

#endif  // HAK_SCREEN_BOX_HPP
