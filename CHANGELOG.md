# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [3.0.0]
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

[Unreleased]: https://github.com/joseluisq/gimage/compare/v3.0.0...HEAD
[3.0.0]: https://github.com/joseluisq/gimage/compare/v2.0.1...v3.0.0
[2.0.1]: https://github.com/joseluisq/gimage/compare/v2.0.0...v2.0.1
[2.0.0]: https://github.com/joseluisq/gimage/compare/v1.5.2...v2.0.0
[1.5.2]: https://github.com/joseluisq/gimage/compare/v1.5.1...v1.5.2
[1.5.1]: https://github.com/joseluisq/gimage/compare/v1.5.0...v1.5.1
[1.5.0]: https://github.com/joseluisq/gimage/tree/1.5.0
