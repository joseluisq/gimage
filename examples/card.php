<?php

/**
 * Creating a Presentation Card
 */

namespace GImage\Examples;

use GImage\Image;
use GImage\Text;
use GImage\Figure;
use GImage\Canvas;

require __DIR__ . '/_config.php';
require __DIR__ . '/../tests/bootstrap.php';

// Creating an avatar image
$avatar_image = new Image();
$avatar_image->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=100.jpg');
$avatar_image->setTop(60);
$avatar_image->setLeft(70);

$about_text = new Text("MY AWESOME PRESENTATION CARD GENERATED WITH GIMAGE");
$about_text->setSize(16);
$about_text->setWidth(300);
$about_text->setLeft(210);
$about_text->setLineHeight(1.2);
$about_text->setTop(75);
$about_text->setColor(204, 164, 116);
$about_text->setFontface(BASE_PATH . '/fonts/Lato-Lig.ttf');

$twitter_text = new Text('@username');
$twitter_text->setSize(11);
$twitter_text->setWidth(70);
$twitter_text->setLeft(450);
$twitter_text->setTop(210);
$twitter_text->setColor(130, 127, 125);
$twitter_text->setFontface(BASE_PATH . '/fonts/Lato-Reg.ttf');

$canvas_figure = new Figure(550, 250);
$canvas_figure->setBackgroundColor(47, 42, 39);
$canvas_figure->create();

$avatar_box = new Figure($avatar_image->getWidth() + 16, $avatar_image->getHeight() + 17);
$avatar_box->setBackgroundColor(63, 56, 52);
$avatar_box->setLeft($avatar_image->getLeft() - 7);
$avatar_box->setTop($avatar_image->getTop() - 8);
$avatar_box->create();

$avatar_box2 = new Figure($avatar_image->getWidth() + 3, $avatar_image->getHeight() + 19);
$avatar_box2->setBackgroundColor(79, 72, 67);
$avatar_box2->setLeft($avatar_image->getLeft() + 7);
$avatar_box2->setTop($avatar_image->getTop() - 9);
$avatar_box2->create();

$avatar_box3 = new Figure(120, 240);
$avatar_box3->setBackgroundColor(63, 56, 52);
$avatar_box3->create();

$line_vertical = new Figure(600, 10);
$line_vertical->setBackgroundColor(119, 99, 77);
$line_vertical->setTop(240);
$line_vertical->create();

$line_horizontal = new Figure(1, 240);
$line_horizontal->setBackgroundColor(79, 72, 67);
$line_horizontal->setLeft(120);
$line_horizontal->create();

$canvas = new Canvas();
$canvas->from($canvas_figure);
$canvas->append(array(
  $line_horizontal,
  $avatar_box2,
  $avatar_box3,
  $avatar_box,
  $avatar_image,
  $about_text,
  $twitter_text,
  $line_vertical
));
$canvas->toPNG();
$canvas->draw();
$canvas->save(TMP_PATH . '/card.png');
