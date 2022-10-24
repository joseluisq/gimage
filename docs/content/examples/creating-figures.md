# Creating figures

The Figure class supports two kind of figures like rectangles and ellipses.

!!! tip "Note"
    A figure is a rectangle by default.

## Rectangle

```php
<?php

use GImage\Figure;

$figure = new Figure(350, 200);
$figure
    // ->isRectangle()
    ->setBackgroundColor(255, 0, 0)
    ->create()
    ->save('rectangle.png');
```

## Ellipse

```php
<?php

use GImage\Figure;

$figure = new Figure(200, 200);
$figure
    ->isEllipse()
    ->setBackgroundColor(0, 255, 255)
    ->setOpacity(0.5)
    ->create()
    ->save('ellipse.png');
```
