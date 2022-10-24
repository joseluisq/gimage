# Image

> `Image` class is the parent class for `Figure` and `Canvas` classes. So `Figure` and `Canvas` be able to access to `save()`, `crop()`, `output()` and other methods provided by `Image`.

## Saving

The example below loads and external imagen and save it on local.

!!! tip "Tip"
    `load(f)` function can load an image file from any url or local valid path.

```php
<?php

use GImage\Image;

$img = new Image();
$img
	->load('https://i.imgur.com/G5MR088.png')
	->scale(0.5)
    ->save('/home/my_user/images/myimage.png');
```

## Output

Loading an image from local path, scale (50%) and output it on the browser.

```php
<?php

use GImage\Image;

$img = new Image();
$img
	->load('/home/my_user/images/my_image.png')
	->scale(0.5)
	->output();
```

## Preserve resource

`save()` and `output()` functions remove the image resource _in memory_ after processing.
To preserve the image resource for future processings only call `preserve()` function before saving or outputing, then `preserve(false)` when your processing have been completed.

```php
<?php

use GImage\Image;

$img = new Image();
$img
	->load('/home/my_user/images/my_image.png')
    ->centerCrop(50, 50)
    // preserve the resource before save
    ->preserve();
    // save only
	->save();
    // remove the resource after output
	->preserve(false);
    // output and remove the resource
	->output();
```

## Reuse Image functions

`Figure` and `Canvas` extend from `Image`. This means that it's possible to use many inherited functions like `save()`, `crop()`, `rotate()` and so on.

For example the code below creates an rectangle, set an opacity to 75% and save it as PNG.

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
