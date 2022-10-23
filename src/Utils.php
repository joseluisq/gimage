<?php
/*
 * This file is part of GImage.
 *
 * (c) Jose Quintana <https://joseluisq.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GImage;

/**
 * Image utility functions.
 *
 * @author Jose Quintana <https://joseluisq.net>
 *
 * @property array $mimeTypes  Mime types for images.
 * @property array $imageTypes Types: IMAGETYPE_GIF, IMAGETYPE_PNG and IMAGETYPE_JPEG.
 */
class Utils
{
    private static $mimeTypes = [
        IMAGETYPE_GIF  => 'image/gif',
        IMAGETYPE_PNG  => 'image/png',
        IMAGETYPE_JPEG => 'image/jpeg',
    ];
    private static $imageTypes = [
        'gif' => IMAGETYPE_GIF,
        'png' => IMAGETYPE_PNG,
        'jpg' => IMAGETYPE_JPEG,
    ];

    /**
     * Gets image mime types (jpg, png and gif).
     *
     * @return array
     */
    public static function getMimetypes()
    {
        return self::$mimeTypes;
    }

    /**
     * Gets image mimeType by filename.
     *
     * @param string $filename image path
     *
     * @return string
     */
    public static function getMimetype($filename)
    {
        return self::$mimeTypes[self::getImageType($filename)];
    }

    /**
     * Gets image mime type by image type (IMAGETYPE_GIF, IMAGETYPE_PNG or IMAGETYPE_JPEG).
     *
     * @param string $imagetype IMAGETYPE_GIF, IMAGETYPE_PNG or IMAGETYPE_JPEG
     *
     * @return string
     */
    public static function getMimetypeByImageType($imagetype)
    {
        return self::$mimeTypes[$imagetype];
    }

    /**
     * Gets image extension from filename.
     *
     * @param string $filename image path
     *
     * @return string return jpg, png or gif extension
     */
    public static function getExtension($filename)
    {
        return strtolower(preg_replace('/^(.+)\./', '', $filename));
    }

    /**
     * Gets image type from filename.
     *
     * @param string $filename image path
     *
     * @return bool
     */
    public static function getImageType($filename)
    {
        return self::$imageTypes[self::getExtension($filename)];
    }

    /**
     * Checks if image path is a JPG.
     *
     * @param string $filename image path
     *
     * @return bool
     */
    public static function isJPG($filename)
    {
        return self::getExtension($filename) == 'jpg';
    }

    /**
     * Checks if image path is a PNG.
     *
     * @param string $filename image path
     *
     * @return bool
     */
    public static function isPNG($filename)
    {
        return self::getExtension($filename) == 'png';
    }

    /**
     * Checks if image path is a PNG.
     *
     * @param string $filename image path
     *
     * @return bool
     */
    public static function isGIF($filename)
    {
        return self::getExtension($filename) == 'gif';
    }

    /**
     * Checks if image resource is a JPG.
     *
     * @param string $resource image resource
     *
     * @return bool
     */
    public static function isJPGResource($resource)
    {
        return $resource && (bin2hex($resource[0]) == 'ff'
            && bin2hex($resource[1]) == 'd8');
    }

    /**
     * Checks if image resource is a PNG.
     *
     * @param string $resource image resource
     *
     * @return bool
     */
    public static function isPNGResource($resource)
    {
        return $resource && (bin2hex($resource[0]) == '89' && $resource[1] == 'P'
            && $resource[2] == 'N' && $resource[3] == 'G');
    }

    /**
     * Fix the opacity value (0 to 1) for PNG alpha value.
     *
     * @param int|float $opacity
     *
     * @return int
     */
    public static function fixPNGOpacity($opacity = 1)
    {
        $opacity = $opacity > 1 ? 1 : $opacity;
        $opacity = $opacity < 0 ? 0 : $opacity;
        $opacity = (int) round(127 * $opacity, 0, PHP_ROUND_HALF_UP);
        $opacity = 127 - $opacity;

        return $opacity;
    }
}
