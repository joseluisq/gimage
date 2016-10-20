<?php

namespace GImage;

/**
 * Some util image functions.
 * @package GImage
 * @access public
 * @version 2.0.0
 * @author José Luis Quintana <https://git.io/joseluisq>
 * @license https://github.com/joseluisq/gimage/blob/master/license.md
 * @property array $mimetypes Mime types for images.
 * @property array $typesimages Images types IMAGETYPE_GIF, IMAGETYPE_PNG and IMAGETYPE_JPEG.
 * @link Github https://github.com/joseluisq/gimage
 */
class Utils
{
    private static $mimetypes = [
        IMAGETYPE_GIF => 'image/gif',
        IMAGETYPE_PNG => 'image/png',
        IMAGETYPE_JPEG => 'image/jpeg'
    ];
    private static $typesimages = [
        'gif' => IMAGETYPE_GIF,
        'png' => IMAGETYPE_PNG,
        'jpg' => IMAGETYPE_JPEG
    ];

    /**
    * Gets image mime types (jpg, png and gif)
    * @access public
    * @return array
    */
    public static function getMimetypes()
    {
        return self::$mimetypes;
    }

    /**
    * Gets image mimeType by filename.
    * @access public
    * @param string $filename Image path.
    * @return string
    */
    public static function getMimetype($filename)
    {
        return self::$_mimetypes[self::getImageType($filename)];
    }

    /**
    * Gets image mime type by image type (IMAGETYPE_GIF, IMAGETYPE_PNG or IMAGETYPE_JPEG).
    * @access public
    * @param string $imagetype IMAGETYPE_GIF, IMAGETYPE_PNG or IMAGETYPE_JPEG.
    * @return string
    */
    public static function getMimetypeByImageType($imagetype)
    {
        return self::$mimetypes[$imagetype];
    }

    /**
    * Gets image extension from filename.
    * @access public
    * @param string $filename Image path.
    * @return string Return jpg, png or gif extension.
    */
    public static function getExtension($filename)
    {
        return strtolower(preg_replace('/^(.+)\./', '', $filename));
    }

    /**
    * Gets image type from filename.
    * @access public
    * @param string $filename Image path.
    * @return bool
    */
    public static function getImageType($filename)
    {
        return self::$typesimages[self::getExtension($filename)];
    }

    /**
    * Checks if image path is a JPG.
    * @access public
    * @param string $filename Image path.
    * @return bool
    */
    public static function isJPG($filename)
    {
        return (self::getExtension($filename) == 'jpg');
    }

    /**
    * Checks if image path is a PNG.
    * @access public
    * @param string $filename Image path.
    * @return bool
    */
    public static function isPNG($filename)
    {
        return (self::getExtension($filename) == 'png');
    }

    /**
    * Checks if image path is a PNG.
    * @access public
    * @param string $filename Image path.
    * @return bool
    */
    public static function isGIF($filename)
    {
        return (self::getExtension($filename) == 'gif');
    }
}
