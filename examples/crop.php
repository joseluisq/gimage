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
 * Cropping an image.
 *
 * @author Jose Quintana <https://joseluisq.net>
 */

namespace GImage\Examples;

use GImage\Image;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

$image = new Image();
$image
    // Load an image (500px x 500px)
    ->load('https://i.imgur.com/vLXIIoY.jpg')
    // Resize and crop in the middle (100px x 60px)
    ->centerCrop(100, 60)
    // Save the resource
    ->save(__DIR__ . '/crop.jpg');
