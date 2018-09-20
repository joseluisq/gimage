# Figure

> `Figure` class allows to create rectangles or ellipses shapes.

The following example creates a rectangle, set opacity to 75% and save it as PNG:

```php
<?php

use GImage\Figure;

$rectangle = new Figure(400, 250);
$rectangle
    // Figures are rectangles by default
    // ->isRectangle()
    ->setBackgroundColor(0, 0, 255)
    ->setOpacity(0.75)
    ->create()
    ->save('/home/my_user/images/reactangle.png');
```

As above example, we can also create an ellipse:

```php
<?php

use GImage\Figure;

$ellipse = new Figure(300, 300);
$ellipse
    // Figure as an Elipse
    ->isEllipse()
    ->setBackgroundColor(255, 0, 0)
    ->setOpacity(0.5)
    ->create()
    ->save('/home/my_user/images/ellipse.png');
```
