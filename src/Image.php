<?php

use GImage\Utils;

namespace GImage;

/**
 * A simple extended GD class for easy image handling. This is the parent class for GFigure and GCanvas.
 * @package GImage
 * @access public
 * @version 2.0.0
 * @author José Luis Quintana <http://git.io/joseluisq>
 * @license https://github.com/joseluisq/gimage/blob/master/license.md
 * @property string $name
 * @property string $filename
 * @property int $_width
 * @property int $_height
 * @property int $_x
 * @property int $_y
 * @property int $_box_width
 * @property int $_box_height
 * @property int $_box_x
 * @property int $_box_y
 * @property int $_type IMAGETYPE_JPEG
 * @property string $_extension Default 'jpg'
 * @property resource $_resource
 * @property int $_quality
 * @property int $_opacity
 * @property string $_from Default 'local'
 * @property bool $_preserve Default FALSE
 * @property string $_mimetype Default 'image/jpeg'
 * @link Github https://github.com/joseluisq/gimage
 */
class Image {

  protected $name;
  protected $filename;
  protected $_width = 0;
  protected $_height = 0;
  protected $_x = 0;
  protected $_y = 0;
  protected $_box_width = 0;
  protected $_box_height = 0;
  protected $_box_x = 0;
  protected $_box_y = 0;
  protected $_type = IMAGETYPE_JPEG;
  protected $_extension = 'jpg';
  protected $_resource;
  protected $_quality = 100;
  protected $_opacity = 0;
  protected $_from = 'local';
  protected $_preserve = FALSE;
  protected $_mimetype = 'image/jpeg';

  /**
   * Loads an image from Image or Figure class.
   * @package GImage
   * @access public
   * @param Image $element Image or Figure class.
   * @return void
   */
  function __construct($element = NULL) {
    $this->from($element);
  }

  /**
   * Loads an image from Image or Figure class.
   * @access public
   * @param Image $element Image or Figure class.
   * @return void
   */
  public function from($element = NULL) {
    if (!empty($element) && $element instanceof Image) {
      $this->name = $element->name;
      $this->filename = $element->filename;
      $this->_width = $element->_width;
      $this->_height = $element->_height;
      $this->_x = $element->_x;
      $this->_y = $element->_y;
      $this->_box_width = $element->_box_width;
      $this->_box_height = $element->_box_height;
      $this->_box_x = $element->_box_x;
      $this->_box_y = $element->_box_y;
      $this->_type = $element->_type;
      $this->_extension = $element->_extension;
      $this->_resource = $element->_resource;
      $this->_quality = $element->_quality;
      $this->_opacity = $element->_opacity;
      $this->_from = $element->_from;
      $this->_preserve = $element->_preserve;
      $this->_mimetype = $element->_mimetype;
    }
  }

  /**
   * Loads an image from local o external path.
   * @package GImage
   * @access public
   * @param string $filename Path or url of image.
   * @return bool
   */
  public function load($filename) {
    $loaded = FALSE;
    $image = NULL;

    if (!empty($filename)) {
      $this->filename = $filename;
      $this->name = basename($filename);

      if (filter_var($filename, FILTER_VALIDATE_URL)) {
        $image = file_get_contents($filename);

        if (!empty($image)) {
          $this->_from = 'external';
          $this->_resource = $image = imagecreatefromstring($image);
          $this->_type = Utils::getImageType($filename);
          $this->_extension = Utils::getExtension($filename);
          $this->_width = $this->_box_width = imagesx($image);
          $this->_height = $this->_box_height = imagesy($image);
          $loaded = TRUE;
        }
      } else {
        if (is_file($filename)) {
          $this->_from = 'local';
          $this->_type = $image_type = Utils::getImageType($filename);
          $this->_extension = Utils::getExtension($filename);

          switch ($image_type) {
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

          $loaded = TRUE;
          $this->_resource = $image;
          $this->_width = $this->_box_width = imagesx($image);
          $this->_height = $this->_box_height = imagesy($image);
        }
      }
    }

    return $loaded;
  }

  /**
   * Gets resource of image.
   * @access public
   * @return resource
   */
  public function getResource() {
    return $this->_resource;
  }

  /**
   * Gets filename path of image.
   * @access public
   * @return string
   */
  public function getFilename() {
    return $this->filename;
  }

  /**
   * Gets name of image file.
   * @access public
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Gets image type code. Returns IMAGETYPE_JPEG, IMAGETYPE_PNG or IMAGETYPE_GIF
   * @access public
   * @return int
   */
  public function getType() {
    return $this->_type;
  }

  /**
   * Gets extension. Returns jpg, png or gif.
   * @access public
   * @return string
   */
  public function getExtension() {
    return $this->_extension;
  }

  /**
   * Gets quality.
   * @access public
   * @return int
   */
  public function getQuality() {
    return $this->_quality;
  }

  /**
   * Gets opacity.
   * @access public
   * @return int
   */
  public function getOpacity() {
    return $this->_opacity;
  }

  /**
   * Gets height.
   * @access protected
   * @return int
   */
  public function getWidth() {
    return $this->_width;
  }

  /**
   * Gets width.
   * @access public
   * @return int
   */
  public function getHeight() {
    return $this->_height;
  }

  /**
   * Gets top position.
   * @access protected
   * @return int
   */
  public function getTop() {
    return $this->_y;
  }

  /**
   * Gets left position.
   * @access public
   * @return int
   */
  public function getLeft() {
    return $this->_x;
  }

  /**
   * Gets box left position.
   * @access public
   * @return int
   */
  public function getBoxLeft() {
    return $this->_box_x;
  }

  /**
   * Gets box top position.
   * @access protected
   * @return int
   */
  public function getBoxTop() {
    return $this->_box_y;
  }

  /**
   * Gets box width.
   * @access public
   * @return int
   */
  public function getBoxWidth() {
    return $this->_box_width;
  }

  /**
   * Gets box height.
   * @access public
   * @return int
   */
  public function getBoxHeight() {
    return $this->_box_height;
  }

  /**
   * Gets of from it was loaded the image 'local' or 'external' path.
   * @access public
   * @return string
   */
  public function getLoadedFrom() {
    return $this->_from;
  }

  /**
   * Sets quality for image.
   * @param int $quality Quality value from 0 to 100
   * @access public
   * @return void
   */
  public function setQuality($quality) {
    $this->_quality = $quality;
  }

  /**
   * Sets opacity.
   * @param int $opacity Opacity value from 0 to 127
   * @access public
   * @return void
   */
  public function setOpacity($opacity) {
    $this->_opacity = $opacity > 127 ? 127 : $opacity;
  }

  /**
   * Sets image resource.
   * @param resource $resource resource.
   * @access public
   * @return void
   */
  public function setResource($resource) {
    $this->_resource = $resource;
  }

  /**
   * Sets left position of image.
   * @param int $x left.
   * @access public
   * @return void
   */
  public function setLeft($x) {
    $this->_x = $x;
  }

  /**
   * Sets top position of image.
   * @param int $y top.
   * @access public
   * @return void
   */
  public function setTop($y) {
    $this->_y = $y;
  }

  /**
   * Sets width of box image.
   * @param int $width width.
   * @access public
   * @return void
   */
  public function setBoxWidth($width) {
    $this->_box_width = $width;
  }

  /**
   * Sets height of box image.
   * @param int $height height.
   * @access public
   * @return void
   */
  public function setBoxHeight($height) {
    $this->_box_height = $height;
  }

  /**
   * Sets left position of box image.
   * @param int $x Left position.
   * @access public
   * @return void
   */
  public function setBoxLeft($x) {
    $this->_box_x = $x * (-1);
  }

  /**
   * Sets top position of box image.
   * @param int $y Top position.
   * @access public
   * @return void
   */
  public function setBoxTop($y) {
    $this->_box_y = $y * (-1);
  }

  /**
   * Checks if image was loaded from local path.
   * @access public
   * @return bool
   */
  public function isLocal() {
    return ($this->_from == 'local');
  }

  /**
   * Checks if image was loaded from external url.
   * @access public
   * @return bool
   */
  public function isExternal() {
    return ($this->_from == 'external');
  }

  /**
   * Checks if image is a JPG.
   * @access public
   * @return bool
   */
  public function isJPG() {
    return ($this->_extension == 'jpg');
  }

  /**
   * Checks if image is a PNG.
   * @access public
   * @return bool
   */
  public function isPNG() {
    return ($this->_extension == 'png');
  }

  /**
   * Checks if image is a GIF.
   * @access public
   * @return bool
   */
  public function isGIF() {
    return ($this->_extension == 'gif');
  }

  /**
   * Changes output format to JPG
   * @access public
   * @return void
   */
  public function toJPG() {
    $this->_extension = 'jpg';
    $this->_type = IMAGETYPE_JPEG;
    $this->_mimetype = Utils::getMimetypeByImageType(IMAGETYPE_JPEG);
  }

  /**
   * Changes output format to PNG
   * @access public
   * @return void
   */
  public function toPNG() {
    $this->_extension = 'png';
    $this->_type = IMAGETYPE_PNG;
    $this->_mimetype = Utils::getMimetypeByImageType(IMAGETYPE_PNG);
  }

  /**
   * Changes output format to GIT.
   * @access public
   * @return void
   */
  public function toGIF() {
    $this->_extension = 'gif';
    $this->_type = IMAGETYPE_GIF;
    $this->_mimetype = Utils::getMimetypeByImageType(IMAGETYPE_GIF);
  }

  /**
   * Preserves the resource image when save or output function is called.
   * @access public
   * @param bool $preserve If it's true will preserve the resource image.
   * @return void
   */
  public function preserve($preserve = TRUE) {
    $this->_preserve = $preserve;
  }

  /**
   * Saves the image to specific path.
   * @access public
   * @param string $filename If it's null save function will save the image in load path for default.
   * @return bool True if it is saved successful and False if it is not saved.
   */
  public function save($filename = NULL) {
    return $this->render($filename);
  }

  /**
   * Outputs the image on browser.
   * @access public
   * @return bool
   */
  public function output() {
    return $this->render(NULL, TRUE);
  }

  /**
   * Resize image proportionally basing on the height of the image.
   * @access public
   * @param int $height
   * @return void
   */
  public function resizeToHeight($height) {
    $width = $this->getPropWidth($height);
    $this->resize($width, $height);
  }

  /**
   * Resize image proportionally basing on the width of the image.
   * @access public
   * @param int $width
   * @return void
   */
  public function resizeToWidth($width) {
    $height = $this->getPropHeight($width);
    $this->resize($width, $height);
  }

  /**
   * Gets proportional width of image from height value.
   * @access public
   * @param int $height
   * @return int
   */
  public function getPropWidth($height) {
    $ratio = (int) $height / $this->_height;
    return $this->_width * $ratio;
  }

  /**
   * Gets proportional height of image from width value.
   * @access public
   * @param int $width
   * @return int
   */
  public function getPropHeight($width) {
    $ratio = (int) $width / $this->_width;
    return $this->_height * $ratio;
  }

  /**
   * Scales the image.
   * @access public
   * @param int $scale
   * @return void
   */
  public function scale($scale) {
    $width = $this->_width * (int) $scale / 100;
    $height = $this->_height * (int) $scale / 100;
    $this->resize($width, $height);
  }

  /**
   * Rotate an image with a given angle.
   * @access public
   * @param int $angle
   * @return void
   */
  public function rotate($angle = 0) {
    $this->_resource = imagerotate($this->_resource, $angle, 0);
  }

  /**
   * Cuts an image proportionally and centered.
   * @access public
   * @param int $width Width crop.
   * @param int $height Height crop.
   * @return void
   */
  public function centerCrop($width, $height) {
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

      $x = ($this->_width - $width) / 2;
      $y = ($this->_height - $height) / 2;
      $this->crop($width, $height, $x, $y);
    }
  }

  /**
   * Cuts part of image.
   * @access public
   * @param int $width Width crop.
   * @param int $height Height crop.
   * @param int $x1 [Optional] x-coordinate of source point.
   * @param int $y1 [Optional] y-coordinate of source point.
   * @param int $dst_x [Optional] x-coordinate of destination point.
   * @param int $dst_y [Optional] y-coordinate of destination point.
   * @return void
   */
  public function crop($width, $height, $x1 = 0, $y1 = 0, $dst_x = 0, $dst_y = 0) {
    $this->resize($width, $height, $x1, $y1, $dst_x, $dst_y, TRUE);
  }

  /**
   * Resizes the image.
   * @access private
   * @param int $width Image's width.
   * @param int $height Image's height.
   * @param int $x1 [Optional] Left position
   * @param int $y1 [Optional] Top position
   * @param int $dst_x [Optional] x-coordinate of destination point.
   * @param int $dst_y [Optional] y-coordinate of destination point.
   * @param bool $is_crop [Optional] if it's true resize function will crop the image.
   * @return void
   */
  private function resize($width, $height, $x1 = 0, $y1 = 0, $dst_x = 0, $dst_y = 0, $is_crop = FALSE) {
    $image = $this->_resource;

    if ($image) {
      $simage = imagecreatetruecolor($width, $height);

      if ($this->isPNG()) {
        imagealphablending($simage, FALSE);
        imagesavealpha($simage, TRUE);
      }

      imagecopyresampled($simage, $image, $dst_x, $dst_y, $x1, $y1, $width, $height, ($is_crop) ? $width : $this->_width, ($is_crop) ? $height : $this->_height);

      $this->_resource = $simage;

      $this->_width = $this->_box_width = imagesx($this->_resource);
      $this->_height = $this->_box_height = imagesy($this->_resource);
    }
  }

  /**
   * Renders the image.
   * @access private
   * @param string $filename [Optional] Path to save image
   * @param bool $output [Optional] If it's true render function outputs image.
   * @return bool True if it has worked successful and False if it has not.
   */
  private function render($filename = NULL, $output = FALSE) {
    $saved = FALSE;
    $image = $this->_resource;

    if ($image) {
      if ($this->filename || $filename || $output) {
        $filename = $output ? NULL : ($this->isExternal() ? (empty($filename) ? $this->name : $filename) :
            (empty($filename) ? $this->filename : $filename));
        $quality = $this->_quality;
        $preserve = $this->_preserve;

        if ($output) {
          header('Content-type: ' . $this->_mimetype);
          ob_start();
        }

        if ($this->isJPG()) {
          $saved = imagejpeg($image, $filename, $quality);
        } else {
          if ($this->isPNG()) {
            if ($quality > 10) {
              $quality = 0;
            }

            imagealphablending($image, FALSE);
            imagesavealpha($image, TRUE);

            $saved = imagepng($image, $filename, $quality);
          } else {
            $saved = imagegif($image, $filename);
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

    return $saved;
  }

  /**
   * Destroys resource.
   * @access public
   * @return void
   */
  public function destroy() {
    @imagedestroy($this->_resource);
    $this->_resource = NULL;
  }

}
