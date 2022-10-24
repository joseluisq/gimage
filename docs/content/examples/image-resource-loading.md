# Image resource loading

The following example loads an image resource using the `load($src)` method.

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
  // scale to 50%
  ->scale(0.5)
  ->toPNG()
  ->save('rectangle.png');
```
