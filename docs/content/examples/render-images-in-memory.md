# Render images in-memory

The following example renders an image in-memory and return the string resource.

```php
<?php

use GImage\Image;

$img = new Image();
$arch_url = 'https://i.imgur.com/G5MR088.png';

$resource = $img->load($arch_url)
    // Scale 120%
    ->scale(1.2)
    // Rotate an image to -90º
    ->rotate(-90)
    // Change to PNG
    ->toPNG()
    // Add opacity 70%
    ->setOpacity(0.7)
    // Render the image in-memory
    ->render();

// Output the resource (example only)
header('Content-Type: image/png');
// Necessary for opacity to work
imagesavealpha($resource, true);
imagepng($resource, null);
```
