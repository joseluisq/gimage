# GImage

[![Build Status](https://travis-ci.org/quintana-dev/gimage.svg?branch=master)](https://travis-ci.org/quintana-dev/gimage) [![Latest Stable Version](https://poser.pugx.org/joseluisq/gimage/version)](https://packagist.org/packages/joseluisq/gimage) [![Latest Unstable Version](https://poser.pugx.org/joseluisq/gimage/v/unstable)](//packagist.org/packages/joseluisq/gimage) [![Total Downloads](https://poser.pugx.org/joseluisq/gimage/downloads)](https://packagist.org/packages/joseluisq/gimage) [![License](https://poser.pugx.org/joseluisq/gimage/license)](https://packagist.org/packages/joseluisq/gimage)

> A simple PHP library for easy image handling.

GImage is a simple extended library based on [PHP Image Processing and GD](http://php.net/manual/en/book.image.php) for easy image handling. With GImage you can read, create, crop, resize, rotate, embed text, merge and save your JPG or PNG images easy. GImage require **PHP 5.3** or higher and [GD Extension](http://php.net/manual/en/book.image.php).

![A simple presentation card with GImage](https://cloud.githubusercontent.com/assets/1700322/11167177/21e9f6ca-8b25-11e5-8737-c50a48506f17.png)

[*View sample code*](#creating-a-simple-presentation-card)

## Usage

### Basic

Working with external JPG image and output on browser as PNG format.

```php
<?php
require 'src/gutils.php';
require 'src/gimage.php';

// Loading an image (200x200) from an URL (or local path)
$avatar = new GImage();
$avatar->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200.jpg');
// Scaling to 50% (100x100)
$avatar->scale(50);
// Changing to PNG format
$avatar->toPNG();
// Preserving the image before saving or outputting
$avatar->preserve();
// Saving to local path
$avatar->save('my-avatar.png');
// Preparing for destroy the resource after outputting
$avatar->preserve(false);
// Outputting on the browser and destroy the resource.
$avatar->output();
```

### Using GFigure

Creating a simple green rectangle.

```php
<?php
require 'src/gutils.php';
require 'src/gfigure.php';
require 'src/gimage.php';

// Setting rectangle sizes
$rectangle = new GFigure(500, 300);
// Setting a green background color
$rectangle->setBackgroundColor(170, 188, 147);
// Creating the figure
$rectangle->create();
// Outputting JPG image (by default) on the browser.
$rectangle->output();
```

### Creating a simple presentation card
Creating a simple presentation card with GImage, GCanvas, GFigure and GText.

```php
<?php
require 'src/gutils.php';
require 'src/gimage.php';
require 'src/gfigure.php';
require 'src/gtext.php';
require 'src/gcanvas.php';

$avatar_image = new GImage();
$avatar_image->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=100.jpg');
$avatar_image->setTop(60);
$avatar_image->setLeft(70);

$about_text = new GText("MY AWESOME PRESENTATION CARD GENERATED WITH GIMAGE");
$about_text->setSize(16);
$about_text->setWidth(300);
$about_text->setLeft(210);
$about_text->setTop(75);
$about_text->setColor(204, 164, 116);
$about_text->setFontface('fonts/Lato-Light.ttf');

$twitter_text = new GText('@username');
$twitter_text->setSize(11);
$twitter_text->setWidth(70);
$twitter_text->setLeft(450);
$twitter_text->setTop(210);
$twitter_text->setColor(130, 127, 125);
$twitter_text->setFontface('fonts/Lato-Regular.ttf');

$canvas_figure = new GFigure(550, 250);
$canvas_figure->setBackgroundColor(47, 42, 39);
$canvas_figure->create();

$avatar_box = new GFigure($avatar_image->getWidth() + 16, $avatar_image->getHeight() + 17);
$avatar_box->setBackgroundColor(63, 56, 52);
$avatar_box->setLeft($avatar_image->getLeft() - 7);
$avatar_box->setTop($avatar_image->getTop() - 8);
$avatar_box->create();

$avatar_box2 = new GFigure($avatar_image->getWidth() + 3, $avatar_image->getHeight() + 19);
$avatar_box2->setBackgroundColor(79, 72, 67);
$avatar_box2->setLeft($avatar_image->getLeft() + 7);
$avatar_box2->setTop($avatar_image->getTop() - 9);
$avatar_box2->create();

$avatar_box3 = new GFigure(120, 240);
$avatar_box3->setBackgroundColor(63, 56, 52);
$avatar_box3->create();

$line_vertical = new GFigure(600, 10);
$line_vertical->setBackgroundColor(119, 99, 77);
$line_vertical->setTop(240);
$line_vertical->create();

$line_horizontal = new GFigure(1, 240);
$line_horizontal->setBackgroundColor(79, 72, 67);
$line_horizontal->setLeft(120);
$line_horizontal->create();

$canvas = new GCanvas();
$canvas->from($canvas_figure);
$canvas->append(array(
  $line_horizontal,
  $avatar_box2,
  $avatar_box3,
  $avatar_box,
  $avatar_image,
  $about_text,
  $twitter_text,
  $line_vertical
));
$canvas->toPNG();
$canvas->draw();
$canvas->save('card.png');
```

## Contribution
If you would like to contribute [pull requests](https://github.com/quintana-dev/gimage/pulls) and [issues](https://github.com/quintana-dev/gimage/issues) will be welcome! Feature requests are welcome. Please before sending some feature requests make sure provide as much detail and context as possible.

## License
MIT license

© 2015 [José Luis Quintana](http://quintana.io)
