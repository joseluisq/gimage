# Text embedding

GImage supports a text embedding with custom TTF fonts using `Text` class with `Canvas`.

!!! tip "Tip"
    Use `setAlign(str)`, `setValign(str)` functions for control the aligment, `setLineHeight(n)` for lines space or `setLeft(x)` and `setTop(y)` for position on canvas.

```php
<?php

use GImage\Text;
use GImage\Figure;
use GImage\Canvas;

// figure layout used as canvas
$figure = new Figure(400, 250);
$figure
    ->setBackgroundColor(47, 42, 39)
    ->create();

// text definition
$text = new Text('My Text with opacity!');
$text
    // box area size for text
    ->setWidth(400)
    ->setHeight(250)
    // aligments
    ->setAlign('center') // or "none"
    ->setValign('center') // or "none"
    // line height
    ->setLineHeight(1.2)
    // font size
    ->setSize(22)
    // font color
    ->setColor(255, 255, 255)
    // font face
    ->setFontface('/my/path/fonts/Lato.ttf');

    ->setOpacity(0.5)

// canvas definition
$canvas = new Canvas($figure);
$canvas
    // append the text element
    ->append($text)
    ->toPNG()
    ->draw()
    ->save('text.png');
```
