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
 * Creating a Canvas with Text.
 *
 * @author Jose Quintana <https://joseluisq.net>
 */

namespace GImage\Examples;

use GImage\Text;
use GImage\Figure;
use GImage\Canvas;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

$figure = new Figure(400, 250);
$figure
    ->setBackgroundColor(47, 42, 39)
    ->create();

$text = new Text('My Text with opacity!');
$text
    ->setWidth(400)
    ->setHeight(250)
    ->setAlign('center') // or "none"
    ->setValign('center') // or "none"
    // Or use line height
    // ->setLineHeight(1.2)

    ->setSize(22)
    ->setOpacity(0.5)
    ->setColor(255, 255, 255)
    ->setFontface(BASE_PATH . '/fonts/Lato-Bol.ttf');

$canvas = new Canvas($figure);
$canvas
    ->append($text)
    ->toPNG()
    ->draw()
    ->save(__DIR__ . '/text.png');
