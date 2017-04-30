<?php
/*
 * This file is part of GImage.
 *
 * (c) Jose Luis Quintana <https://git.io/joseluisq>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GImage;

/**
 * A simple extended GD class for easy image handling.
 * This is the parent class for Figure and Canvas.
 *
 * @package GImage
 * @author José Luis Quintana <http://git.io/joseluisq>
 *
 * @property string $name
 * @property string $filename
 * @property int $width
 * @property int $height
 * @property int $x
 * @property int $y
 * @property int $boxWidth
 * @property int $boxHeight
 * @property int $boxX
 * @property int $boxY
 * @property int $type IMAGETYPE_JPEG
 * @property string $extension Default 'jpg'
 * @property resource $resource
 * @property int $quality
 * @property int $opacity From 0 to 1
 * @property string $from Default 'local'
 * @property bool $preserve Default FALSE
 * @property string $mimetype Default 'image/jpeg'
 */
class Image
{
    protected $name;
    protected $filename;
    protected $width = 0;
    protected $height = 0;
    protected $x = 0;
    protected $y = 0;
    protected $boxWidth = 0;
    protected $boxHeight = 0;
    protected $boxX = 0;
    protected $boxY = 0;
    protected $type = IMAGETYPE_JPEG;
    protected $extension = 'jpg';
    protected $resource;
    protected $quality = 100;
    protected $opacity = 1;
    protected $from = 'local';
    protected $preserve = false;
    protected $mimetype = 'image/jpeg';

    /**
    * Loads an image from Image or Figure class.
    *
    * @package GImage
    * @access public
    * @param Image $element Image or Figure class.
    * @return void
    */
    public function __construct($element = null)
    {
        $this->from($element);
    }

    /**
    * Loads an image from Image or Figure class.
    *
    * @access public
    * @param Image $element Image or Figure class.
    * @return \GImage\Image
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
    * Loads an image from local o external path.
    *
    * @package GImage
    * @access public
    * @param string $filename Path or url of image.
    * @return \GImage\Image
    */
    public function load($filename)
    {
        $image = null;

        if (empty($filename)) {
            return $this;
        }

        if (filter_var($filename, FILTER_VALIDATE_URL)) {
            $this->loadFromURL($filename);
        } elseif (is_file($filename)) {
            $this->loadFromFile($filename);
        }

        return $this;
    }

    /**
     * Load an Image from URL.
     *
     * @param  string $url Image URL
     * @return void
     */
    private function loadFromURL($url)
    {
        $image = $this->fetchImageContentFromURL($url);

        if (empty($image)) {
            return;
        }

        if (Utils::isJPGResource($image)) {
            $this->filename = $url;
            $this->extension = 'jpg';
            $this->type = IMAGETYPE_JPEG;
        }

        if (Utils::isPNGResource($image)) {
            $this->filename = $url;
            $this->extension = 'png';
            $this->type = IMAGETYPE_PNG;
        }

        if (!empty($this->filename)) {
            $this->from = 'external';
            $this->resource = imagecreatefromstring($image);
            $this->width = $this->boxWidth = imagesx($this->resource);
            $this->height = $this->boxHeight = imagesy($this->resource);
        }
    }

    /**
     * Fetch an image string content from URL.
     *
     * @param  string $url Image URL.
     * @return String      String Data
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
     * Load an image file from path.
     *
     * @param  string $filepath File path
     * @return void
     */
    private function loadFromFile($filepath)
    {
        $this->from = 'local';
        $this->filename = $filepath;


        if (!is_readable($filepath)) {
            return;
        }

        $image = null;
        $extension = '';
        list($width, $height, $imageType) = getimagesize($filepath);

        switch ($imageType) {
            case IMAGETYPE_GIF:
                $extension = 'gif';
                $image = imagecreatefromgif($filepath);
                break;

            case IMAGETYPE_PNG:
                $extension = 'png';
                $image = imagecreatefrompng($filepath);
                break;

            case IMAGETYPE_JPEG:
                $extension = 'jpg';
                $image = imagecreatefromjpeg($filepath);
                break;
        }

        if ($image) {
            $this->type = $info[2];
            $this->resource = $image;
            $this->extension = $extension;
            $this->width = $this->boxWidth = $width;
            $this->height = $this->boxHeight = $height;
        }
    }

    /**
    * Gets resource of image.
    *
    * @access public
    * @return resource
    */
    public function getResource()
    {
        return $this->resource;
    }

    /**
    * Gets filename path of image.
    *
    * @access public
    * @return string
    */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
    * Gets name of image file.
    * @access public
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    * Gets image type code. (IMAGETYPE_JPEG, IMAGETYPE_PNG or IMAGETYPE_GIF)
    * @access public
    * @return int
    */
    public function getType()
    {
        return $this->type;
    }

    /**
    * Gets extension (jpg, png or gif).
    *
    * @access public
    * @return string
    */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
    * Gets quality.
    *
    * @access public
    * @return int
    */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
    * Gets opacity.
    *
    * @access public
    * @return int
    */
    public function getOpacity()
    {
        return $this->opacity;
    }

    /**
    * Gets height.
    *
    * @access protected
    * @return int
    */
    public function getWidth()
    {
        return $this->width;
    }

    /**
    * Gets width.
    *
    * @access public
    * @return int
    */
    public function getHeight()
    {
        return $this->height;
    }

    /**
    * Gets top position.
    *
    * @access protected
    * @return int
    */
    public function getTop()
    {
        return $this->y;
    }

    /**
    * Gets left position.
    *
    * @access public
    * @return int
    */
    public function getLeft()
    {
        return $this->x;
    }

    /**
    * Gets box left position.
    *
    * @access public
    * @return int
    */
    public function getBoxLeft()
    {
        return $this->boxX;
    }

    /**
    * Gets box top position.
    *
    * @access protected
    * @return int
    */
    public function getBoxTop()
    {
        return $this->boxY;
    }

    /**
    * Gets box width.
    *
    * @access public
    * @return int
    */
    public function getBoxWidth()
    {
        return $this->boxWidth;
    }

    /**
    * Gets box height.
    *
    * @access public
    * @return int
    */
    public function getBoxHeight()
    {
        return $this->boxHeight;
    }

    /**
    * Gets of from it was loaded the image 'local' or 'external' path.
    *
    * @access public
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
    * @access public
    * @return \GImage\Image
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
    * @access public
    * @return \GImage\Image
    */
    public function setOpacity($opacity)
    {
        $this->opacity = $opacity > 127 ? 127 : $opacity;
        return $this;
    }

    /**
    * Sets image resource.
    *
    * @param resource $resource resource.
    * @access public
    * @return \GImage\Image
    */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
    * Sets left position of image.
    *
    * @param int $x left.
    * @access public
    * @return \GImage\Image
    */
    public function setLeft($x)
    {
        $this->x = $x;
        return $this;
    }

    /**
    * Sets top position of image.
    *
    * @param int $y top.
    * @access public
    * @return \GImage\Image
    */
    public function setTop($y)
    {
        $this->y = $y;
        return $this;
    }

    /**
    * Sets width of box image.
    *
    * @param int $width width.
    * @access public
    * @return \GImage\Image
    */
    public function setBoxWidth($width)
    {
        $this->boxWidth = $width;
        return $this;
    }

    /**
    * Sets height of box image.
    *
    * @param int $height height.
    * @access public
    * @return \GImage\Image
    */
    public function setBoxHeight($height)
    {
        $this->boxHeight = $height;
        return $this;
    }

    /**
    * Sets left position of box image.
    *
    * @param int $x Left position.
    * @access public
    * @return \GImage\Image
    */
    public function setBoxLeft($x)
    {
        $this->boxX = $x * (-1);
        return $this;
    }

    /**
    * Sets top position of box image.
    *
    * @param int $y Top position.
    * @access public
    * @return \GImage\Image
    */
    public function setBoxTop($y)
    {
        $this->boxY = $y * (-1);
        return $this;
    }

    /**
    * Checks if image was loaded from local path.
    *
    * @access public
    * @return bool
    */
    public function isLocal()
    {
        return ($this->from == 'local');
    }

    /**
    * Checks if image was loaded from external url.
    *
    * @access public
    * @return bool
    */
    public function isExternal()
    {
        return ($this->from == 'external');
    }

    /**
    * Checks if image is a JPG.
    *
    * @access public
    * @return bool
    */
    public function isJPG()
    {
        return ($this->extension == 'jpg');
    }

    /**
    * Checks if image is a PNG.
    *
    * @access public
    * @return bool
    */
    public function isPNG()
    {
        return ($this->extension == 'png');
    }

    /**
    * Checks if image is a GIF.
    *
    * @access public
    * @return bool
    */
    public function isGIF()
    {
        return ($this->extension == 'gif');
    }

    /**
    * Changes output format to JPG.
    *
    * @access public
    * @return \GImage\Image
    */
    public function toJPG()
    {
        $this->extension = 'jpg';
        $this->type = IMAGETYPE_JPEG;
        $this->mimetype = Utils::getMimetypeByImageType(IMAGETYPE_JPEG);
        return $this;
    }

    /**
    * Changes output format to PNG.
    *
    * @access public
    * @return \GvoidvoidvoidImage\Imagevoidvoidvoid
    */
    public function toPNG()
    {
        $this->extension = 'png';
        $this->type = IMAGETYPE_PNG;
        $this->mimetype = Utils::getMimetypeByImageType(IMAGETYPE_PNG);
        return $this;
    }

    /**
    * Changes output format to GIF.
    *
    * @access public
    * @return \GImage\Image
    */
    public function toGIF()
    {
        $this->extension = 'gif';
        $this->type = IMAGETYPE_GIF;
        $this->mimetype = Utils::getMimetypeByImageType(IMAGETYPE_GIF);
        return $this;
    }

    /**
    * Preserves the resource image when save or output function is called.
    *
    * @access public
    * @param bool $preserve If it's true will preserve the resource image.
    * @return \GImage\Image
    */
    public function preserve($preserve = true)
    {
        $this->preserve = $preserve;
        return $this;
    }

    /**
    * Saves the image to specific path.
    *
    * @access public
    * @param string $filename If it's null save function will save the image
    * in load path for default.
    * @return bool True if it is saved successful and False if it is not saved.
    */
    public function save($filename = null)
    {
        return $this->render($filename);
    }

    /**
    * Outputs the image on browser.
    *
    * @access public
    * @return bool
    */
    public function output()
    {
        return $this->render(null, true);
    }

    /**
    * Resize image proportionally basing on the height of the image.
    *
    * @access public
    * @param int $height
    * @return \GImage\Image
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
    * @access public
    * @param int $width
    * @return \GImage\Image
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
    * @access public
    * @param int $height
    * @return int
    */
    public function getPropWidth($height)
    {
        $ratio = (int) $height / $this->height;
        return $this->width * $ratio;
    }

    /**
    * Gets proportional height of image from width value.
    *
    * @access public
    * @param int $width
    * @return int
    */
    public function getPropHeight($width)
    {
        $ratio = (int) $width / $this->width;

        return $this->height * $ratio;
    }

    /**
    * Scales the image.
    * @access public
    * @param int|double $scale
    * @return \GImage\Image
    */
    public function scale($scale = 1)
    {
        if ($scale > 1) {
            $scale = 1;
        }

        $width = (int) $this->width * $scale;
        $height = (int) $this->height * $scale;

        $this->resize($width, $height);
        return $this;
    }

    /**
    * Rotate an image with a given angle.
    *
    * @access public
    * @param int $angle
    * @return \GImage\Image
    */
    public function rotate($angle = 0)
    {
        if ($this->resource) {
            $this->resource = imagerotate($this->resource, $angle, 0);
        }

        return $this;
    }

    /**
    * Cuts an image proportionally and centered.
    *
    * @access public
    * @param int $width Width crop.
    * @param int $height Height crop.
    * @return \GImage\Image
    */
    public function centerCrop($width, $height)
    {
        $pwidth = $this->getPropWidth($height);
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

            $x = ($this->width - $width) / 2;
            $y = ($this->height - $height) / 2;
            $this->crop($width, $height, $x, $y);
        }

        return $this;
    }

    /**
    * Cuts part of image.
    *
    * @access public
    * @param int $width Width crop.
    * @param int $height Height crop.
    * @param int $x1 [Optional] x-coordinate of source point.
    * @param int $y1 [Optional] y-coordinate of source point.
    * @param int $dstX [Optional] x-coordinate of destination point.
    * @param int $dstY [Optional] y-coordinate of destination point.
    * @return \GImage\Image
    */
    public function crop($width, $height, $x1 = 0, $y1 = 0, $dstX = 0, $dstY = 0)
    {
        $this->resize($width, $height, $x1, $y1, $dstX, $dstY, true);

        return $this;
    }

    /**
    * Resizes the image.
    *
    * @access private
    * @param int $width Image's width.
    * @param int $height Image's height.
    * @param int $x1 [Optional] Left position
    * @param int $y1 [Optional] Top position
    * @param int $dstX [Optional] x-coordinate of destination point.
    * @param int $dstY [Optional] y-coordinate of destination point.
    * @param bool $isCrop [Optional] if it's true resize function will crop the image.
    * @return \GImage\Image
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
            $this->width = $this->boxWidth = imagesx($this->resource);
            $this->height = $this->boxHeight = imagesy($this->resource);
        }

        return $this;
    }

    /**
    * Renders the image.
    *
    * @access private
    * @param string $filename [Optional] Path to save image
    * @param bool $output [Optional] If it's true render function outputs image.
    * @return \GImage\Image
    */
    private function render($filename = null, $output = false)
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

        $quality = $this->quality;

        if ($output) {
            header('Content-type: ' . $this->mimetype);
            ob_start();
        }

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

        if ($output) {
            ob_end_flush();
        }

        if (!$this->preserve) {
            $this->destroy();
        }

        return $this;
    }

    /**
    * Destroys the current resource.
    *
    * @access public
    * @return \GImage\Image
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
     * @access protected
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
