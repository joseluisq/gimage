# Rotation

The following example rotates a PNG image 90°.

```php
<?php

use GImage\Image;

$image = new Image();
$image
    ->load('https://i.imgur.com/G5MR088.png')
    // Rotate 90°
    ->rotate(90)
    // Save on local
    ->save('rotate_image.png');
```
