# GImage

[![Build Status](https://github.com/joseluisq/gimage/actions/workflows/devel.yml/badge.svg?branch=master)](https://github.com/joseluisq/gimage/actions/workflows/devel.yml) [![](https://poser.pugx.org/joseluisq/gimage/version)](https://packagist.org/packages/joseluisq/gimage) [![Latest Unstable Version](https://poser.pugx.org/joseluisq/gimage/v/unstable)](//packagist.org/packages/joseluisq/gimage) [![Total Downloads](https://poser.pugx.org/joseluisq/gimage/downloads)](https://packagist.org/packages/joseluisq/gimage) [![License](https://poser.pugx.org/joseluisq/gimage/license)](https://packagist.org/packages/joseluisq/gimage)

> A PHP library for easy image handling. 🖼

![A simple presentation card with GImage](https://cloud.githubusercontent.com/assets/1700322/18941713/eed7fa34-85d8-11e6-8033-bf787e4aa236.png)

_Presentation card built with GImage - [View code example](https://joseluisq.github.io/gimage/examples/creating-a-presentation-card/)_

## Features

__GImage__ is a simple and small library based on [PHP Image Processing and GD](http://php.net/manual/en/book.image.php) for processing images easily.

- Load an image from a local path, URL or image resource.
- Create shapes such as rectangles or ellipses with opacity.
- Resize, scale or crop images proportionally.
- Rotate images, shapes or texts.
- Embed text with custom TTF fonts.
- Compose a pool of images with `Canvas`.
- Swap image formats such as JPEG, PNG or GIF.
- Save images locally or output them on the browser.
- Save several copies of the same image.
- Render an image in memory and return its resource.

## Requirements

GImage requires PHP [`7.4`](https://www.php.net/releases/7_4_0.php) or a recent PHP version with the latest [GD Extension](http://php.net/manual/en/book.image.php).

## Install

```sh
composer require joseluisq/gimage
```

## Usage

Load an external PNG image and save it as JPG:

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

See [GImage Website](https://bit.ly/gimage-php) for detailed usage instructions and more advanced examples.

## Changelog

Check out the [CHANGELOG.md](./CHANGELOG.md) file.

## Examples

See [code examples](./examples) directory.

## Development

### Run tests

Via [Composer](https://getcomposer.org/)

```sh
composer install
composer run-script test
```

Via [Docker](https://www.docker.com/) (multi PHP versions test)

```sh
make docker-tests
```

## Contribution

Feel free to send some [Pull request](https://github.com/joseluisq/gimage/pulls) or file an [issue](https://github.com/joseluisq/gimage/issues).

## License

This work is primarily distributed under the terms of the [MIT license](LICENSE-MIT).

©2015-present [Jose Quintana](https://joseluisq.net)
