<?php

/**
 * Creating a Presentation Card
 */

namespace GImage\Examples;

use GImage\Image;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

$image = new Image();
// Load an image (300px x 300px)
$image->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=300.jpg');
// Resize and crop in the middle (100px x 60px)
$image->centerCrop(100, 60);
$image->save(TMP_PATH . '/crop.jpg');
