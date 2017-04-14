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
 * Creating an Elipse.
 *
 * @author Jose Luis Quintana <https://git.io/joseluisq>
 */

namespace GImage\Examples;

use GImage\Text;
use GImage\Figure;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

$figure = new Figure(300, 200);
$figure
    ->isEllipse()
    ->setBackgroundColor(255, 0, 0)
    ->setOpacity(0.3)
    ->create()
    ->save(__DIR__ . '/ellipse.png');
