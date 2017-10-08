# Getting started

## Installation

!!! tip "Requirements"
    GImage requires [PHP 7.0+][php7] and latest [GD Extension][gd].

Make sure if [GD extension][gd] is loaded. You can verify it using the following command:

```sh
php -r "var_dump(extension_loaded('gd'));"
# bool(true)
```

Then install GImage via [Composer][composer]:

```sh
composer require joseluisq/gimage
```

[php7]: http://php.net/manual/en/migration70.new-features.php
[gd]: http://php.net/manual/en/book.image.php
[gimage]: https://github.com/joseluisq/gimage
[composer]: https://getcomposer.org/

## Usage

Loading an external JPG image and saving it as PNG:

```php
<?php

use GImage\Image;

// PNG image (600x199)
$url = 'https://i.imgur.com/G5MR088.png';

$arch = new Image();
$arch
    // Load from URL
	->load($url)
	// Scale to 50% (300x99)
	->scale(0.5)
	// Change the format to JPG
	->toJPG()
	// Saving in local path
	->save('arch.jpg');
```
