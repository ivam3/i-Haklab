#include <boost/program_options.hpp>
#include <fmt/core.h>
#include <string>

namespace op = boost::program_options;

// Especialización de fmt::formatter para op::options_description
template <>
struct fmt::formatter<op::options_description> {
  constexpr auto parse(format_parse_context& ctx) { return ctx.begin(); }

  template <typename FormatContext>
  auto format(const op::options_description& value, FormatContext& ctx) {
    return format_to(ctx.out(), "{}", value); // O utiliza el formato que desees
  }
};

int main(int argc, char *argv[]) {
  try {
    op::options_description b{"B"};
    b.add_options()
      ("help,h", "Hola mundo");

    op::variables_map vm;
    op::store(op::command_line_parser(argc, argv).options(b).run(), vm);
    op::notify(vm);

    fmt::print(vm.count("help") ? "{}\n" : "no\n", &b);
  }
  catch (const op::error &ex) {
    fmt::print(stderr, "{}\n", ex.what());
  }
}
