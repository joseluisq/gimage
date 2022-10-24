# Getting started

## Installation

!!! tip "Requirements"
	GImage requires PHP [`7.4`][1] or a recent PHP version with the latest [GD Extension][2].

Make sure that [GD extension][2] is loaded on your system. You can verify it using the following command:

```sh
php -r "var_dump(extension_loaded('gd'));"
# bool(true)
```

Then install GImage via [Composer][3]:

```sh
composer require joseluisq/gimage
```

[1]: https://www.php.net/releases/7_4_0.php
[2]: http://php.net/manual/en/book.image.php
[3]: https://getcomposer.org/

## Usage

Loading an external PNG image and saving it as JPG:

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
