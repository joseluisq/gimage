<?php

/**
 * Rotate an image
 */

require __DIR__ . '/_config.php';

require GIMAGE_PATH . '/gutils.php';
require GIMAGE_PATH . '/gimage.php';

// Rotate an image to 90º
$image = new GImage();
$image->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=100.jpg');
$image->rotate(90);
$image->save(TMP_PATH . '/rotate.jpg');
