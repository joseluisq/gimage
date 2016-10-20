<?php

/**
 * Rotate an image
 */

namespace GImage\Examples;

use GImage\Image;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

// Rotate an image to 90º
$image = new Image();
$image
    ->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=100.jpg')
    ->rotate(90)
    ->save(__DIR__ . '/rotate.jpg');
