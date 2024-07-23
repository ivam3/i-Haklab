#ifndef DOM_ELEMENTS_HPP
#define DOM_ELEMENTS_HPP

#include <memory>

namespace haklab {
  class Node;
  using Element = std::shared_ptr<Node>;
  using Elements = std::vector<Element>;  

  Element text(std::string text);
  Element gauge(float progress);
  Element vbox(Elements);
}

#endif  // DOM_ELEMENTS_HPP
