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
 * Rotate an image.
 *
 * @author Jose Luis Quintana <https://git.io/joseluisq>
 */

namespace GImage\Examples;

use GImage\Image;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

// Rotate an image to 90º
$image = new Image();
$image
    ->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200.jpg')
    ->scale(0.5)
    ->rotate(90)
    ->toPNG()
    ->setOpacity(0.7)
    ->save(__DIR__ . '/rotate.png');
