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
 * Creating a Rectangle.
 *
 * @author Jose Quintana <https://git.io/joseluisq>
 */

namespace GImage\Examples;

use GImage\Figure;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

$figure = new Figure(400, 250);
$figure
    ->isRectangle()
    ->setBackgroundColor(0, 0, 255)
    ->setOpacity(0.5)
    ->create()
    ->save(__DIR__ . '/reactangle.png');
