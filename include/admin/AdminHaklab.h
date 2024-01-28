#pragma once

#include <iostream>
#include <set>
namespace admin {
class AdminHaklab {
public:
  std::set<std::string> matchingFile(const std::string &from);
};
} // namespace admin
