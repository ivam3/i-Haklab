#ifndef SYNTAX_HIGHLIGHTER_HPP
#define SYNTAX_HIGHLIGHTER_HPP

#include <iostream>
#include <string>

enum class Color {
  Default,
  Black,
  Red,
  Green,
  Yellow,
  Blue,
  Magenta,
  Cyan,
  White
};

class SyntaxHighlighter {
public:
  std::string setColor(Color color);
  void highlight(const std::string &code);
};
// no miembro
void startSyntax(const std::string &code);

#endif // SYNTAX_HIGHLIGHTER_HPP
