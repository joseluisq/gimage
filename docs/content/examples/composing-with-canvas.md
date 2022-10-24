# Composing with canvas

Canvas class is useful to composing several elements like images, text and figures.

!!! tip "Tip"
    Canvas `append(arr)` function also supports an array of elements.


```php
<?php

use GImage\Text;
use GImage\Image;
use GImage\Figure;
use GImage\Canvas;

$img1 = new Image();
$img1
    ->load('https://i.imgur.com/G5MR088.png')
    ->scale(0.5);

$figure1 = new Figure(300, 150);
$figure1
    ->setBackgroundColor(10, 20, 30)
    ->create();

$text1 = new Text('My awesome text!');
$text1
    ->setSize(18)
    ->setColor(255, 255, 255)
    ->setFontface('/my/path/fonts/times.ttf');

// used as canvas layout
$figure0 = new Figure(400, 250);
$figure0
    ->setBackgroundColor(50, 20, 30)
    ->create();

$canvas = new Canvas($figure0);
$canvas
    // append every element
    ->append($figure1)
    ->append($img1)
    ->append($text1)
    // as PNG format
    ->toPNG()
    // draw the canvas with all elements
    ->draw()
    ->save('text.png');
```

For more details check out [the presentation card](./creating-a-presentation-card.md) example.
