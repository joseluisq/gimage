<?php
/*
 * This file is part of GImage.
 *
 * (c) Jose Quintana <https://joseluisq.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Render an image from resource.
 *
 * @author Jose Quintana <https://joseluisq.net>
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
    // we need to tell GImage about the image type
    ->toPNG()
    // scale to 50%
    ->scale(0.50)
    ->save(__DIR__ . '/rectangle.png');
