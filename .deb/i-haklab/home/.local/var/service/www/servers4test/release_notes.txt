
---------------------
bWAPP - Release notes
---------------------

v2.2
****

Release date: 2/11/2014

Number of bugs: > 100

New bugs:

- Insecure iFrame (Login Form)

New bugs exploitable on bee-box v1.6:

- Drupal SQL Injection (Drupageddon)
- POODLE Vulnerability
- SQLiteManager Local File Inclusion


v2.1
****

Release date: 27/09/2014

Number of bugs: > 100

New bugs:

- Base64 Encoding (Secret)
- Broken Authentication - CAPTCHA Bypassing
- Cross-Site Scripting - Stored (User-Agent)
- iFrame Injection
- SQL Injection - Stored (User-Agent)

New bugs exploitable on bee-box v1.5:

- Shellshock Vulnerability (CGI)


v2.0
****

Release date: 12/05/2014

Number of bugs: > 90

New bugs:

- Cross-Site Scripting - Reflected (Login Form)
- SQL Injection (AJAX/JSON/jQuery)
- SQL Injection (POST/Select)
- SQL Injection (Login Form/User)
- SQL Injection (SQLite)
- SQL Injection - Stored (SQLite)
- SQL Injection - Blind - Time-Based
- SQL Injection - Blind (SQLite)

New bugs exploitable on bee-box v1.4:

- BEAST/CRIME/BREACH Attacks
- Buffer Overflow (Local)
- Buffer Overflow (Remote)
- Denial-of-Service (Large Chunk Size)
- Denial-of-Service (SSL-Exhaustion)
- Local Privilege Escalation (sendpage)
- phpMyAdmin BBCode Tag XSS
- SQLiteManager PHP Code Injection
- SQLiteManager XSS
- SSL 2.0 Deprecated Protocol

Modifications:

- Google fonts are stored locally

New features:

- A.I.M. subnet functionality
- bWAPP is licensed under Creative Commons (Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International)


v1.9+
*****

Release date: 19/04/2014

Number of bugs: > 70

New bugs exploitable on bee-box v1.3:

- Heartbleed Vulnerability (OpenSSL)
- Insecure SNMP configuration

Modifications:

- Blog entries per user ('Show all' and 'Delete' entry options)
- bWAPP reset functionality only available for users with admin privileges

New features:

- Custom CSS stylesheet for low resolution screens (stylesheet_low_resolution.css)


v1.9
****

Release date: 11/03/2014

Number of bugs: > 70

New bugs:

- Broken Authentication - Weak Passwords
- Command Injection - Blind
- Cross-Site Scripting - Reflected (Custom HTTP Header)
- Cross-Site Scripting - Stored (Change Secret)
- Denial-of-Service (XML Bomb)
- Host Header Attack (Cache Poisoning)
- Host Header Attack (Reset Poisoning)
- Insecure Direct Object References (Reset Secret)
- Old, Backup & Unreferenced Files
- PHP Code Injection
- Server Side Request Forgery (SSRF)
- SQL Injection (Search/POST)
- SQL Injection (Search/CAPTCHA)
- SQL Injection - Stored (Blog)
- SQL Injection - Stored (XML)
- Unvalidated Redirects & Forwards (2)
- XML External Entity Attacks (XXE)

New features:

- Evil 666 Fuzzing page
- Evil Bug Mode, all security levels are bypassed in this mode by using a fixed cookie
- Insecure Client Access Policy file (Silverlight)
- Manual Intervention Required! page
- We Steal Secrets... pages

Modifications:

- Possibility to exclude 'dangerous' files in the A.I.M. mode
- The database connection settings are moved to the 'admin/settings.php' file


v1.8
****

Release date: 15/12/2013

Number of bugs: > 65

New bugs:

- SQL Injection - Blind (Web Services/SOAP)

New bugs exploitable on bee-box v1.2:

- Insecure FTP
- Insecure WebDAV
- PHP CGI Remote Code Execution
- Server-Side Includes Injection

New features:

- NSA backdoor file
- Unprotected Admin Portal > a shortcut to the 'settings' file
- WSDL file (Web Services/SOAP)

Bug fixes:

- Issue with 'Restrict Folder Access'
- Issue with 'Session ID in URL'

Modifications:

- A.I.M. feature > list of IP addresses
- Unrestricted File Upload > unsafe black-list in security level medium
- table 'movies' > extra column: tickets_stock


v1.7
****

Release date: 31/10/2013

Number of bugs: > 60

New bugs:

- HTTP Verb Tampering
- Server Side Request Forgery (SSRF)
- Session ID in URL
- XSS - Reflected (AJAX/JSON)
- XSS - Reflected (AJAX/XML)

New features:

- A.I.M., a no-authentication mode for testing web scanners and crawlers
- Settings file, used for general application settings
- OWASP & ZAP logo

New bugs exploitable on bee-box:

- Local Privilege Escalation (udev)

Modifications:

- Rearrangement to OWASP Top 10 2013
- Added some new movies :)
- Introduction text


v1.6
****

Release date: 5/10/2013

Number of bugs: > 60

New features:

- Cross-Origin Resource Sharing (AJAX)
- Information Disclosure - Favicon

New features exploitable on bee-box:

- Arbitrary File Access (Samba)
- Cross-Site Tracing (XST)
- Denial-of-Service (Slow HTTP DoS)

Modifications:

- Addition of an insecure jQuery script


v1.5
****

Release date: 09/09/2013

Number of bugs: > 55

New features:

- ClickJacking (Movie Tickets)
- Cross-Domain Policy File
- Cross-Site Scripting - Reflected (HREF)
- Cross-Site Scripting - Reflected (PHP_SELF)
- HTML5 Web Storage (Secret)
- HTTP Parameter Pollution
- Insecure Direct Object References (Price)

Bug fixes:

- Input validations and error handling
- XSS issues :)

Modifications:

- SQL Injection (Login) > welcome message has changed
- New vulnerable XSS validation check (medium level)
- test.php file > extra urldecode function


v1.4
****

Release date: 15/07/2013

Number of bugs: > 50

New features:

- LDAP Injection
- Client-Side Validation (Password)
- PHP Eval Function
- Remote and Local File Inclusion
- Unsecure files: phpinfo.php, config.inc, test.php
- Integration with bee-box (Ubuntu OS)

Bug fixes:

- Input validations and error handling

Modifications:

- Bugs are rearranged according to the OWASP Top 10 project (A1>A10)
- Creation of users without e-mail activation
- New hero table with passwords in clear text
- SQL Injection (Login) > applied to the new hero table


v1.3
****

Release date: 20/01/2013

Number of bugs: 47

New features:

- SQL Injection (Select)
- Broken Authentication - Forgotten Function
- Broken Authentication - Password Attacks
- Authorization Testing - Restrict Folder Access

Bug fixes:

- HTML5 issues

Modifications

- Better compatibility with IE9
- Stylesheet modifications


v1.2
****

Release date: 17/01/2013

New features:

- Cross-Site Scripting - Stored (Cookies)
- Cross-Site Request Forgery (Secret)
- Insufficient Transport Layer Protection
- Security Misconfiguration - MiTM (HTTP)
- Security Misconfiguration - MiTM (SMTP)
- Security Misconfiguration - Robots
- Information Disclosure - Robots
- Insecure Directory Object References (Secret)
- Session Management - Cookies (Secure)
- Session Management - Strong Sessions

Bug fixes:

- CSRF: code optimization and error handling
- Cookie 'security_level' is vulnerable for injection

Modifications

- Name change: Session Management - Cookie Security >> Session Management - Cookies (HTTPOnly)
- Name change: Cross-Site Scripting - Stored >> Cross-Site Scripting - Stored (Blog)


v1.1
****

New features:

- HTML Injection - Reflected (Current URL)
- Cross-Site Scripting - Reflected (Back Button)
- XML and XPath Injection (Login)
- XML and XPath Injection (Search)

Bug fixes:

- Directory traversal: wrong directory in GET parameter (images/ is changed to documents/)


v1.01
*****

New features:

- none

Bug fixes:

- bug fixes for the Apache platform
	- PHP session errors
	- connection setting issues ('localhost:3306' not valid)
	- time period for the 'security_level' cookie has changed to 1 year


v1.0
*****

- extra SQL user: bee/bug
- e-mail modifications
	- recipient/sender addresses change


v0.15
*****

- Layout
- Code optimization
- New 'Info' page


v0.14
*****

- Layout
- Code optimization


v0.13
*****

- Code optimization
- Modifications:
	- XSS & HTML Injection Stored
		- No 'HTML entities check' in the SQL insert statement
		- 'HTML entities check' in the HTML output
- New:
	- Authorization Testing - Restrict Device Access


Upcoming bugs
/////////////

- JSON
- AJAX
- Web Services
