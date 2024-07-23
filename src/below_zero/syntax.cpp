//  autor :  @demonr_rip
// @demonr_rip
#include "../include/syntax.hpp"

std::string SyntaxHighlighter::setColor(Color color) {
  std::string code = "\033[";
  switch (color) {
    case Color::Default:
      code += "0";
      break;
    case Color::Black:
      code += "30";
      break;
    case Color::Red:
      code += "31";
      break;
    case Color::Green:
      code += "32";
      break;
    case Color::Yellow:
      code += "33";
      break;
    case Color::Blue:
      code += "34";
      break;
    case Color::Magenta:
      code += "35";
      break;
    case Color::Cyan:
      code += "36";
      break;
    case Color::White:
      code += "37";
      break;
    default:
      code += "0";
  }
  code += "m";
  return code;
}

void SyntaxHighlighter::highlight(const std::string& code) {
  std::string highlightedCode = "";
  std::string colorKeywords = setColor(Color::Blue);
  std::string colorStrings = setColor(Color::Green);
  std::string colorComments = setColor(Color::Magenta);
  std::string colorDefault = setColor(Color::Default);

  std::size_t pos = 0;
  std::size_t start = 0;
  std::size_t end = 0;

  while (pos < code.size()) {
    if (code.find("#", pos) == pos) {
      start = pos;
      end = code.find("\n", pos);
      if (end == std::string::npos) {
        end = code.size();
      }
      pos = end;
      highlightedCode +=
          colorComments + code.substr(start, end - start) + colorDefault;
    } else if (std::isalpha(code[pos])) {
      start = pos;
      while (std::isalnum(code[pos]) || code[pos] == '_') {
        pos++;
      }
      std::string keyword = code.substr(start, pos - start);
      highlightedCode += colorKeywords + keyword + colorDefault;
    } else if (code[pos] == '"' || code[pos] == '\'') {
      char delimiter = code[pos++];
      start = pos;
      while (pos < code.size() && code[pos] != delimiter) {
        pos++;
      }
      if (pos < code.size()) {
        pos++;
      }
      std::string str = code.substr(start, pos - start);
      highlightedCode += colorStrings + str + colorDefault;
    } else {
      highlightedCode += code[pos++];
    }
  }
  std::cout << highlightedCode << std::endl;
}

void startSyntax(const std::string& code) {
  SyntaxHighlighter highlight{};
  highlight.highlight(code);
}
