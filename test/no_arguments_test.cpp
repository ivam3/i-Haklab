#include <boost/test/unit_test.hpp>

#include "../include/command_line_argument_parser.h"

BOOST_AUTO_TEST_CASE(recognises_no_supplied_arguments) {
  command_line_argument_parser parser;
  const char *argv[] = {"app"};
  auto args = parser.parse(sizeof(argv)/sizeof(*argv), argv);

  BOOST_CHECK(args.no_arguments());
}
