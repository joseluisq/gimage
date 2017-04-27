# GImage

[![Build Status](https://travis-ci.org/joseluisq/gimage.svg?branch=master)](https://travis-ci.org/joseluisq/gimage) [![Latest Stable Version](https://poser.pugx.org/joseluisq/gimage/version)](https://packagist.org/packages/joseluisq/gimage) [![Latest Unstable Version](https://poser.pugx.org/joseluisq/gimage/v/unstable)](//packagist.org/packages/joseluisq/gimage) [![Total Downloads](https://poser.pugx.org/joseluisq/gimage/downloads)](https://packagist.org/packages/joseluisq/gimage) [![License](https://poser.pugx.org/joseluisq/gimage/license)](https://packagist.org/packages/joseluisq/gimage)

> A PHP library for easy image handling.

![A simple presentation card with GImage](https://cloud.githubusercontent.com/assets/1700322/18941713/eed7fa34-85d8-11e6-8033-bf787e4aa236.png)

_Presentation card built with GImage - [view sample code](#creating-a-simple-presentation-card)_

## Features

__GImage__ is a simple extended library based on [PHP Image Processing and GD](http://php.net/manual/en/book.image.php) for processing images without stress.


- Load an image from local path or URL.
- Create shapes such as rectangles or ellipses with opacity.
- Resize or scale images proportionally.
- Crop images proportionally.
- Rotate images, shapes or texts.
- Embed text with custom TTF fonts.
- Compose a pool of images with `Canvas`.
- Swap image formats such as JPEG, PNG and GIF.
- Save images in local or output on the browser.
- Save several copies of the same image.

## Requirements
GImage requires **[PHP 7.x](http://php.net/manual/en/migration70.new-features.php)** and latest [GD Extension](http://php.net/manual/en/book.image.php).

## Install

```sh
composer require joseluisq/gimage
```

## Usage

#### Image

Working with an external JPG image and output it on browser as PNG format:

```php
<?php

use GImage\Image;

$avatar = new Image();
$avatar
	// Loading a JPEG image (200x200) from an URL (or local path too)
	->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200.jpg');
	// Scaling to 50% (100x100)
	->scale(50)
	// Set 50% of opacity
	->setOpacity(0.5)
	// Changing the format to PNG
	->toPNG()
	// Preserving the image before saving or outputting
	->preserve()
	// Saving to local path
	->save('octocat.png')
	// Preparing for destroy the resource after outputting
	->preserve(false)
	// Outputting on the browser and destroy the resource.
	->output();
```

#### Figure

Creating a green ellipse:

```php
<?php

use GImage\Figure;

// Setting ellipse sizes
$ellipse = new Figure(500, 300);
$ellipse
    // Set ellipse type
    ->isEllipse()
	// Setting a green RGB color
	->setBackgroundColor(170, 188, 147)
	// Creating the figure
	->create()
	// Outputting image (PNG Figure by default) on the browser.
	->output();
```

#### Text

Creating a rectangle with Text embedded:

```php
<?php

use GImage\Text;
use GImage\Figure;
use GImage\Canvas;

$figure = new Figure(400, 250);
$figure
    ->isRectangle()
    ->setBackgroundColor(47, 42, 39)
    ->create();

$text = new Text('My awesome text!');
$text
    ->setWidth(400)
    ->setHeight(250)
    ->setLineHeight(1.2)
    ->setAlign('center')
    ->setValign('center')
    ->setSize(22)
    ->setColor(255, 255, 255)
    ->setFontface('./fonts/Lato-Bol.ttf');

$canvas = new Canvas($figure);
$canvas
    ->append($text)
    ->toPNG()
    ->draw()
    ->save('./text.png');
```

#### Creating a simple presentation card
Presentation card example using `Image`, `Canvas`, `Figure` and `Text`.

```php
<?php

use GImage\Image;
use GImage\Text;
use GImage\Figure;
use GImage\Canvas;

$avatar_image = new Image();
$avatar_image
	->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=100.jpg')
	->setTop(60)
	->setLeft(70);

$about_text = new Text("MY AWESOME PRESENTATION CARD GENERATED WITH GIMAGE");
$about_text
	->setSize(16)
	->setWidth(300)
	->setLeft(210)
	->setTop(75)
	->setColor(204, 164, 116)
	->setFontface('fonts/Lato-Light.ttf');

$twitter_text = new Text('@username');
$twitter_text
	->setSize(11)
	->setWidth(70)
	->setLeft(450)
	->setTop(210)
	->setColor(130, 127, 125)
	->setFontface('fonts/Lato-Regular.ttf');

$canvas_figure = new Figure(550, 250);
$canvas_figure
	->setBackgroundColor(47, 42, 39)
	->create();

$avatar_box = new Figure($avatar_image->getWidth() + 16, $avatar_image
	->getHeight() + 17);
$avatar_box
	->setBackgroundColor(63, 56, 52)
	->setLeft($avatar_image->getLeft() - 7)
	->setTop($avatar_image->getTop() - 8)
	->create();

$avatar_box2 = new Figure($avatar_image->getWidth() + 3, $avatar_image
	->getHeight() + 19);
$avatar_box2
	->setBackgroundColor(79, 72, 67)
	->setLeft($avatar_image->getLeft() + 7)
	->setTop($avatar_image->getTop() - 9)
	->create();

$avatar_box3 = new Figure(120, 240);
$avatar_box3
	->setBackgroundColor(63, 56, 52)
	->create();

$line_vertical = new Figure(600, 10);
$line_vertical
	->setBackgroundColor(119, 99, 77)
	->setTop(240)
	->create();

$line_horizontal = new Figure(1, 240);
$line_horizontal
	->setBackgroundColor(79, 72, 67)
	->setLeft(120)
	->create();

$canvas = new Canvas($canvas_figure);
$canvas
	->append([
	  $line_horizontal,
	  $avatar_box2,
	  $avatar_box3,
	  $avatar_box,
	  $avatar_image,
	  $about_text,
	  $twitter_text,
	  $line_vertical
	])
	->toPNG()
	->draw()
	->save('./card.png');
```

For more examples check out the [./examples](./examples) dir.

## Changelog
Check out the [CHANGELOG.md](./CHANGELOG.md) file.

## Documentation
Read [API Documentation](http://joseluisq.github.io/gimage/#documentation)

## Contribution
If you would like to contribute [pull requests](https://github.com/joseluisq/gimage/pulls) and [issues](https://github.com/joseluisq/gimage/issues) will be welcome! Feature requests are welcome. Please before sending some feature requests make sure provide as much detail and context as possible.

## License
MIT license

© 2017 [José Luis Quintana](https://git.io/joseluisq)
