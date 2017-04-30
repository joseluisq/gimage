<?php
/*
 * This file is part of GImage.
 *
 * (c) Jose Luis Quintana <https://git.io/joseluisq>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Crop an image.
 *
 * @author Jose Luis Quintana <https://git.io/joseluisq>
 */

namespace GImage\Examples;

use GImage\Image;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

$image = new Image();
$image
    // Load an image (300px x 300px)
    ->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=300.jpg')
    // Resize and crop in the middle (100px x 60px)
    ->centerCrop(100, 60)
    // Save the resource
    ->save(__DIR__ . '/crop.jpg');
