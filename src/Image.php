<?php

namespace GImage;

use GImage\Utils;

/**
 * A simple extended GD class for easy image handling. This is the parent class for GFigure and GCanvas.
 * @package GImage
 * @access public
 * @version 2.0.0
 * @author José Luis Quintana <http://git.io/joseluisq>
 * @license https://github.com/joseluisq/gimage/blob/master/license.md
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
 * @property int $opacity
 * @property string $from Default 'local'
 * @property bool $preserve Default FALSE
 * @property string $mimetype Default 'image/jpeg'
 * @link Github https://github.com/joseluisq/gimage
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
    protected $opacity = 0;
    protected $from = 'local';
    protected $preserve = false;
    protected $mimetype = 'image/jpeg';

    /**
    * Loads an image from Image or Figure class.
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
    * @access public
    * @param Image $element Image or Figure class.
    * @return void
    */
    public function from($element = null)
    {
        if (!empty($element) && $element instanceof Image) {
            $this->name = $element->name;
            $this->filename = $element->filename;
            $this->width = $element->width;
            $this->height = $element->height;
            $this->x = $element->x;
            $this->y = $element->y;
            $this->boxWidth = $element->boxWidth;
            $this->boxHeight = $element->boxHeight;
            $this->boxX = $element->boxX;
            $this->boxY = $element->boxY;
            $this->type = $element->type;
            $this->extension = $element->extension;
            $this->resource = $element->resource;
            $this->quality = $element->quality;
            $this->opacity = $element->opacity;
            $this->from = $element->from;
            $this->preserve = $element->preserve;
            $this->mimetype = $element->mimetype;

            return $this;
        }
    }

    /**
    * Loads an image from local o external path.
    * @package GImage
    * @access public
    * @param string $filename Path or url of image.
    * @return bool
    */
    public function load($filename)
    {
        $image = null;

        if (!empty($filename)) {
            $this->filename = $filename;
            $this->name = basename($filename);

            if (filter_var($filename, FILTER_VALIDATE_URL)) {
                $image = file_get_contents($filename);

                if (!empty($image)) {
                    $this->from = 'external';
                    $this->resource = $image = imagecreatefromstring($image);
                    $this->type = Utils::getImageType($filename);
                    $this->extension = Utils::getExtension($filename);
                    $this->width = $this->boxWidth = imagesx($image);
                    $this->height = $this->boxHeight = imagesy($image);
                }
            } else {
                if (is_file($filename)) {
                    $this->from = 'local';
                    $this->type = $imageType = Utils::getImageType($filename);
                    $this->extension = Utils::getExtension($filename);

                    switch ($imageType) {
                        case IMAGETYPE_GIF:
                            $image = imagecreatefromgif($filename);
                        break;

                        case IMAGETYPE_PNG:
                            $image = imagecreatefrompng($filename);
                        break;

                        case IMAGETYPE_JPEG:
                        $image = imagecreatefromjpeg($filename);
                        break;
                    }

                    $this->resource = $image;
                    $this->width = $this->boxWidth = imagesx($image);
                    $this->height = $this->boxHeight = imagesy($image);
                }
            }
        }

        return $this;
    }

    /**
    * Gets resource of image.
    * @access public
    * @return resource
    */
    public function getResource()
    {
        return $this->resource;
    }

    /**
    * Gets filename path of image.
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
    * Gets extension (jpg, png or gif)
    * @access public
    * @return string
    */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
    * Gets quality.
    * @access public
    * @return int
    */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
    * Gets opacity.
    * @access public
    * @return int
    */
    public function getOpacity()
    {
        return $this->opacity;
    }

    /**
    * Gets height.
    * @access protected
    * @return int
    */
    public function getWidth()
    {
        return $this->width;
    }

    /**
    * Gets width.
    * @access public
    * @return int
    */
    public function getHeight()
    {
        return $this->height;
    }

    /**
    * Gets top position.
    * @access protected
    * @return int
    */
    public function getTop()
    {
        return $this->y;
    }

    /**
    * Gets left position.
    * @access public
    * @return int
    */
    public function getLeft()
    {
        return $this->x;
    }

    /**
    * Gets box left position.
    * @access public
    * @return int
    */
    public function getBoxLeft()
    {
        return $this->boxX;
    }

    /**
    * Gets box top position.
    * @access protected
    * @return int
    */
    public function getBoxTop()
    {
        return $this->boxY;
    }

    /**
    * Gets box width.
    * @access public
    * @return int
    */
    public function getBoxWidth()
    {
        return $this->boxWidth;
    }

    /**
    * Gets box height.
    * @access public
    * @return int
    */
    public function getBoxHeight()
    {
        return $this->boxHeight;
    }

    /**
    * Gets of from it was loaded the image 'local' or 'external' path.
    * @access public
    * @return string
    */
    public function getLoadedFrom()
    {
        return $this->from;
    }

    /**
    * Sets quality for image.
    * @param int $quality Quality value from 0 to 100
    * @access public
    * @return void
    */
    public function setQuality($quality)
    {
        $this->quality = $quality;
        return $this;
    }

    /**
    * Sets opacity.
    * @param int $opacity Opacity value from 0 to 127
    * @access public
    * @return void
    */
    public function setOpacity($opacity)
    {
        $this->opacity = $opacity > 127 ? 127 : $opacity;
        return $this;
    }

    /**
    * Sets image resource.
    * @param resource $resource resource.
    * @access public
    * @return void
    */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
    * Sets left position of image.
    * @param int $x left.
    * @access public
    * @return void
    */
    public function setLeft($x)
    {
        $this->x = $x;
        return $this;
    }

    /**
    * Sets top position of image.
    * @param int $y top.
    * @access public
    * @return void
    */
    public function setTop($y)
    {
        $this->y = $y;
        return $this;
    }

    /**
    * Sets width of box image.
    * @param int $width width.
    * @access public
    * @return void
    */
    public function setBoxWidth($width)
    {
        $this->boxWidth = $width;
        return $this;
    }

    /**
    * Sets height of box image.
    * @param int $height height.
    * @access public
    * @return void
    */
    public function setBoxHeight($height)
    {
        $this->boxHeight = $height;
        return $this;
    }

    /**
    * Sets left position of box image.
    * @param int $x Left position.
    * @access public
    * @return void
    */
    public function setBoxLeft($x)
    {
        $this->boxX = $x * (-1);
        return $this;
    }

    /**
    * Sets top position of box image.
    * @param int $y Top position.
    * @access public
    * @return void
    */
    public function setBoxTop($y)
    {
        $this->boxY = $y * (-1);
        return $this;
    }

    /**
    * Checks if image was loaded from local path.
    * @access public
    * @return bool
    */
    public function isLocal()
    {
        return ($this->from == 'local');
    }

    /**
    * Checks if image was loaded from external url.
    * @access public
    * @return bool
    */
    public function isExternal()
    {
        return ($this->from == 'external');
    }

    /**
    * Checks if image is a JPG.
    * @access public
    * @return bool
    */
    public function isJPG()
    {
        return ($this->extension == 'jpg');
    }

    /**
    * Checks if image is a PNG.
    * @access public
    * @return bool
    */
    public function isPNG()
    {
        return ($this->extension == 'png');
    }

    /**
    * Checks if image is a GIF.
    * @access public
    * @return bool
    */
    public function isGIF()
    {
        return ($this->extension == 'gif');
    }

    /**
    * Changes output format to JPG
    * @access public
    * @return void
    */
    public function toJPG()
    {
        $this->extension = 'jpg';
        $this->type = IMAGETYPE_JPEG;
        $this->mimetype = Utils::getMimetypeByImageType(IMAGETYPE_JPEG);

        return $this;
    }

    /**
    * Changes output format to PNG
    * @access public
    * @return void
    */
    public function toPNG()
    {
        $this->extension = 'png';
        $this->type = IMAGETYPE_PNG;
        $this->mimetype = Utils::getMimetypeByImageType(IMAGETYPE_PNG);

        return $this;
    }

    /**
    * Changes output format to GIT.
    * @access public
    * @return void
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
    * @access public
    * @param bool $preserve If it's true will preserve the resource image.
    * @return void
    */
    public function preserve($preserve = true)
    {
        $this->preserve = $preserve;

        return $this;
    }

    /**
    * Saves the image to specific path.
    * @access public
    * @param string $filename If it's null save function will save the image in load path for default.
    * @return bool True if it is saved successful and False if it is not saved.
    */
    public function save($filename = null)
    {
        return $this->render($filename);
    }

    /**
    * Outputs the image on browser.
    * @access public
    * @return bool
    */
    public function output()
    {
        return $this->render(null, true);
    }

    /**
    * Resize image proportionally basing on the height of the image.
    * @access public
    * @param int $height
    * @return void
    */
    public function resizeToHeight($height)
    {
        $width = $this->getPropWidth($height);
        $this->resize($width, $height);

        return $this;
    }

    /**
    * Resize image proportionally basing on the width of the image.
    * @access public
    * @param int $width
    * @return void
    */
    public function resizeToWidth($width)
    {
        $height = $this->getPropHeight($width);
        $this->resize($width, $height);

        return $this;
    }

    /**
    * Gets proportional width of image from height value.
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
    * @param int $scale
    * @return Image
    */
    public function scale($scale)
    {
        $width = $this->width * (int) $scale / 100;
        $height = $this->height * (int) $scale / 100;
        $this->resize($width, $height);

        return $this;
    }

    /**
    * Rotate an image with a given angle.
    * @access public
    * @param int $angle
    * @return Image
    */
    public function rotate($angle = 0)
    {
        $this->resource = imagerotate($this->resource, $angle, 0);

        return $this;
    }

    /**
    * Cuts an image proportionally and centered.
    * @access public
    * @param int $width Width crop.
    * @param int $height Height crop.
    * @return Image
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
    * @access public
    * @param int $width Width crop.
    * @param int $height Height crop.
    * @param int $x1 [Optional] x-coordinate of source point.
    * @param int $y1 [Optional] y-coordinate of source point.
    * @param int $dstX [Optional] x-coordinate of destination point.
    * @param int $dstY [Optional] y-coordinate of destination point.
    * @return Image
    */
    public function crop($width, $height, $x1 = 0, $y1 = 0, $dstX = 0, $dstY = 0)
    {
        $this->resize($width, $height, $x1, $y1, $dstX, $dstY, true);

        return $this;
    }

    /**
    * Resizes the image.
    * @access private
    * @param int $width Image's width.
    * @param int $height Image's height.
    * @param int $x1 [Optional] Left position
    * @param int $y1 [Optional] Top position
    * @param int $dstX [Optional] x-coordinate of destination point.
    * @param int $dstY [Optional] y-coordinate of destination point.
    * @param bool $isCrop [Optional] if it's true resize function will crop the image.
    * @return Image
    */
    private function resize($width, $height, $x1 = 0, $y1 = 0, $dstX = 0, $dstY = 0, $isCrop = false)
    {
        $image = $this->resource;

        if ($image) {
            $simage = imagecreatetruecolor($width, $height);

            if ($this->isPNG()) {
                imagealphablending($simage, false);
                imagesavealpha($simage, true);
            }

            imagecopyresampled($simage, $image, $dstX, $dstY, $x1, $y1, $width, $height, ($isCrop) ? $width : $this->width, ($isCrop) ? $height : $this->height);

            $this->resource = $simage;
            $this->width = $this->boxWidth = imagesx($this->resource);
            $this->height = $this->boxHeight = imagesy($this->resource);
        }

        return $this;
    }

    /**
    * Renders the image.
    * @access private
    * @param string $filename [Optional] Path to save image
    * @param bool $output [Optional] If it's true render function outputs image.
    * @return Image
    */
    private function render($filename = null, $output = false)
    {
        $image = $this->resource;

        if ($image) {
            if ($this->filename || $filename || $output) {
                $filename = $output ? null : ($this->isExternal() ? (empty($filename) ? $this->name : $filename) :
            (empty($filename) ? $this->filename : $filename));
                $quality = $this->quality;
                $preserve = $this->preserve;

                if ($output) {
                    header('Content-type: ' . $this->mimetype);
                    ob_start();
                }

                if ($this->isJPG()) {
                    imagejpeg($image, $filename, $quality);
                } else {
                    if ($this->isPNG()) {
                        if ($quality > 10) {
                            $quality = 0;
                        }

                        imagealphablending($image, false);
                        imagesavealpha($image, true);

                        imagepng($image, $filename, $quality);
                    } else {
                        imagegif($image, $filename);
                    }
                }

                if ($output) {
                    ob_end_flush();
                }

                if (!$preserve) {
                    $this->destroy();
                }
            }
        }

        return $this;
    }

    /**
    * Destroys resource.
    * @access public
    * @return Image
    */
    public function destroy()
    {
        if ($this->resource) {
            imagedestroy($this->resource);
        }

        $this->resource = null;

        return $this;
    }
}
