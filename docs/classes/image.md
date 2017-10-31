# Image

> `Image` class is the parent class for `Figure` and `Canvas` classes.

Example below loads an image from local path, scale (50%) and output it on the browser:

!!! tip "Tip"
    `load()`method can load an image from any url or local path.

```php
<?php

use GImage\Image;

$img = new Image();
$img
	->load('/home/my_user/images/my_image.png')
	->scale(0.5)
	->output();
```

`Figure` and `Canvas` extend from `Image`. This means that it's possible to use many functions like `crop()`, `centerCrop()`, `rotate()` and so on.

Example below creates an rectangle, set an opacity (75%) and save it as PNG:

```php
<?php

use GImage\Figure;

$figure = new Figure(400, 250);
$figure
    ->setBackgroundColor(0, 0, 255)
    ->setOpacity(0.75)
    ->create()
    ->save('/home/my_user/images/reactangle.png');
```
