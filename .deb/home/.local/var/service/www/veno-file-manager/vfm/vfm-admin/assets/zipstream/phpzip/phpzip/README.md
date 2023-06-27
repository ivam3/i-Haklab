# PHP Zip

A pair of PHP classes to generate zip files.

The projects that started these two classes are hosted on PHPClasses.org at the addresses:
Zip      : http://www.phpclasses.org/package/6110
ZipStream: http://www.phpclasses.org/package/6616

*****************************************************************************************************************
WARNING: THE CURRENT VERSION OF PHPZip *MAY* FAIL IF THE SERVER HAS mbstring.func_overload INSTALLED AND ACTIVE!
OLDER VERSIONS OF PHPZip *WILL* FAIL IF THE SERVER HAS mbstring.func_overload INSTALLED AND ACTIVE!
EXPERIMENTAL FEATURES HAVE BEEN ADDED TO ALLEVIATE THE LOBOTOMIZATION OF PHP, CAUSED BY mbstring.func_overload
*****************************************************************************************************************

Note: PHPZip currently uses the 32-bit deflate, and is limited by that.
The largest files that can be added are 4GB, and the total size of the archive can't exceed 4GB either.

Zip.php generates the Zip file in memory (or temp file) allowing the parent script to save the final Zip file elsewhere, and/or send it to the user.
ZipStream has much of the same features and functions of Zip.php, with a few notable differences, it does not cache and build the zip file on the server, instead it'll send the file to the user as a stream.

See the examples for example usage. The php files have "some" documentation in them in the form of Javadoc style function headers.

NOTE: Please ensure that output buffering is disabled when using especially ZipStream. It defeats the purpose of the class, and large zip files may cause a memory exceeded exception.
NOTE2: THe Zip and ZipStream classes support UTF-8 in file paths and file comments, and will autodetect UTF-8 strings to that end, however it is up to the user to ensure that other Multibyte chracter sets aren't sent to the class.

## Installation

### Import
Add this requirement to your `composer.json` file:
```json
    "phpzip/phpzip": ">=2.0.7"
```

### Composer
If you already have Composer installed, skip this part.

[Packagist](https://packagist.org/), the main composer repository has a neat and very short guide.

Or you can look at the guide at the [Composer site](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).
 
The easiest for first time users, is to have the composer installed in the same directory as your composer.json file, though there are better options.

Run this from the command line:
```
php -r "readfile('https://getcomposer.org/installer');" | php
```

This will check your PHP installation, and download the `composer.phar`, which is the composer binary. This file is not needed on the server though.

Once composer is installed you can create the `composer.json` file to import this package.
```json
{
    "require": {
        "phpzip/phpzip": ">=2.0.7",
        "php": ">=5.3.0"
    }
}
```

Followed by telling Composer to install the dependencies.
```
php composer.phar install
```

this will download and place all dependencies defined in your `composer.json` file in the `vendor` directory.

Finally, you include the `autoload.php` file in the new `vendor` directory.
```php
<?php
    require 'vendor/autoload.php';
    .
    .
    .
```

## TODO:
* Documentation, no one reads it, but everyone complains if it is missing.
* Better examples to fully cover the capabilities of the Zip classes.
* more TODO's.

