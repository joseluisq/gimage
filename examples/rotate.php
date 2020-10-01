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
 * Rotate an JPG image.
 *
 * @author Jose Quintana <https://git.io/joseluisq>
 */

namespace GImage\Examples;

use GImage\Image;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

// Rotate an image to 90º
$image = new Image();
$image
    ->load('https://i.imgur.com/G5MR088.png')
    ->scale(0.5)
    ->rotate(90)
    // Change to PNG
    ->toPNG()
    // Add opacity 70%
    ->setOpacity(0.7)
    ->save(__DIR__ . '/rotate.png');
