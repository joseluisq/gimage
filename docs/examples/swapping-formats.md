# Swapping formats

It's possible to swapping image formats. The following example loads a PNG image and save it as JPG.

```php
<?php

use GImage\Image;

// PNG image (600x199)
$arch_url = 'https://i.imgur.com/G5MR088.png';

$arch_img = new Image();
$arch_img
    ->load($arch_url)
    ->crop(20, 20)
    ->toJPG()
    ->save('arch.jpg');
```

Or outputting it on browser:

```php
<?php

use GImage\Image;

// PNG image (600x199)
$arch_url = 'https://i.imgur.com/G5MR088.png';

$arch_img = new Image();
$arch_img
    ->load($arch_url)
    ->scale(0.5)
    ->toJPG()
    ->output();
```
