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
 * Creating a Rectangle.
 *
 * @author Jose Luis Quintana <https://git.io/joseluisq>
 */

namespace GImage\Examples;

use GImage\Text;
use GImage\Figure;
use GImage\Canvas;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

// Tip: By default a Figure is a rectangle

$figure = new Figure(400, 250);
$figure
    ->isRectangle()
    ->setBackgroundColor(0, 0, 255)
    ->setOpacity(50)
    ->create()
    ->save(__DIR__ . '/reactangle.png');
