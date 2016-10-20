# GImage

[![Build Status](https://travis-ci.org/joseluisq/gimage.svg?branch=master)](https://travis-ci.org/joseluisq/gimage) [![Latest Stable Version](https://poser.pugx.org/joseluisq/gimage/version)](https://packagist.org/packages/joseluisq/gimage) [![Latest Unstable Version](https://poser.pugx.org/joseluisq/gimage/v/unstable)](//packagist.org/packages/joseluisq/gimage) [![Total Downloads](https://poser.pugx.org/joseluisq/gimage/downloads)](https://packagist.org/packages/joseluisq/gimage) [![License](https://poser.pugx.org/joseluisq/gimage/license)](https://packagist.org/packages/joseluisq/gimage)

> A simple PHP library for easy image handling.

GImage is a simple extended library based on [PHP Image Processing and GD](http://php.net/manual/en/book.image.php) for easy image handling. With GImage you can read, create, crop, resize, rotate, embed text, merge and save your JPG or PNG images easy. GImage require **PHP 5.5** or later and [GD Extension](http://php.net/manual/en/book.image.php).

![A simple presentation card with GImage](https://cloud.githubusercontent.com/assets/1700322/18941713/eed7fa34-85d8-11e6-8033-bf787e4aa236.png)

[*View sample code*](#creating-a-simple-presentation-card)

## Install

```sh
composer require joseluisq/gimage
```

## Usage

### Basic

Working with external JPG image and output on browser as PNG format.

```php
<?php

use GImage\Image;

$avatar = new Image();
$avatar
	// Loading an image (200x200) from an URL (or local path)
	->load('https://assets-cdn.github.com/images/modules/logos_page/Octocat.png');
	// Scaling to 50% (100x100)
	->scale(50)
	// Changing to PNG format
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

### Using a Figure

Creating a simple green rectangle.

```php
<?php

use GImage\Figure;

// Setting rectangle sizes
$rectangle = new Figure(500, 300);
$rectangle
	// Setting a green background color
	->setBackgroundColor(170, 188, 147)
	// Creating the figure
	->create()
	// Outputting JPG image (by default) on the browser.
	->output();
```

### Creating a simple presentation card
Creating a simple presentation card with Image, Canvas, Figure and GText.

```php
<?php

use GImage\Image;
use GImage\Text;
use GImage\Figure;
use GImage\Canvas;

$avatar_image = new GImage();
$avatar_image
	->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=100.jpg')
	->setTop(60)
	->setLeft(70);

$about_text = new GText("MY AWESOME PRESENTATION CARD GENERATED WITH GIMAGE");
$about_text
	->setSize(16)
	->setWidth(300)
	->setLeft(210)
	->setTop(75)
	->setColor(204, 164, 116)
	->setFontface('fonts/Lato-Light.ttf');

$twitter_text = new GText('@username');
$twitter_text
	->setSize(11)
	->setWidth(70)
	->setLeft(450)
	->setTop(210)
	->setColor(130, 127, 125)
	->setFontface('fonts/Lato-Regular.ttf');

$canvas_figure = new GFigure(550, 250);
$canvas_figure
	->setBackgroundColor(47, 42, 39)
	->create();

$avatar_box = new GFigure($avatar_image->getWidth() + 16, $avatar_image
	->getHeight() + 17);
$avatar_box
	->setBackgroundColor(63, 56, 52)
	->setLeft($avatar_image->getLeft() - 7)
	->setTop($avatar_image->getTop() - 8)
	->create();

$avatar_box2 = new GFigure($avatar_image->getWidth() + 3, $avatar_image
	->getHeight() + 19);
$avatar_box2
	->setBackgroundColor(79, 72, 67)
	->setLeft($avatar_image->getLeft() + 7)
	->setTop($avatar_image->getTop() - 9)
	->create();

$avatar_box3 = new GFigure(120, 240);
$avatar_box3
	->setBackgroundColor(63, 56, 52)
	->create();

$line_vertical = new GFigure(600, 10);
$line_vertical
	->setBackgroundColor(119, 99, 77)
	->setTop(240)
	->create();

$line_horizontal = new GFigure(1, 240);
$line_horizontal
	->setBackgroundColor(79, 72, 67)
	->setLeft(120)
	->create();

$canvas = new GCanvas();
$canvas
	->from($canvas_figure)
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
	->save('card.png');
```

## Contribution
If you would like to contribute [pull requests](https://github.com/joseluisq/gimage/pulls) and [issues](https://github.com/joseluisq/gimage/issues) will be welcome! Feature requests are welcome. Please before sending some feature requests make sure provide as much detail and context as possible.

## Documentation
Read [API Documentation](http://joseluisq.github.io/gimage/#documentation)

## License
MIT license

© 2016 [José Luis Quintana](https://git.io/joseluisq)
