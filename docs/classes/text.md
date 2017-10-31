# Text

> `Text` class allows to use text to be embedded into `Canvas`.

Example below creates a text with opacity using a custom TTF font:

!!! tip "Tip"
    Using `setWidth()` or `setHeight()` methods we can control the width and height of the text on canvas.

```php
<?php

$text = new Text('My ustom text with opacity!');
$text
    ->setWidth(400)
    ->setHeight(250)
    ->setTop(50)
    ->setLeft(50)
    ->setSize(22)
    ->setOpacity(0.5)
    ->setColor(255, 255, 255)
    ->setFontface('/home/my_user/fonts/Lato.ttf');

// Used as layout
$layout = new Figure(350, 180);
$layout
    ->setBackgroundColor(300, 300, 300)
    ->create();

$canvas = new Canvas($layout);
$canvas
    ->append($text)
    ->toPNG()
    ->draw()
    ->save('/home/my_user/images/my_text.png');
```
