<?php

/**
 * A Canvas represents a rectangular image area on which one can draw images.
 * @package GImage
 * @access public
 * @version 1.0.3
 * @author José Luis Quintana <quintana.io>
 * @license https://github.com/quintana-dev/gimage/blob/master/license.md
 * @property array $_list An array of elements classes (GImage, GFigure or GText classes)
 * @link Github https://github.com/quintana-dev/gimage
 */
class GCanvas extends GImage {

  private $_list = array();

  /**
   * Constructs a new Canvas.
   * @param mixed $element Only GImage or GFigure class
   * @access public
   * @return void
   */
  function __construct($element = NULL) {
    parent::__construct($element);
  }

  /**
   * Adds one or more elements to canvas.
   * @param mixed $elements Single or array of GImage, GFigure, GText classes.
   * @access public
   * @return void
   */
  public function append($elements) {
    if (!empty($elements)) {
      $elements = is_array($elements) ? $elements : array($elements);

      foreach ($elements as $element) {
        if ($element instanceof GImage || $element instanceof GText) {
          $this->_list[] = $element;
        }
      }
    }
  }

  /**
   * Draws the canvas.
   * @access public
   * @return void
   */
  public function draw() {
    $canvas = $this->_resource;

    if ($canvas) {
      $list = $this->_list;

      foreach ($list as $element) {
        if ($element instanceof GImage) {
          $simage = $element->getResource();
          imagecopyresampled($canvas, $simage, $element->getLeft(), $element->getTop(), $element->getBoxLeft(), $element->getBoxTop(), $element->getBoxWidth(), $element->getBoxHeight(), $element->getWidth(), $element->getHeight());
        } else {
          if ($element instanceof GText) {
            $rgb_color = $element->getColor();
            $color = imagecolorallocatealpha($canvas, $rgb_color[0], $rgb_color[1], $rgb_color[2], $element->getOpacity());

            $element->wrappText();

            $coordinates = $element->calculateTextBox($element->getSize(), $element->getAngle(), $element->getFontface(), $element->getString());

            // Alignment
            $x = $coordinates['left'] + $element->getLeft();
            $y = $element->getTop() + $coordinates['top'];

            if ($element->getAlign() == 'center') {
              $x = ($element->getWidth() / 2) - ($coordinates['width'] / 2);
            }

            if ($element->getValign() == 'center') {
              $y = ($element->getHeight() / 2) - ($coordinates['height'] / 2);
            }

            imagettftext($canvas, $element->getSize(), $element->getAngle(), $x, $y, $color, $element->getFontface(), $element->getString());
          }
        }
      }

      $this->_resource = $canvas;
    } else {
      throw new Exception('GImage or GFigure class is not assigned. You can do it using the "GCanvas->from($element)" method.');
    }
  }

}
