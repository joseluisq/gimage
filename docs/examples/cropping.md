# Cropping

## Custom cropping
The following example loads an image (`600x199`) and crops part of an image (`200x100`).

!!! tip "Tip"
    `crop(w, h, x, y)` is useful when we needs a custom cropping. we can specify the size and `x`, `y` coords.

```php
<?php

use GImage\Image;

// PNG image (600x199)
$arch_url = 'https://i.imgur.com/G5MR088.png';

$arch_img = new Image();
$arch_img
    ->load($arch_url)
    // crop (200px x 100px) x=10 and y=20
    ->crop(200, 100, 10, 20)
    // save the resource
    ->save('crop.png');
```


## Center cropping

We can also to do an automatic-size cropping. The example crops an image proportionally based on given values (width and height).

!!! tip "Tip"
    `centerCrop(w, h)` calculates the image size, resize and crop it proportionally and centered. Making the cropping contain most of the original image.

```php
<?php

use GImage\Image;

// PNG image (600x199)
$arch_url = 'https://i.imgur.com/G5MR088.png';

$arch_img = new Image();
$arch_img
    ->load($arch_url)
    // crop (80px x 80px)
    ->centerCrop(80, 80)
    // save the resource
    ->save('center_crop.png');
```
