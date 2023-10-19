clang++  -o i-haklab  i-haklab_0.1.cpp below_zero_v_0.1.so -lcurl -lssh
ld.lld: error: undefined symbol: hack::Haklab::syntax_highlight(std::__ndk1::basic_string<char, std::__ndk1::char_traits<char>, std::__ndk1::allocator<char>> const&)
>>> referenced by i-haklab_0.1.cpp
>>>               /data/data/com.termux/files/usr/tmp/i-haklab_0-1d3927.o:(main)
clang-16: error: linker command failed with exit code 1 (use -v to see invocation)
make: *** [Makefile:16: i-haklab] Error 1
