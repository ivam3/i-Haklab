OSRFramework is a GNU AGPLv3+ set of libraries developed by i3visio to perform
Open Source Intelligence collection tasks. They include references to a bunch
of different applications related to username checking, DNS lookups,
information leaks research, deep web search, regular expressions extraction and
many others. At the same time, by means of ad-hoc Maltego transforms,
OSRFramework provides a way of making these queries graphically as well as
several interfaces to interact with like OSRFConsole or a Web interface.

This is free software, and you are welcome to redistribute it under certain
conditions.
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
For more details on this issue, check the _C_O_P_Y_I_N_G file.

Fast way to do it on any system for a user with administration privileges:
sudo pip3 install osrframework
You can upgrade to the latest release of the framework with:
sudo pip3 install osrframework --upgrade
This will manage all the dependencies for you and install the latest version of
the framework.

If you needed further information on how to install OSRFramework on certain
systems, note that you may need to add export PATH=$PATH:$HOME/.local/bin to
your ~/.bashrc_profile). This has been confirmed in some distributions,
including MacOS. In any case, we recommend you yo have a look at the _I_N_S_T_A_L_L_._m_d
file where we provide additional details for these cases.

If everything went correctly (we hope so!), it's time for trying usufy., mailfy
and so on. But where are they locally? They are installed in your path meaning
that you can open a terminal anywhere and typing the name of the program (seems
to be an improvement from previous installations...). Examples:
osrf --help
usufy -n i3visio febrezo yrubiosec -p twitter facebook
searchfy -q "i3visio"
mailfy -n i3visio
Type -h or --help to get more information about which are the parameters of
each application.

The tools installed in this package include:
    * alias_generator. Generates candidate nicknames based on known info about
      the target. IInnppuutt: information about the target. OOuuttppuutt: list of possible
      nicknames.
    * checkfy. Guesses possible emails based on a list of candidate nicknames
      and a pattern. IInnppuutt: list of nicknames and an email pattern. OOuuttppuutt.
      list of emails matching the pattern..
    * domainfy. Finds domains that currently resolve using a given word or
      nickname. IInnppuutt: liat of words. OOuuttppuutt: domains using that word that
      currently resolve.
    * mailfy. Find more information about emails taken as a reference either a
      nickname (to generate a list of possible emails) or the email list.
      IInnppuutt: list of nicknames or emails. OOuuttppuutt: found information about the
      email.
    * osrf. Shared wrapper for the rest of the applications. All commands can
      also be used as osrf usufyâ¦, osrf mailfyâ¦, etc.
    * phonefy. Recovers information about mobile phones linked to known spam
      practices. IInnppuuttss: list of phones. OOuuttppuuttss: Phones linked to spam.
    * searchfy. Finds profiles linked to a fullname. IInnppuuttss: list of phones.
      OOuuttppuuttss: Known profiles linked to the query.
    * usufy. Identifies socialmedia profiles using a given nickname. IInnppuuttss:
      list of nicknames. OOuuttppuuttss: Known profiles in socialmedia using those
      nicknames.

You can find the configuration files in a folder created in your user home to
define the default behaviour of the applications:
# Configuration files for Linux and MacOS
~/.config/OSRFramework/
# Configuration files for Termux
~/.config/OSRFramework
# Configuration files for Windows
C:\Users\<User>\OSRFramework\

OSRFramework will look for the configuration settings for each application
stored there. You can add new credentials there and if something goes wrong,
you can always restore the files stored in the defaults subfolder.
If you are experiencing problems, you might fight relevant information in the
(FAQ Section)[doc/FAQ.md].

If you want to extend the functionalities of OSRFramework and you do not know
where to start from, check the _H_A_C_K_I_N_G_._m_d file.

More details about the authors in the _A_U_T_H_O_R_S_._m_d file.
