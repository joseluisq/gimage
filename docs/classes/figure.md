# Figure

> `Figure` class allows to create rectangles or ellipses.

The following example creates an rectangle, set an opacity (75%) and save it as PNG:

```php
<?php

use GImage\Figure;

$rectangle = new Figure(400, 250);
$rectangle
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
    ->isEllipse()
    ->setBackgroundColor(255, 0, 0)
    ->setOpacity(0.5)
    ->create()
    ->save('/home/my_user/images/ellipse.png');
```
