# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [3.0.2] - 2017-04-30

### Add
- __Image:__ Added the `Image::addOpacityFilter()` method with protected visiblity.

### Changed
- Remove unused imports. (PR https://github.com/joseluisq/gimage/pull/16 by @matiit)
- Simplify importing Image properties in the `Image::from()` method. (PR https://github.com/joseluisq/gimage/pull/16 by @matiit)

### Fixed
- __Figure:__ Fixes for add correctly the opacity filter in rectangles and ellipses. (issue #15)
- __Image:__ Render fixes for add correctly PNG's opacity.
- __Utils:__ Fixed the `Utils::fixPNGOpacity()` method.


## [3.0.1] - 2017-04-14

### Add
- `Utils::fixPNGOpacity()` function that fix the opacity value between `0` and `1` for PNG alpha value.

### Changed
- `setOpacity` (`Figure`, `Image` and `Text` classes) method now support values from `0` to `1` only.

```php
<?php
// Set opacity to 50%
$figure->setOpacity(0.5)
```

### Fixed
- `setOpacity` now works if it loads some JPEG image and then saves it as PNG.
- Fixed the opacity tests.
- Fixed the examples for opacity support.

### Removed
- Some unnecessary functions for figure class.

### Deprecated
- `setOpacity` doesn't support values from 0 to 100.


## [3.0.0] - 2017-02-16
### Added
- Feature: `isEllipse()` method support in `Figure` for create ellipses.
- Feature: `isRectangle()` method support in `Figure` for create rectangles.
- `CHANGELOG.md` file.

### Changed
- `Figure` elements are `PNG` by default.
- Support for `PHP >= 7.0.x` only.
- Update PHPUnit 6.0.
- Update test suite.
- Update README.md.
- Update LICENSE.md.
- Preserve `composer.lock` files.
- Codebase with doc-comments.
- Codebase more standard: `phpcs ./src --standard=PSR2` and `phpcbf -w ./src --standard=PSR2`

### Fixed
- Better support for `Figure` elements with opacity. (0 to 127)
- Better support for `$image->load(..)` method when load image from path or URL.

### Removed
- Guzzle dependency removed.

### Deprecated
- GImage is no longer supported on `PHP <= 5.5`

## [2.0.1] - 2016-10-20
### Changed
- Codebase PSR-2 standard.

### Fixed
- Minor travis fixes.

## [2.0.0] - 2016-09-29
### Added
- Codebase with new syntax and namespaces.
- Codebase are now namespaced (`\GImage`).
- Sources clases was renamed to `Image`, `Figure`, `Text`, `Canvas` and `Utils`.

### Changed
- Make file tests.
- Travis with PHP `7.0` and `7.1`.
- Support for `PHP >= 5.5`

### Removed
- Cleanup some files.

### Deprecated
- GImage is no longer supported on `PHP <= 5.3`

## [1.5.2] - 2016-07-20
### Added
- Composer suggest package.

### Changed
- Examples updated.

## [1.5.1] - 2016-01-12
### Added
- Support line-height for `GText` class.
Example:
```php
<?php
$text = new GText('Lorem ipsum');
$text->setLineHeight(1.2);
```
- Composer support.
- API docs.
- Composer badges.

## [1.5.0] - 2015-11-15
### Added
- Initial commit.
- PHP `5.3` support.

[3.0.2]: https://github.com/joseluisq/gimage/compare/3.0.2...HEAD
[3.0.1]: https://github.com/joseluisq/gimage/compare/3.0.1...3.0.2
[3.0.1]: https://github.com/joseluisq/gimage/compare/3.0.0...3.0.1
[3.0.0]: https://github.com/joseluisq/gimage/compare/2.0.1...3.0.0
[2.0.1]: https://github.com/joseluisq/gimage/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/joseluisq/gimage/compare/1.5.2...2.0.0
[1.5.2]: https://github.com/joseluisq/gimage/compare/1.5.1...1.5.2
[1.5.1]: https://github.com/joseluisq/gimage/compare/1.5.0...1.5.1
[1.5.0]: https://github.com/joseluisq/gimage/tree/1.5.0
