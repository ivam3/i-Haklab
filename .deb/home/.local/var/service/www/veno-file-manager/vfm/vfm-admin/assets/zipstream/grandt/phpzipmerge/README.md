# ZipMerge

Combine and stream the contents of multiple existing Zip files, as a single file, *without* recompressing the data within.

This is useful if you have often used static content that needs to be collected and sent to the client.
With this you can pre-compress these packages, and assemble them on the fly, saving CPU cycles by not
having to do the compression every time the files are requested.

The contents of each Zip file added, can even be placed in separate sub folders.

## Installation

### Import
Add this requirement to your `composer.json` file:
```json
   "grandt/phpzipmerge": ">=1.0.4"
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
        "grandt/phpzipmerge": ">=1.0.4",
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
