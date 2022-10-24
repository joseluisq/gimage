# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]


## [4.0.0] - 2022-10-24

This major release is fundamentally an upgrade of the minimum PHP version required (`7.4.x` or newer), API remains basically the same, new posibility to load an image from a `resource` or `GdImage` input, two new small getter methods for GImage along with other notable project improvements.
And as noted, the project resumes its maintenance after a long period. 

### Added
- Annotate methods that return same class via return [`static`](https://wiki.php.net/rfc/static_return_type).
- PHP `8.0` support. PR [#35](https://github.com/joseluisq/gimage/issues/35)
- PHP `8.1` support. PR [#37](https://github.com/joseluisq/gimage/issues/37)
  - Improve PHP `8.1` tests and CI
  - Fixes missing types casting for PHP `8.1`
- Load an image from a `resource` (PHP 7.4) or [`\GdImage`](https://php.watch/versions/8.0/gdimage) (PHP `8.x`) via `GImage->load($src)` method. PR [#38](https://github.com/joseluisq/gimage/issues/38)
- New `GImage->isImageResource()` (PHP 7.4) and `GImage->isImageGdImage()` (PHP `8.x`) methods.

### Deprecated
- PHP `7.3` or lower is deprecated. Now GImage requires PHP `7.4.x` or `8.x` along with a latest GD extension.

### Changed
- Improve example files.
- GitHub Actions as a new CI for testing the library against PHP `7.4.x`, `8.0.x` and `8.1.x`.
- Several documentation improvements.

## [3.0.6] - 2018-04-26

### Added
- `isImageString` method. (PR [#29](https://github.com/joseluisq/gimage/issues/30))

### Fixed
- `$url` is undefined in loadImageFromResource method. (PR [#30](https://github.com/joseluisq/gimage/issues/30) by @franklee0902)
- `Utils::isJPGResource` and `Utils::isPNGResource` method require a string parameter. (PR [#30](https://github.com/joseluisq/gimage/issues/30) by @franklee0902)

## [3.0.5] - 2018-04-24

### Added
- Load an image resource directly. (Issue [#29](https://github.com/joseluisq/gimage/issues/29))

## [3.0.4] - 2017-12-23

### Fixed
- Undefined variable `$info`. (PR [#26](https://github.com/joseluisq/gimage/pull/26) by @sunnyphp)
- First example syntax. (PR [#25](https://github.com/joseluisq/gimage/pull/25) by @sunnyphp)


## [3.0.3] - 2017-10-07

### Added
- __Image:__ Added `render()` method can render the image in-memory and return the resource. (REF [02c5480](https://github.com/joseluisq/gimage/commit/02c5480))
- __Image:__ Added `render()` example about at `examples/render.php`

### Changed
- __Text:__ Default value in `setContent($str =  '')` function.

### Fixed
- Fixed issue #20.
- Doc comments in classes.

## [3.0.2] - 2017-04-30

### Added
- __Image:__ Added the `Image::addOpacityFilter()` method with protected visiblity.

### Changed
- Remove unused imports. (PR [#16](https://github.com/joseluisq/gimage/pull/16) by @matiit)
- Simplify importing Image properties in the `Image::from()` method. (PR [#14](https://github.com/joseluisq/gimage/pull/14) by @matiit)

### Fixed
- __Figure:__ Fixes for add correctly the opacity filter in rectangles and ellipses. (Issue [#15](https://github.com/joseluisq/gimage/issues/15))
- __Image:__ Render fixes for add correctly PNG's opacity.
- __Utils:__ Fixed the `Utils::fixPNGOpacity()` method.


## [3.0.1] - 2017-04-14

### Added
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

[Unreleased]: https://github.com/joseluisq/gimage/compare/4.0.0...HEAD
[4.0.0]: https://github.com/joseluisq/gimage/compare/3.0.6...4.0.0
[3.0.6]: https://github.com/joseluisq/gimage/compare/3.0.5...3.0.6
[3.0.5]: https://github.com/joseluisq/gimage/compare/3.0.4...3.0.5
[3.0.4]: https://github.com/joseluisq/gimage/compare/3.0.3...3.0.4
[3.0.3]: https://github.com/joseluisq/gimage/compare/3.0.2...3.0.3
[3.0.2]: https://github.com/joseluisq/gimage/compare/3.0.1...3.0.2
[3.0.1]: https://github.com/joseluisq/gimage/compare/3.0.0...3.0.1
[3.0.0]: https://github.com/joseluisq/gimage/compare/2.0.1...3.0.0
[2.0.1]: https://github.com/joseluisq/gimage/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/joseluisq/gimage/compare/1.5.2...2.0.0
[1.5.2]: https://github.com/joseluisq/gimage/compare/1.5.1...1.5.2
[1.5.1]: https://github.com/joseluisq/gimage/compare/1.5.0...1.5.1
[1.5.0]: https://github.com/joseluisq/gimage/tree/1.5.0
