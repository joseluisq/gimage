<?php
/*
 * This file is part of GImage.
 *
 * (c) José Luis Quintana <https://git.io/joseluisq>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Render an image from resource.
 *
 * @author José Luis Quintana <https://git.io/joseluisq>
 */

namespace GImage\Examples;

use GImage\Image;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

// Create a 240x100 image
$width = 240;
$height = 100;
$rectangle = imagecreatetruecolor($width, $height);
$green = imagecolorallocate($rectangle, 0, 255, 0);
imagefilledrectangle($rectangle, 0, 0, $width, $height, $green);

// Load and process the rectangle image resource
$img = new Image();
$img
  ->load($rectangle)
  // scale to 50%
  ->scale(0.50)
  ->toPNG()
  ->save(__DIR__ . '/rectangle.png');
