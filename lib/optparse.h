/**
 * Copyright (C) 2010 Johannes Weißl <jargon@molb.org>
 * License: your favourite BSD-style license
 */

#ifndef OPTPARSE_H
#define OPTPARSE_H

#include <algorithm>
#include <cstdlib>
#include <ciso646>
#include <complex>
#include <iostream>
#include <list>
#include <map>
#include <set>
#include <sstream>
#include <stdexcept>
#include <string>
#include <vector>


namespace optparse
{
    class Callback;
    class Option;
    class OptionGroup;
    class OptionParser;


    // Class for automatic conversion from string -> anytype.
    class Value
    {
    public:

        Value() : str(), valid(false) {}

        explicit Value(const std::string &v) : str(v), valid(true) {}

        operator const char *()
        {
            return str.c_str();
        }

        operator bool()
        {
            bool t;
            return (valid && (std::istringstream(str) >> t)) ? t : false;
        }

        operator short()
        {
            short t;
            return (valid && (std::istringstream(str) >> t)) ? t : 0;
        }

        operator unsigned short()
        {
            unsigned short t;
            return (valid && (std::istringstream(str) >> t)) ? t : 0;
        }

        operator int()
        {
            int t;
            return (valid && (std::istringstream(str) >> t)) ? t : 0;
        }

        operator unsigned int()
        {
            unsigned int t;
            return (valid && (std::istringstream(str) >> t)) ? t : 0;
        }

        operator long()
        {
            long t;
            return (valid && (std::istringstream(str) >> t)) ? t : 0;
        }

        operator unsigned long()
        {
            unsigned long t;
            return (valid && (std::istringstream(str) >> t)) ? t : 0;
        }

        operator float()
        {
            float t;
            return (valid && (std::istringstream(str) >> t)) ? t : 0;
        }

        operator double()
        {
            double t;
            return (valid && (std::istringstream(str) >> t)) ? t : 0;
        }

        operator long double()
        {
            long double t;
            return (valid && (std::istringstream(str) >> t)) ? t : 0;
        }
    private:

        const std::string str;
        bool valid;
    };


    class Values
    {
    public:

        Values() : _map() {}

        const std::string &operator[](const std::string &d) const
        {
            std::map<std::string, std::string>::const_iterator it = _map.find(d);
            static const std::string empty = "";
            return (it != _map.end()) ? it->second : empty;
        }

        std::string &operator[](const std::string &d)
        {
            return _map[d];
        }

        bool is_set(const std::string &d) const
        {
            return _map.find(d) != _map.end();
        }

        bool is_set_by_user(const std::string &d) const
        {
            return _user_set.find(d) != _user_set.end();
        }

        void is_set_by_user(const std::string &d, bool yes)
        {
            if (yes)
            {
                _user_set.insert(d);
            }
            else
            {
                _user_set.erase(d);
            }
        }

        Value get(const std::string &d) const
        {
            return (is_set(d)) ? Value((*this)[d]) : Value();
        }

        typedef std::vector<std::string>::iterator iterator;
        typedef std::vector<std::string>::const_iterator const_iterator;

        std::vector<std::string> &all(const std::string &d)
        {
            return _append_map[d];
        }

        const std::vector<std::string> all(const std::string &d) const
        {
            static const std::vector<std::string> empty;
            return (_append_map.find(d) == _append_map.end()) ?
                empty :
                _append_map.at(d);
        }

    private:

        std::map<std::string, std::string> _map;
        std::map<std::string, std::vector<std::string> > _append_map;
        std::set<std::string> _user_set;
    };


    namespace detail
    {
        class str_wrap
        {
            public:

                str_wrap(const std::string &l, const std::string &r) : lwrap(l), rwrap(r) {}
                explicit str_wrap(const std::string &w) : lwrap(w), rwrap(w) {}
                std::string operator()(const std::string &s)
                {
                    return lwrap + s + rwrap;
                }

                const std::string lwrap, rwrap;
        };


        template<typename InputIterator, typename UnaryOperator>
        static std::string str_join_trans(const std::string &sep, InputIterator begin, InputIterator end, UnaryOperator op)
        {
            std::string buf;
            for (InputIterator it = begin; it != end; ++it)
            {
                if (it != begin)
                {
                    buf += sep;
                }
                buf += op(*it);
            }

            return buf;
        }


        template<class InputIterator>
        static std::string str_join(const std::string &sep, InputIterator begin, InputIterator end)
        {
            return str_join_trans(sep, begin, end, str_wrap(""));
        }


        static std::string &str_replace_helper(std::string &s, const std::string &patt, const std::string &repl)
        {
            size_t pos = 0;
            const size_t n = patt.length();
            while (true)
            {
                pos = s.find(patt, pos);
                if (pos == std::string::npos)
                {
                    break;
                }
                s.replace(pos, n, repl);
                pos += repl.size();
            }

            return s;
        }


        static std::string str_replace(const std::string &s, const std::string &patt, const std::string &repl)
        {
            std::string tmp = s;
            str_replace_helper(tmp, patt, repl);
            return tmp;
        }


        static std::string str_format(const std::string &s, size_t pre, size_t len, bool indent_first = true)
        {
            std::stringstream ss;
            std::string p;
            if (indent_first)
            {
                p = std::string(pre, ' ');
            }

            size_t pos = 0, linestart = 0;
            size_t line = 0;
            while (true)
            {
                bool wrap = false;

                size_t new_pos = s.find_first_of(" \n\t", pos);
                if (new_pos == std::string::npos)
                {
                    break;
                }

                if (s[new_pos] == '\n')
                {
                    pos = new_pos + 1;
                    wrap = true;
                }

                if (line == 1)
                {
                    p = std::string(pre, ' ');
                }

                if (wrap or new_pos + pre > linestart + len)
                {
                    ss << p << s.substr(linestart, pos - linestart - 1) << std::endl;
                    linestart = pos;
                    line++;
                }

                pos = new_pos + 1;
            }

            ss << p << s.substr(linestart) << std::endl;
            return ss.str();
        }


        static std::string str_inc(const std::string &s)
        {
            std::stringstream ss;
            long i = 0;
            std::istringstream(s) >> i;
            ss << i + 1;
            return ss.str();
        }


        static unsigned int cols()
        {
            unsigned int n = 80;
#ifndef _WIN32
            const char *s = getenv("COLUMNS");
            if (s)
            {
                std::istringstream(s) >> n;
            }
#endif
            return n;
        }


        static std::string basename(const std::string &s)
        {
            const char seps[] = 
#ifdef _WIN32
            "/\\";
#else
            "/";
#endif
            std::string b = s;
            size_t i = b.find_last_not_of(seps);
            if (i == std::string::npos)
            {
                if (b[0] == '/')
                {
                    b.erase(1);
                }

                return b;
            }

            b.erase(i + 1, b.length() - i - 1);
            i = b.find_last_of(seps);
            if (i != std::string::npos)
            {
                b.erase(0, i + 1);
            }

            return b;
        }


        static OptionParser &add_option_group_helper(OptionParser &parser,
                                                     const OptionGroup &group);


        static Values &parse_args_helper(OptionParser &parser,
                                         const std::vector<std::string> &v);


        static std::string format_help_helper(const OptionParser &parser);
    }


    class Callback
    {
    public:

        virtual void operator()(const Option &option,
                                const std::string &opt,
                                const std::string &val,
                                const OptionParser &parser) = 0;
        virtual ~Callback() {}
    };


    class Option
    {
    public:

        Option() : _action("store"), _type("string"), _nargs(1), _suppress_help(false), _callback(0) {}

        Option &action(const std::string &a)
        {
            _action = a;
            if (a == "store_const" or
                a == "store_true" or
                a == "store_false" or
                a == "append_const" or
                a == "count" or
                a == "help" or
                a == "version")
            {
                nargs(0);
            }
            return *this;
        }

        Option &type(const std::string &t)
        {
            _type = t;
            return *this;
        }

        Option &dest(const std::string &d)
        {
            _dest = d;
            return *this;
        }

        Option &set_default(const std::string &d)
        {
            _default = d;
            return *this;
        }

        template<typename T>
        Option &set_default(T t)
        {
            std::ostringstream ss;
            ss << t;
            _default = ss.str();
            return *this;
        }

        Option &nargs(size_t n)
        {
            // This doesn't seem to be currently supported.
            if (n > 1)
            {
                throw std::invalid_argument(
                    "nargs greater than 1 not supported");
            }

            _nargs = n;
            return *this;
        }

        Option &set_const(const std::string &c)
        {
            _const = c;
            return *this;
        }

        template<typename InputIterator>
        Option &choices(InputIterator begin, InputIterator end)
        {
            _choices.assign(begin, end);
            type("choice");
            return *this;
        }

        Option &help(const std::string &h)
        {
            _help = h;
            return *this;
        }

        Option &suppress_help(const bool suppress=true)
        {
            _suppress_help = suppress;
            return *this;
        }

        Option &metavar(const std::string &m)
        {
            _metavar = m;
            return *this;
        }

        Option &callback(Callback &c)
        {
            _callback = &c;
            return *this;
        }

        const std::string &action() const
        {
            return _action;
        }

        const std::string &type() const
        {
            return _type;
        }

        const std::string &dest() const
        {
            return _dest;
        }

        const std::string &get_default() const
        {
            return _default;
        }

        size_t nargs() const
        {
            return _nargs;
        }

        const std::string &get_const() const
        {
            return _const;
        }

        const std::list<std::string> &choices() const
        {
            return _choices;
        }

        const std::string &help() const
        {
            return _help;
        }

        const std::string &metavar() const
        {
            return _metavar;
        }

        Callback *callback() const
        {
            return _callback;
        }

    private:

        std::string check_type(const std::string &opt, const std::string &val) const
        {
            std::istringstream ss(val);
            std::stringstream err;

            if (type() == "int" or type() == "long")
            {
                long t;
                if (not (ss >> t))
                {
                    err << "option" << " " << opt << ": " << "invalid integer value" << ": '" << val << "'";
                }
            }
            else if (type() == "float" or type() == "double")
            {
                double t;
                if (not (ss >> t))
                {
                    err << "option" << " " << opt << ": " << "invalid floating-point value" << ": '" << val << "'";
                }
            }
            else if (type() == "choice")
            {
                if (find(choices().begin(), choices().end(), val) == choices().end())
                {
                    std::list<std::string> tmp = choices();
                    std::transform(tmp.begin(), tmp.end(), tmp.begin(), detail::str_wrap("'"));
                    err << "option" << " " << opt << ": " << "invalid choice" << ": '" << val << "'"
                        << " (" << "choose from" << " " << detail::str_join(", ", tmp.begin(), tmp.end()) << ")";
                }
            }
            else if (type() == "complex")
            {
                std::complex<double> t;
                if (not (ss >> t))
                {
                    err << "option" << " " << opt << ": " << "invalid complex value" << ": '" << val << "'";
                }
            }

            return err.str();
        }

        std::string format_option_help(const unsigned int indent=2) const
        {
            std::string mvar_short;
            std::string mvar_long;

            if (nargs() == 1)
            {
                std::string mvar = metavar();
                if (mvar.empty())
                {
                    mvar = type();
                    std::transform(mvar.begin(), mvar.end(), mvar.begin(), ::toupper);
                }
                mvar_short = " " + mvar;
                mvar_long = "=" + mvar;
            }

            std::stringstream ss;
            ss << std::string(indent, ' ');

            if (not _short_opts.empty())
            {
                ss << detail::str_join_trans(", ", _short_opts.begin(), _short_opts.end(), detail::str_wrap("-", mvar_short));
                if (not _long_opts.empty())
                {
                    ss << ", ";
                }
            }
            if (not _long_opts.empty())
            {
                ss << detail::str_join_trans(", ", _long_opts.begin(), _long_opts.end(), detail::str_wrap("--", mvar_long));
            }

            return ss.str();
        }

        std::string format_help(const unsigned int indent=2) const
        {
            std::stringstream ss;
            std::string h = format_option_help(indent);
            unsigned int width = detail::cols();
            unsigned int opt_width = std::min(width * 3 / 10, 36u);
            bool indent_first = false;
            ss << h;

            // If the option list is too long, start a new paragraph.
            if (h.length() >= (opt_width - 1))
            {
                ss << std::endl;
                indent_first = true;
            }
            else
            {
                ss << std::string(opt_width - h.length(), ' ');
                if (help().empty())
                    ss << std::endl;
            }

            if (not help().empty())
            {
                std::string help_str = (not get_default().empty()) ? detail::str_replace(help(), "%default", get_default()) : help();
                ss << detail::str_format(help_str, opt_width, width, indent_first);
            }

            return ss.str();
        }

        std::set<std::string> _short_opts;
        std::set<std::string> _long_opts;

        std::string _action;
        std::string _type;
        std::string _dest;
        std::string _default;
        size_t _nargs;
        std::string _const;
        std::list<std::string> _choices;
        std::string _help;
        bool _suppress_help;
        std::string _metavar;
        Callback *_callback;

        friend class OptionParser;

        friend OptionParser &detail::add_option_group_helper(
            OptionParser &parser,
            const OptionGroup &group);
    };


    class OptionParser
    {
    public:

        OptionParser() :
            _usage("%prog [options]"),
            _add_help_option(true),
            _add_version_option(true),
            _interspersed_args(true)
        {
        }

        virtual ~OptionParser()
        {
        }

        OptionParser &usage(const std::string &u)
        {
            set_usage(u);
            return *this;
        }

        OptionParser &version(const std::string &v)
        {
            _version = v;
            return *this;
        }

        OptionParser &description(const std::string &d)
        {
            _description = d;
            return *this;
        }

        OptionParser &add_help_option(bool h)
        {
            _add_help_option = h;
            return *this;
        }

        OptionParser &add_version_option(bool v)
        {
            _add_version_option = v;
            return *this;
        }

        OptionParser &prog(const std::string &p)
        {
            _prog = p;
            return *this;
        }

        OptionParser &epilog(const std::string &e)
        {
            _epilog = e;
            return *this;
        }

        OptionParser &set_defaults(const std::string &dest, const std::string &val)
        {
            _defaults[dest] = val;
            return *this;
        }

        template<typename T>
        OptionParser &set_defaults(const std::string &dest, T t)
        {
            std::ostringstream ss;
            ss << t;
            _defaults[dest] = ss.str();
            return *this;
        }

        OptionParser &enable_interspersed_args()
        {
            _interspersed_args = true;
            return *this;
        }

        OptionParser &disable_interspersed_args()
        {
            _interspersed_args = false;
            return *this;
        }

        OptionParser &add_option_group(const OptionGroup &group)
        {
            return detail::add_option_group_helper(*this, group);
        }

        const std::string &usage() const
        {
            return _usage;
        }

        const std::string &version() const
        {
            return _version;
        }

        const std::string &description() const
        {
            return _description;
        }

        bool add_help_option() const
        {
            return _add_help_option;
        }

        bool add_version_option() const
        {
            return _add_version_option;
        }

        const std::string &prog() const
        {
            return _prog;
        }

        const std::string &epilog() const
        {
            return _epilog;
        }

        bool interspersed_args() const
        {
            return _interspersed_args;
        }

        Option &add_option(const std::vector<std::string> &opt)
        {
            _opts.resize(_opts.size() + 1);
            Option &option = _opts.back();
            std::string dest_fallback;
            for (std::vector<std::string>::const_iterator it = opt.begin(); it != opt.end(); ++it)
            {
                if (it->substr(0, 2) == "--")
                {
                    const std::string s = it->substr(2);
                    if (option.dest().empty())
                        option.dest(detail::str_replace(s, "-", "_"));
                    option._long_opts.insert(s);
                    _optmap_l[s] = &option;
                }
                else
                {
                    const std::string s = it->substr(1, 1);
                    if (dest_fallback.empty())
                        dest_fallback = s;
                    option._short_opts.insert(s);
                    _optmap_s[s] = &option;
                }
            }
            if (option.dest().empty())
            {
                option.dest(dest_fallback);
            }
            return option;
        }

        Option &add_option(const std::string &opt)
        {
            const std::string tmp[1] = {opt};
            return add_option(std::vector<std::string>(tmp, tmp+1));
        }

        Option &add_option(const std::string &opt1, const std::string &opt2)
        {
            const std::string tmp[2] = {opt1, opt2};
            return add_option(std::vector<std::string>(tmp, tmp+2));
        }

        Option &add_option(const std::string &opt1, const std::string &opt2, const std::string &opt3)
        {
            const std::string tmp[3] = {opt1, opt2, opt3};
            return add_option(std::vector<std::string>(tmp, tmp+3));
        }

        Values &parse_args(int argc, char const *const *argv)
        {
            if (prog().empty())
            {
                prog(detail::basename(argv[0]));
            }
            return parse_args(&argv[1], &argv[argc]);
        }

        Values &parse_args(const std::vector<std::string> &arguments)
        {
            return detail::parse_args_helper(*this, arguments);
        }

        template<typename InputIterator>
        Values &parse_args(InputIterator begin, InputIterator end)
        {
            return parse_args(std::vector<std::string>(begin, end));
        }

        const std::vector<std::string> &args() const
        {
            return _leftover;
        }

        std::string format_help() const
        {
            return detail::format_help_helper(*this);
        }

        std::string format_option_help(unsigned int indent=2) const
        {
            std::stringstream ss;

            if (_opts.empty())
            {
                return ss.str();
            }

            for (std::list<Option>::const_iterator it = _opts.begin(); it != _opts.end(); ++it)
            {
                if (not it->_suppress_help)
                {
                    ss << it->format_help(indent);
                }
            }

            return ss.str();
        }

        void print_help() const
        {
            std::cout << format_help();
        }

        void set_usage(const std::string &u)
        {
            std::string lower = u;
            std::transform(lower.begin(), lower.end(), lower.begin(), ::tolower);
            if (lower.compare(0, 7, "usage: ") == 0)
            {
                _usage = u.substr(7);
            }
            else
            {
                _usage = u;
            }
        }

        std::string get_usage() const
        {
            return format_usage(detail::str_replace(usage(), "%prog", prog()));
        }

        void print_usage(std::ostream &out) const
        {
            std::string u = get_usage();
            if (not u.empty())
            {
                out << u << std::endl;
            }
        }

        void print_usage() const
        {
            print_usage(std::cout);
        }

        std::string get_version() const
        {
            return detail::str_replace(_version, "%prog", prog());
        }

        void print_version(std::ostream &out) const
        {
            out << get_version() << std::endl;
        }

        void print_version() const
        {
            print_version(std::cout);
        }

        virtual void error(const std::string &msg) const
        {
            print_usage(std::cerr);
            std::cerr << prog() << ": " << "error" << ": " << msg << std::endl;
            exit(2);
        }

        virtual void exit(int code) const
        {
            std::exit(code);
        }

    private:

        const Option &lookup_short_opt(const std::string &opt) const
        {
            std::map<std::string, Option const *>::const_iterator it = _optmap_s.find(opt);
            if (it == _optmap_s.end())
            {
                error("no such option" + std::string(": -") + opt);

                static const Option empty;
                return empty;
            }
            return *it->second;
        }

        const Option &lookup_long_opt(const std::string &opt) const
        {
            std::vector<std::string> matching;
            for (std::map<std::string, Option const *>::const_iterator it = _optmap_l.begin(); it != _optmap_l.end(); ++it)
            {
                if (it->first == opt)
                {
                    matching.push_back(it->first);
                }
            }
            if (matching.size() > 1)
            {
                std::string x = detail::str_join(", ", matching.begin(), matching.end());
                error("ambiguous option" + std::string(": --") + opt + " (" + x + "?)");
            }
            if (matching.size() == 0)
            {
                error("no such option" + std::string(": --") + opt);

                static const Option empty;
                return empty;
            }

            return *_optmap_l.find(matching.front())->second;
        }

        void handle_short_opt(const std::string &opt, const std::string &arg)
        {
            _remaining.pop_front();
            std::string value;

            const Option &option = lookup_short_opt(opt);
            if (option._nargs == 1)
            {
                value = arg.substr(2);
                if (value.empty())
                {
                    if (_remaining.empty())
                    {
                        error("-" + opt + " " + "option requires an argument");
                    }
                    value = _remaining.front();
                    _remaining.pop_front();
                }
            }
            else
            {
                if (arg.length() > 2)
                {
                    _remaining.push_front(std::string("-") + arg.substr(2));
                }
            }

            process_opt(option, std::string("-") + opt, value);
        }

        void handle_long_opt(const std::string &optstr)
        {
            _remaining.pop_front();
            std::string opt;
            std::string value;

            size_t delim = optstr.find('=');
            if (delim != std::string::npos)
            {
                opt = optstr.substr(0, delim);
                value = optstr.substr(delim + 1);
            }
            else
            {
                opt = optstr;
            }

            const Option &option = lookup_long_opt(opt);
            if (option._nargs == 1 and delim == std::string::npos)
            {
                if (not _remaining.empty())
                {
                    value = _remaining.front();
                    _remaining.pop_front();
                }
            }

            if (option._nargs == 1 and value.empty())
            {
                error("--" + opt + " " + "option requires an argument");
            }

            process_opt(option, std::string("--") + opt, value);
        }

        void process_opt(const Option &o, const std::string &opt, const std::string &value)
        {
            if (o.action() == "store")
            {
                std::string err = o.check_type(opt, value);
                if (not err.empty())
                {
                    error(err);
                }
                _values[o.dest()] = value;
                _values.is_set_by_user(o.dest(), true);
            }
            else if (o.action() == "store_const")
            {
                _values[o.dest()] = o.get_const();
                _values.is_set_by_user(o.dest(), true);
            }
            else if (o.action() == "store_true")
            {
                _values[o.dest()] = "1";
                _values.is_set_by_user(o.dest(), true);
            }
            else if (o.action() == "store_false")
            {
                _values[o.dest()] = "0";
                _values.is_set_by_user(o.dest(), true);
            }
            else if (o.action() == "append")
            {
                std::string err = o.check_type(opt, value);
                if (not err.empty())
                {
                    error(err);
                }
                _values[o.dest()] = value;
                _values.all(o.dest()).push_back(value);
                _values.is_set_by_user(o.dest(), true);
            }
            else if (o.action() == "append_const")
            {
                _values[o.dest()] = o.get_const();
                _values.all(o.dest()).push_back(o.get_const());
                _values.is_set_by_user(o.dest(), true);
            }
            else if (o.action() == "count")
            {
                _values[o.dest()] = detail::str_inc(_values[o.dest()]);
                _values.is_set_by_user(o.dest(), true);
            }
            else if (o.action() == "help")
            {
                print_help();
                exit(0);
            }
            else if (o.action() == "version")
            {
                print_version();
                exit(0);
            }
            else if (o.action() == "callback" and o.callback())
            {
                (*o.callback())(o, opt, value, *this);
            }
        }

        std::string format_usage(const std::string &u) const
        {
            std::stringstream ss;
            ss << "Usage" << ": " << u << std::endl;
            return ss.str();
        }

        std::string _usage;
        std::string _version;
        std::string _description;
        bool _add_help_option;
        bool _add_version_option;
        std::string _prog;
        std::string _epilog;
        bool _interspersed_args;

        Values _values;

        std::list<Option> _opts;
        std::map<std::string, Option const *> _optmap_s;
        std::map<std::string, Option const *> _optmap_l;
        std::map<std::string, std::string> _defaults;
        std::vector<OptionGroup const *> _groups;

        std::list<std::string> _remaining;
        std::vector<std::string> _leftover;

        friend OptionParser &detail::add_option_group_helper(
            OptionParser &parser,
            const OptionGroup &group);

        friend Values &detail::parse_args_helper(
            OptionParser &parser,
            const std::vector<std::string> &v);

        friend std::string detail::format_help_helper(const OptionParser &parser);
    };


    class OptionParserExcept : public OptionParser
    {
    public:
        OptionParserExcept() {}
        OptionParserExcept(const OptionParser & parser) : OptionParser(parser) { }
        virtual void exit(int code) const
        {
            throw code;
        }
    };

    class OptionGroup : public OptionParser
    {
    public:

        OptionGroup(const std::string &t, const std::string &d="") :
            _title(t), _group_description(d) {}

        OptionGroup &title(const std::string &t)
        {
            _title = t;
            return *this;
        }

        OptionGroup &group_description(const std::string &d)
        {
            _group_description = d;
            return *this;
        }

        const std::string &title() const
        {
            return _title;
        }

        const std::string &group_description() const
        {
            return _group_description;
        }

    private:

        std::string _title;
        std::string _group_description;
    };


    namespace detail
    {
        static OptionParser &add_option_group_helper(OptionParser &parser,
                                                     const OptionGroup &group)
        {
            for (std::list<Option>::const_iterator oit = group._opts.begin(); oit != group._opts.end(); ++oit)
            {
                const Option &option = *oit;
                for (std::set<std::string>::const_iterator it = option._short_opts.begin();
                     it != option._short_opts.end();
                     ++it)
                {
                    parser._optmap_s[*it] = &option;
                }

                for (std::set<std::string>::const_iterator it = option._long_opts.begin();
                     it != option._long_opts.end();
                     ++it)
                {
                    parser._optmap_l[*it] = &option;
                }
            }
            parser._groups.push_back(&group);
            return parser;
        }


        static Values &parse_args_helper(OptionParser &parser,
                                         const std::vector<std::string> &v)
        {
            parser._remaining.assign(v.begin(), v.end());

            if (parser.add_version_option() and not parser.version().empty())
            {
                parser.add_option("--version").action("version").help("show program's version number and exit");
                parser._opts.splice(parser._opts.begin(), parser._opts, --(parser._opts.end()));
            }
            if (parser.add_help_option())
            {
                parser.add_option("-h", "--help").action("help").help("show this help message and exit");
                parser._opts.splice(parser._opts.begin(), parser._opts, --(parser._opts.end()));
            }

            while (not parser._remaining.empty())
            {
                const std::string arg = parser._remaining.front();

                if (arg == "--")
                {
                    parser._remaining.pop_front();
                    break;
                }

                if (arg.substr(0, 2) == "--")
                {
                    parser.handle_long_opt(arg.substr(2));
                }
                else if (arg.substr(0, 1) == "-" and arg.length() > 1)
                {
                    parser.handle_short_opt(arg.substr(1, 1), arg);
                }
                else
                {
                    parser._remaining.pop_front();
                    parser._leftover.push_back(arg);
                    if (not parser.interspersed_args())
                    {
                        break;
                    }
                }
            }
            while (not parser._remaining.empty())
            {
                const std::string arg = parser._remaining.front();
                parser._remaining.pop_front();
                parser._leftover.push_back(arg);
            }

            for (std::map<std::string, std::string>::const_iterator it = parser._defaults.begin(); it != parser._defaults.end(); ++it)
            {
                if (not parser._values.is_set(it->first))
                {
                    parser._values[it->first] = it->second;
                }
            }

            for (std::list<Option>::const_iterator it = parser._opts.begin(); it != parser._opts.end(); ++it)
            {
                if (not it->get_default().empty() and not parser._values.is_set(it->dest()))
                {
                    parser._values[it->dest()] = it->get_default();
                }
            }

            for (std::vector<OptionGroup const *>::iterator group_it = parser._groups.begin(); group_it != parser._groups.end(); ++group_it)
            {
                for (std::map<std::string, std::string>::const_iterator it = (*group_it)->_defaults.begin(); it != (*group_it)->_defaults.end(); ++it)
                {
                    if (not parser._values.is_set(it->first))
                    {
                        parser._values[it->first] = it->second;
                    }
                }

                for (std::list<Option>::const_iterator it = (*group_it)->_opts.begin(); it != (*group_it)->_opts.end(); ++it)
                {
                    if (not it->get_default().empty() and not parser._values.is_set(it->dest()))
                    {
                        parser._values[it->dest()] = it->get_default();
                    }
                }
            }

            return parser._values;
        }


        static std::string format_help_helper(const OptionParser &parser)
        {
            std::stringstream ss;

            ss << parser.get_usage() << std::endl;

            if (not parser.description().empty())
            {
                ss << detail::str_format(parser.description(), 0, detail::cols()) << std::endl;
            }

            ss << "Options" << ":" << std::endl;
            ss << parser.format_option_help();

            for (std::vector<OptionGroup const *>::const_iterator it = parser._groups.begin();
                 it != parser._groups.end();
                 ++it)
            {
                const OptionGroup &group = **it;
                ss << std::endl << "  " << group.title() << ":" << std::endl;
                if (not group.group_description().empty())
                    ss << detail::str_format(group.group_description(), 4, detail::cols()) << std::endl;
                ss << group.format_option_help(4);
            }

            if (not parser.epilog().empty())
            {
                ss << std::endl << detail::str_format(parser.epilog(), 0, detail::cols());
            }

            return ss.str();
        }
    }
}

#endif
