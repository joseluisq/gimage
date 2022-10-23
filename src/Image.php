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
 * A simple extended GD class for easy image handling.
 * This is the parent class for Figure and Canvas.
 *
 * @author Jose Quintana <http://git.io/joseluisq>
 *
 * @property string   $name
 * @property string   $filename
 * @property int      $width
 * @property int      $height
 * @property int      $x
 * @property int      $y
 * @property int      $boxWidth
 * @property int      $boxHeight
 * @property int      $boxX
 * @property int      $boxY
 * @property int      $type              IMAGETYPE_JPEG
 * @property string   $extension         Default 'jpg'
 * @property resource $resource|\GdImage
 * @property int      $quality
 * @property int      $opacity           From 0 to 1
 * @property string   $from              Default 'local'
 * @property bool     $preserve          Default FALSE
 * @property string   $mimetype          Default 'image/jpeg'
 */
class Image
{
    protected $name;
    protected $filename;
    protected $width     = 0;
    protected $height    = 0;
    protected $x         = 0;
    protected $y         = 0;
    protected $boxWidth  = 0;
    protected $boxHeight = 0;
    protected $boxX      = 0;
    protected $boxY      = 0;
    protected $type      = IMAGETYPE_JPEG;
    protected $extension = 'jpg';
    protected $resource;
    protected $quality  = 100;
    protected $opacity  = 1;
    protected $from     = 'local';
    protected $preserve = false;
    protected $mimetype = 'image/jpeg';

    /**
     * Loads an image from Image or Figure class.
     *
     * @param Image $element image or Figure class
     */
    public function __construct($element = null)
    {
        $this->from($element);
    }

    /**
     * Loads an image from Image or Figure class.
     *
     * @param Image $element image or Figure class
     *
     * @return \GImage\Image|static
     */
    public function from($element = null)
    {
        if (!empty($element) && $element instanceof Image) {
            foreach (get_object_vars($element) as $key => $value) {
                $this->$key = $value;
            }

            return $this;
        }
    }

    /**
     * Loads an image from a local path, external url or image string.
     *
     * @param string $src local path, external url or image string
     *
     * @return \GImage\Image|static
     */
    public function load($src)
    {
        if (empty($src)) {
            return $this;
        }

        // 1. resource or \GdImage
        if (is_resource($src) || $src instanceof \GdImage) {
            $this->loadImageFromResource($src);
        // 2. string image
        } elseif (is_string($src) && $this->isImageStringByString($src)) {
            $this->loadImageFromString($src);
        // 3. string url image path
        } elseif (filter_var($src, FILTER_VALIDATE_URL)) {
            $this->loadImageFromURL($src);
        // 4. string file path
        } elseif (is_file($src)) {
            $this->loadImageFromFile($src);
        }

        return $this;
    }

    /**
     * Load an image from URL.
     *
     * @param string $url Image URL
     *
     * @return void
     */
    private function loadImageFromURL($url)
    {
        $image = $this->fetchImageContentFromURL($url);

        if (empty($image)) {
            return;
        }

        if (Utils::isJPGResource($image)) {
            $this->filename  = $url;
            $this->extension = 'jpg';
            $this->type      = IMAGETYPE_JPEG;
        }

        if (Utils::isPNGResource($image)) {
            $this->filename  = $url;
            $this->extension = 'png';
            $this->type      = IMAGETYPE_PNG;
        }

        $this->from     = 'external';
        $this->resource = imagecreatefromstring($image);
        $this->width    = $this->boxWidth    = imagesx($this->resource);
        $this->height   = $this->boxHeight   = imagesy($this->resource);
    }

    /**
     * Fetch an image string content from URL.
     *
     * @param string $url image URL
     *
     * @return string String data
     */
    private function fetchImageContentFromURL($url)
    {
        $data = null;

        if ($stream = fopen($url, 'r')) {
            $data = stream_get_contents($stream);
            fclose($stream);
        }

        return $data;
    }

    /**
     * Load an image from a resource or `\GdImage`.
     *
     * @param string $resource image resource or `\GdImage`
     *
     * @return void
     */
    private function loadImageFromResource($resource)
    {
        $this->extension = 'png';
        $this->type      = IMAGETYPE_PNG;
        $this->from      = is_resource($resource) ? 'resource' : 'gdimage';
        $this->resource  = $resource;
        $this->width     = $this->boxWidth     = imagesx($this->resource);
        $this->height    = $this->boxHeight    = imagesy($this->resource);
    }

    /**
     * Load an image from image string.
     *
     * @param string $imagestring Image string
     *
     * @return void
     */
    private function loadImageFromString($imagestring)
    {
        if (Utils::isJPGResource($imagestring)) {
            $this->extension = 'jpg';
            $this->type      = IMAGETYPE_JPEG;
        }

        if (Utils::isPNGResource($imagestring)) {
            $this->extension = 'png';
            $this->type      = IMAGETYPE_PNG;
        }

        $this->from     = 'imagestring';
        $this->resource = imagecreatefromstring($imagestring);
        $this->width    = $this->boxWidth    = imagesx($this->resource);
        $this->height   = $this->boxHeight   = imagesy($this->resource);
    }

    /**
     * Checks if string is Image string.
     *
     * @param string $imagestring image string
     *
     * @return bool
     */
    private function isImageStringByString($imagestring)
    {
        return Utils::isJPGResource($imagestring) || Utils::isPNGResource($imagestring);
    }

    /**
     * Load an image file from path.
     *
     * @param string $filepath File path
     *
     * @return void
     */
    private function loadImageFromFile($filepath)
    {
        $this->from     = 'local';
        $this->filename = $filepath;

        if (!is_readable($filepath)) {
            return;
        }

        $image                            = null;
        $extension                        = '';
        list($width, $height, $imageType) = getimagesize($filepath);

        switch ($imageType) {
            case IMAGETYPE_GIF:
                $extension = 'gif';
                $image     = imagecreatefromgif($filepath);
                break;

            case IMAGETYPE_PNG:
                $extension = 'png';
                $image     = imagecreatefrompng($filepath);
                break;

            case IMAGETYPE_JPEG:
                $extension = 'jpg';
                $image     = imagecreatefromjpeg($filepath);
                break;
        }

        if ($image) {
            $this->type      = $imageType;
            $this->resource  = $image;
            $this->extension = $extension;
            $this->width     = $this->boxWidth     = $width;
            $this->height    = $this->boxHeight    = $height;
        }
    }

    /**
     * Gets the resource or `\GdImage` object (PHP 8.0+) of the image.
     *
     * @return resource|\GdImage
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Gets filename path of the image.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Gets the image file name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the image type code (IMAGETYPE_JPEG, IMAGETYPE_PNG or IMAGETYPE_GIF).
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets extension (jpg, png or gif).
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Gets quality.
     *
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * Gets opacity.
     *
     * @return int
     */
    public function getOpacity()
    {
        return $this->opacity;
    }

    /**
     * Gets width.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Gets height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Gets top position.
     *
     * @return int
     */
    public function getTop()
    {
        return $this->y;
    }

    /**
     * Gets left position.
     *
     * @return int
     */
    public function getLeft()
    {
        return $this->x;
    }

    /**
     * Gets box left position.
     *
     * @return int
     */
    public function getBoxLeft()
    {
        return $this->boxX;
    }

    /**
     * Gets box top position.
     *
     * @return int
     */
    public function getBoxTop()
    {
        return $this->boxY;
    }

    /**
     * Gets box width.
     *
     * @return int
     */
    public function getBoxWidth()
    {
        return $this->boxWidth;
    }

    /**
     * Gets box height.
     *
     * @return int
     */
    public function getBoxHeight()
    {
        return $this->boxHeight;
    }

    /**
     * Gets where the image was loaded: 'local' or 'external'.
     *
     * @return string
     */
    public function getLoadedFrom()
    {
        return $this->from;
    }

    /**
     * Sets quality for image.
     *
     * @param int $quality Quality value from 0 to 100
     *
     * @return \GImage\Image|static
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Sets opacity.
     *
     * @param int $opacity Opacity value from 0 to 127
     *
     * @return \GImage\Image|static
     */
    public function setOpacity($opacity)
    {
        $this->opacity = $opacity > 127 ? 127 : $opacity;

        return $this;
    }

    /**
     * Sets image resource.
     *
     * @param resource $resource resource
     *
     * @return \GImage\Image|static
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Sets left position of image.
     *
     * @param int $x left
     *
     * @return \GImage\Image|static
     */
    public function setLeft($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Sets top position of image.
     *
     * @param int $y top
     *
     * @return \GImage\Image|static
     */
    public function setTop($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Sets width of box image.
     *
     * @param int $width width
     *
     * @return \GImage\Image|static
     */
    public function setBoxWidth($width)
    {
        $this->boxWidth = $width;

        return $this;
    }

    /**
     * Sets height of box image.
     *
     * @param int $height height
     *
     * @return \GImage\Image|static
     */
    public function setBoxHeight($height)
    {
        $this->boxHeight = $height;

        return $this;
    }

    /**
     * Sets left position of box image.
     *
     * @param int $x left position
     *
     * @return \GImage\Image|static
     */
    public function setBoxLeft($x)
    {
        $this->boxX = $x * (-1);

        return $this;
    }

    /**
     * Sets top position of box image.
     *
     * @param int $y top position
     *
     * @return \GImage\Image|static
     */
    public function setBoxTop($y)
    {
        $this->boxY = $y * (-1);

        return $this;
    }

    /**
     * Checks if image was loaded from local path.
     *
     * @return bool
     */
    public function isLocal()
    {
        return $this->from == 'local';
    }

    /**
     * Checks if image was loaded from external url.
     *
     * @return bool
     */
    public function isExternal()
    {
        return $this->from == 'external';
    }

    /**
     * Checks if image was loaded from image string.
     *
     * @return bool
     */
    public function isImageString()
    {
        return $this->from == 'imagestring';
    }

    /**
     * Checks if image was loaded from an image resource (PHP 7.4).
     *
     * @return bool
     */
    public function isImageResource()
    {
        return $this->from == 'resource';
    }

    /**
     * Checks if image was loaded from a `\GdImage` object (PHP 8.0+).
     *
     * @return bool
     */
    public function isImageGdImage()
    {
        return $this->from == 'gdimage';
    }

    /**
     * Checks if image is a JPG.
     *
     * @return bool
     */
    public function isJPG()
    {
        return $this->extension == 'jpg';
    }

    /**
     * Checks if image is a PNG.
     *
     * @return bool
     */
    public function isPNG()
    {
        return $this->extension == 'png';
    }

    /**
     * Checks if image is a GIF.
     *
     * @return bool
     */
    public function isGIF()
    {
        return $this->extension == 'gif';
    }

    /**
     * Changes output format to JPG.
     *
     * @return \GImage\Image|static
     */
    public function toJPG()
    {
        $this->extension = 'jpg';
        $this->type      = IMAGETYPE_JPEG;
        $this->mimetype  = Utils::getMimetypeByImageType(IMAGETYPE_JPEG);

        return $this;
    }

    /**
     * Changes output format to PNG.
     *
     * @return \GImage\Image|static
     */
    public function toPNG()
    {
        $this->extension = 'png';
        $this->type      = IMAGETYPE_PNG;
        $this->mimetype  = Utils::getMimetypeByImageType(IMAGETYPE_PNG);

        return $this;
    }

    /**
     * Changes output format to GIF.
     *
     * @return \GImage\Image|static
     */
    public function toGIF()
    {
        $this->extension = 'gif';
        $this->type      = IMAGETYPE_GIF;
        $this->mimetype  = Utils::getMimetypeByImageType(IMAGETYPE_GIF);

        return $this;
    }

    /**
     * Preserves the resource image when save or output function is called.
     *
     * @param bool $preserve if it's true will preserve the resource image
     *
     * @return \GImage\Image|static
     */
    public function preserve($preserve = true)
    {
        $this->preserve = $preserve;

        return $this;
    }

    /**
     * Resize image proportionally basing on the height of the image.
     *
     * @param int $height
     *
     * @return \GImage\Image|static
     */
    public function resizeToHeight($height)
    {
        $width = $this->getPropWidth($height);
        $this->resize($width, $height);

        return $this;
    }

    /**
     * Resize image proportionally basing on the width of the image.
     *
     * @param int $width
     *
     * @return \GImage\Image|static
     */
    public function resizeToWidth($width)
    {
        $height = $this->getPropHeight($width);
        $this->resize($width, $height);

        return $this;
    }

    /**
     * Gets proportional width of image from height value.
     *
     * @param int $height
     *
     * @return int
     */
    public function getPropWidth($height)
    {
        $ratio = $height / $this->height;

        return (int) floor($this->width * $ratio);
    }

    /**
     * Gets proportional height of image from width value.
     *
     * @param int $width
     *
     * @return int
     */
    public function getPropHeight($width)
    {
        $ratio = $width / $this->width;

        return (int) floor($this->height * $ratio);
    }

    /**
     * Scales the image.
     *
     * @param int|float $scale
     *
     * @return \GImage\Image|static
     */
    public function scale($scale = 1)
    {
        $scale = $scale > 1 ? 1 : $scale;
        $scale = $scale < 0 ? 0 : $scale;

        $width  = (int) floor($this->width * $scale);
        $height = (int) floor($this->height * $scale);

        $this->resize($width, $height);

        return $this;
    }

    /**
     * Rotate the image with a given angle.
     *
     * @param int $angle
     *
     * @return \GImage\Image|static
     */
    public function rotate($angle = 0)
    {
        if ($this->resource) {
            $this->resource = imagerotate($this->resource, $angle, 0);
        }

        return $this;
    }

    /**
     * Cuts the image proportionally and centered.
     *
     * @param int $width  width crop
     * @param int $height height crop
     *
     * @return \GImage\Image|static
     */
    public function centerCrop($width, $height)
    {
        $pwidth  = $this->getPropWidth($height);
        $pheight = $this->getPropHeight($width);

        if ($pwidth == $width && $pheight == $height) {
            $this->resizeToWidth($width);
        } else {
            if ($pheight > $height) {
                $this->resizeToWidth($width);
            } else {
                $pheight += $height - $pheight;
                $this->resizeToHeight($pheight);
            }

            $x = (int) floor(($this->width - $width) / 2);
            $y = (int) floor(($this->height - $height) / 2);
            $this->crop($width, $height, $x, $y);
        }

        return $this;
    }

    /**
     * Cuts part of image.
     *
     * @param int $width  width crop
     * @param int $height height crop
     * @param int $x1     [Optional] x-coordinate of source point
     * @param int $y1     [Optional] y-coordinate of source point
     * @param int $dstX   [Optional] x-coordinate of destination point
     * @param int $dstY   [Optional] y-coordinate of destination point
     *
     * @return \GImage\Image|static
     */
    public function crop($width, $height, $x1 = 0, $y1 = 0, $dstX = 0, $dstY = 0)
    {
        $this->resize($width, $height, $x1, $y1, $dstX, $dstY, true);

        return $this;
    }

    /**
     * Resizes the image.
     *
     * @param int  $width  image's width
     * @param int  $height image's height
     * @param int  $x1     [Optional] Left position
     * @param int  $y1     [Optional] Top position
     * @param int  $dstX   [Optional] x-coordinate of destination point
     * @param int  $dstY   [Optional] y-coordinate of destination point
     * @param bool $isCrop [Optional] if it's true resize function will crop the image
     *
     * @return \GImage\Image|static
     */
    private function resize($width, $height, $x1 = 0, $y1 = 0, $dstX = 0, $dstY = 0, $isCrop = false)
    {
        if ($this->resource && $width > 0 && $height > 0) {
            $image = imagecreatetruecolor($width, $height);

            if ($this->isPNG()) {
                imagealphablending($image, false);
                imagesavealpha($image, true);
            }

            imagecopyresampled(
                $image,
                $this->resource,
                $dstX,
                $dstY,
                $x1,
                $y1,
                $width,
                $height,
                $isCrop ? $width : $this->width,
                $isCrop ? $height : $this->height
            );

            $this->resource = $image;
            $this->width    = $this->boxWidth    = imagesx($this->resource);
            $this->height   = $this->boxHeight   = imagesy($this->resource);
        }

        return $this;
    }

    /**
     * Saves the image to specific path.
     *
     * @param string $filename if it's null save function will save the image
     *                         in load path for default
     *
     * @return \GImage\Image|static
     */
    public function save($filename = null)
    {
        return $this->outputBuffer($filename);
    }

    /**
     * Outputs the image on browser.
     *
     * @return \GImage\Image|static
     */
    public function output()
    {
        return $this->outputBuffer(null, true);
    }

    /**
     * Render the image in-memory and return the resource.
     *
     * @return resource | null  Return the resource or null
     */
    public function render()
    {
        $image = null;

        if ($this->resource) {
            ob_start();
            $this->outputBufferByImage(null, $this->quality);
            $string = ob_get_contents();
            ob_end_clean();

            if (!empty($string)) {
                $image = imagecreatefromstring($string);
            }
        }

        return $image;
    }

    /**
     * Output the image to either the browser or a file.
     *
     * @param string $filename [Optional] Path to save image
     * @param bool   $output   [Optional] true to output the image
     *
     * @return \GImage\Image|static | resource
     */
    private function outputBuffer($filename = null, $output = false)
    {
        if (!$this->resource) {
            return $this;
        }

        if ($output) {
            $filename = null;
        } elseif (empty($filename) && $this->isLocal()) {
            $filename = $this->filename;
        } elseif (empty($filename) && $this->isExternal()) {
            $filename = $this->name;
        }

        if ($output) {
            header('Content-type: ' . $this->mimetype);
            ob_start();
        }

        $this->outputBufferByImage($filename, $this->quality);

        if ($output) {
            ob_end_flush();
        }

        if (!$this->preserve) {
            $this->destroy();
        }

        return $this;
    }

    private function outputBufferByImage($filename, $quality)
    {
        if ($this->isJPG()) {
            imagejpeg($this->resource, $filename, $quality);
        }

        if ($this->isPNG()) {
            if ($quality > 10) {
                $quality = 0;
            }

            imagesavealpha($this->resource, true);

            if (!is_subclass_of($this, Image::class)) {
                $this->addOpacityFilter();
            }

            imagepng($this->resource, $filename, $quality);
        }

        if ($this->isGIF()) {
            imagegif($this->resource, $filename);
        }
    }

    /**
     * Destroys the current resource.
     *
     * @return \GImage\Image|static
     */
    public function destroy()
    {
        if ($this->resource) {
            imagedestroy($this->resource);
        }

        $this->resource = null;

        return $this;
    }

    /**
     * Add opacity filter to the current resource.
     *
     * @return void
     */
    protected function addOpacityFilter()
    {
        $opacity = Utils::fixPNGOpacity($this->opacity);

        if ($opacity >= 0 && $opacity < 127) {
            imagealphablending($this->resource, false);
            imagefilter($this->resource, IMG_FILTER_COLORIZE, 0, 0, 0, $opacity);
        }
    }
}
