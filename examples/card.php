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
$avatar_image
    ->load('https://assets-cdn.github.com/images/modules/logos_page/Octocat.png')
    ->centerCrop(100, 100)
    ->setTop(60)
    ->setLeft(70);

$about_text = new Text("MY AWESOME PRESENTATION CARD\n~ BY GIMAGE ~");
$about_text->setSize(16)
    ->setWidth(300)
    ->setLeft(210)
    ->setLineHeight(1.5)
    ->setTop(75)
    ->setColor(204, 164, 116)
    ->setFontface(BASE_PATH . '/fonts/Lato-Lig.ttf');

$twitter_text = new Text('@joseluisq/gimage');
$twitter_text
    ->setSize(11)
    ->setWidth(70)
    ->setLeft(410)
    ->setTop(210)
    ->setColor(130, 127, 125)
    ->setFontface(BASE_PATH . '/fonts/Lato-Reg.ttf');

$canvas_figure = new Figure(550, 250);
$canvas_figure
    ->setBackgroundColor(47, 42, 39)
    ->create();

$avatar_box = new Figure($avatar_image->getWidth() + 16, $avatar_image->getHeight() + 17);
$avatar_box
    ->setBackgroundColor(63, 56, 52)
    ->setLeft($avatar_image->getLeft() - 7)
    ->setTop($avatar_image->getTop() - 8)
    ->create();

$avatar_box2 = new Figure($avatar_image->getWidth() + 3, $avatar_image->getHeight() + 19);
$avatar_box2
    ->setBackgroundColor(79, 72, 67)
    ->setLeft($avatar_image->getLeft() + 7)
    ->setTop($avatar_image->getTop() - 9)
    ->create();

$avatar_box3 = new Figure(120, 240);
$avatar_box3
    ->setBackgroundColor(63, 56, 52)
    ->create();

$line_vertical = new Figure(600, 10);
$line_vertical
    ->setBackgroundColor(119, 99, 77)
    ->setTop(240)
    ->create();

$line_horizontal = new Figure(1, 240);
$line_horizontal
    ->setBackgroundColor(79, 72, 67)
    ->setLeft(120)
    ->create();

$canvas = new Canvas();
$canvas
    ->from($canvas_figure)
    ->append([
    $line_horizontal,
    $avatar_box2,
    $avatar_box3,
    $avatar_box,
    $avatar_image,
    $about_text,
    $twitter_text,
    $line_vertical
    ])
    ->toPNG()
    ->draw()
    ->save(__DIR__ . '/card.png');
