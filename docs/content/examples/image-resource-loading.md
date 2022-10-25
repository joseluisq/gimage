# Image resource loading

The following example loads an image `resource` (PHP `7.4`) or `GdImage` (PHP `8.x`)  using the `load($src)` method.

!!! tip "GdImage class"
    Since PHP `8.0` onwards, a new `GdImage` class object replaces the GD image `resource`.<br>
    See more details at https://php.watch/versions/8.0/gdimage.

```php
<?php

use GImage\Image;

// Create a image rectangle (240x100)
$width = 240;
$height = 100;
$rectangle = imagecreatetruecolor($width, $height);
$green = imagecolorallocate($rectangle, 0, 255, 0);
imagefilledrectangle($rectangle, 0, 0, $width, $height, $green);

// Load and process the rectangle image resource
$img = new Image();
$img
  ->load($rectangle)
  // Indicate the image type beforehand
  ->toPNG()// (1)!
  // scale to 50%
  ->scale(0.5)
  // let's change again the image type just for fun
  ->toJPG()
  ->save('rectangle.jpg');
```

1.  It's necessary to tell `GImage` about the image type in those cases since the input is just a `resource` or `GdImage` object.
