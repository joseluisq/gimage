<?php

/**
 * Creating Canvas with Text
 */

define('BASE_PATH', dirname(__FILE__));
define('ROOT_PATH', dirname(BASE_PATH));
define('TMP_PATH', ROOT_PATH . '/tmp');
define('GIMAGE_PATH', ROOT_PATH . '/src/gimage');

require GIMAGE_PATH . '/gutils.php';
require GIMAGE_PATH . '/gimage.php';
require GIMAGE_PATH . '/gfigure.php';
require GIMAGE_PATH . '/gtext.php';
require GIMAGE_PATH . '/gcanvas.php';

$figure = new GFigure(400, 250);
$figure->setBackgroundColor(47, 42, 39);
$figure->create();

$text = new GText('Imprimir una imagen PNG al navegador o a un archivo');
$text->setWidth(400);
$text->setHeight(250);
$text->setLineHeight(1.2);
$text->setAlign('center');
$text->setValign('center');
$text->setSize(22);
$text->setColor(255, 255, 255);
$text->setFontface(BASE_PATH . '/fonts/Lato-Bol.ttf');

$canvas = new GCanvas($figure);
$canvas->append($text);
$canvas->toPNG();
$canvas->draw();
$canvas->save(TMP_PATH . '/text.png');
