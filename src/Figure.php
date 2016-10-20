<?php

namespace GImage;

use GImage\Image;

/**
 * Class to embed simple graphic into the Canvas.
 * A Figure can be a Canvas too.
 * @package GImage
 * @access public
 * @version 0.0.0
 * @author José Luis Quintana <http://git.io/joseluisq>
 * @license https://github.com/joseluisq/gimage/blob/master/license.md
 * @property int $red Red color
 * @property int $green Green color
 * @property int $blue Blue color
 * @link Github https://github.com/joseluisq/gimage
 */
class Figure extends Image
{
    protected $height = 0;
    protected $width = 0;
    protected $red = 0;
    protected $green = 0;
    protected $blue = 0;

  /**
   * Sets size for figure.
   * @access public
   * @param int $width Width.
   * @param int $height Height.
   * @return void
   */
  public function __construct($width = 0, $height = 0)
  {
      $this->setSize($width, $height);

      parent::__construct();
  }

  /**
   * Sets size to figure.
   * @access public
   * @param int $width Width.
   * @param int $height Height.
   * @return void
   */
  public function setSize($width = 0, $height = 0)
  {
      if (!empty($width) && !empty($height)) {
          $this->width = $this->boxWidth = $width;
          $this->height = $this->boxHeight = $height;
      }

      return $this;
  }

  /**
   * Sets background color.
   * @access public
   * @param int $red Red.
   * @param int $green Green.
   * @param int $blue Blue.
   * @return void
   */
  public function setBackgroundColor($red, $green, $blue)
  {
      $this->red = $red;
      $this->green = $green;
      $this->blue = $blue;

      return $this;
  }

  /**
   * Sets background color.
   * @access public
   * @return void
   */
  public function getBackgroundColor()
  {
      return [$this->red, $this->green, $this->blue];
  }

  /**
   * Creates the figure.
   * @access public
   * @return void
   */
  public function create()
  {
      $figure = imagecreatetruecolor($this->width, $this->height);
      $color = imagecolorallocatealpha($figure, $this->red, $this->green, $this->blue, $this->opacity);
      imagefilledrectangle($figure, 0, 0, $this->width, $this->height, $color);
      $this->resource = $figure;

      return $this;
  }
}
