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
 * Rendering an image in memory and return the resource.
 *
 * @author Jose Quintana <https://joseluisq.net>
 */

namespace GImage\Examples;

use GImage\Image;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

$image = new Image();
$resource = $image
    ->load('https://i.imgur.com/vLXIIoY.jpg')
    // Scale down to 20%
    ->scale(0.2)
    // Rotate an image to -90º
    ->rotate(-90)
    // Change to PNG
    ->toPNG()
    // Add opacity 70%
    ->setOpacity(0.7)
    // Render the image in-memory
    ->render();

// Output the buffer on web browser (example only)
header('Content-Type: image/png');
// Necessary for opacity to work
imagesavealpha($resource, true);
imagepng($resource, null);
