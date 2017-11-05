# Canvas

> `Canvas` represents an area on which it can append images, text and figures.

!!! tip "Note"
    __Canvas__ needs a `Figure` or `Image` which will be used as base element (layout).

The following example uses `append()` method to attach elements to canvas.

!!! tip "Tip"
    Using  `setLeft()` or `setTop()` methods it can control the position (x,y) of the elements (`Figure`, `Image` or `Text`) on canvas.

```php
<?php

use GImage\Image;
use GImage\Figure;
use GImage\Canvas;

$image = new Image();
$image
    ->load('https://my_website.com/images/my_image.png')

$ellipse = new Figure(200, 200);
$ellipse
    ->isEllipse()
    ->setBackgroundColor(200, 0, 0)
    ->setTop(60)
    ->setLeft(70)
    ->create()

// Used as layout
$layout = new Figure(200, 200);
$layout
    ->setBackgroundColor(0, 0, 255)
    ->create()

$canvas = new Canvas($layout);
$canvas
    ->append([$image, $ellipse])
    ->toPNG()
    ->draw()
    ->save('/home/my_user/images/my_composed_image.png');
```
