# Resizing

## Width resizing

Resizing an image proportionally basing on the width (`height` is calculated).

```php
<?php

use GImage\Image;

$image = new Image();
$image
    ->load('https://i.imgur.com/G5MR088.png')
    // Resize from width
    ->resizeToWidth(200)
    // Save on local
    ->save('resize_width_image.png');
```

## Height resizing

Resizing an image proportionally basing on the height (`width` is calculated).

```php
<?php

use GImage\Image;

$image = new Image();
$image
    ->load('https://i.imgur.com/G5MR088.png')
    // Resize from height
    ->resizeToHeight(80)
    // Save on local
    ->save('resize_height_image.png');
```

!!! tip "Tip"
    Use `getPropWidth(height)` and `getPropHeight(width)` to get the proportional `width` or `height` values only.

## Scale
The following example scales a PNG image 120%.

!!! tip "Tip"
    The `scale(val)` function value should be between 0 and 1

```php
<?php

use GImage\Image;

$image = new Image();
$image
    ->load('https://i.imgur.com/G5MR088.png')
    // Scale 120%
    ->scale(1.2)
    // Save on local
    ->save('rotate_image.png');
```
