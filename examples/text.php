<?php

/**
 * Creating Canvas with Text
 */

namespace GImage\Examples;

use GImage\Text;
use GImage\Figure;
use GImage\Canvas;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

$figure = new Figure(400, 250);
$figure->setBackgroundColor(47, 42, 39);
$figure->create();

$text = new Text('Output PNG file to browser o save into file.');
$text->setWidth(400);
$text->setHeight(250);
$text->setLineHeight(1.2);
$text->setAlign('center');
$text->setValign('center');
$text->setSize(22);
$text->setColor(255, 255, 255);
$text->setFontface(BASE_PATH . '/fonts/Lato-Bol.ttf');

$canvas = new Canvas($figure);
$canvas->append($text);
$canvas->toPNG();
$canvas->draw();
$canvas->save(__DIR__ . '/text.png');
