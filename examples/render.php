<?php
/*
 * This file is part of GImage.
 *
 * (c) Jose Quintana <https://git.io/joseluisq>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Render an image in-memory and return the resource.
 *
 * @author Jose Quintana <https://git.io/joseluisq>
 */

namespace GImage\Examples;

use GImage\Image;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

$image = new Image();
$resource = $image
    ->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200.jpg')
    // Scale 120%
    ->scale(1.2)
    // Rotate an image to -90º
    ->rotate(-90)
    // Change to PNG
    ->toPNG()
    // Add opacity 70%
    ->setOpacity(0.7)
    // Render the image in-memory
    ->render();

// Output the buffer (example only)
header('Content-Type: image/png');
// Necessary for opacity to work
imagesavealpha($resource, true);
imagepng($resource, null);
