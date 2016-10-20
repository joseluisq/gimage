<?php

namespace GImage;

use GImage\Image;
use GImage\Text;

/**
 * A Canvas represents a rectangular image area on which one can draw images.
 * @package GImage
 * @access public
 * @version 2.0.0
 * @author José Luis Quintana <https://git.io/joseluisq>
 * @license https://github.com/joseluisq/gimage/blob/master/license.md
 * @property array $list An array of elements (Image, Figure or Text classes)
 * @link Github https://github.com/joseluisq/gimage
 */
class Canvas extends Image
{
    private $list = [];

    /**
    * Constructs a new Canvas.
    * @param mixed $element Only Image or Figure class
    * @access public
    * @return void
    */
    public function __construct($element = null)
    {
        parent::__construct($element);
    }

    /**
    * Adds one or more elements to canvas.
    * @param mixed $elements Single or array of Image, Figure, Text classes.
    * @access public
    * @return void
    */
    public function append($elements)
    {
        if (!empty($elements)) {
            $elements = is_array($elements) ? $elements : [$elements];

            foreach ($elements as $element) {
                if ($element instanceof Image || $element instanceof Text) {
                    $this->list[] = $element;
                }
            }
        }

        return $this;
    }

    /**
    * Draws the canvas.
    * @access public
    * @return void
    */
    public function draw()
    {
        $canvas = $this->resource;

        if ($canvas) {
            $list = $this->list;

            foreach ($list as $element) {
                if ($element instanceof Image) {
                    $simage = $element->getResource();
                    imagecopyresampled($canvas, $simage, $element->getLeft(), $element->getTop(), $element->getBoxLeft(), $element->getBoxTop(), $element->getBoxWidth(), $element->getBoxHeight(), $element->getWidth(), $element->getHeight());
                } else {
                    if ($element instanceof Text) {
                        $rgbColor = $element->getColor();
                        $color = imagecolorallocatealpha($canvas, $rgbColor[0], $rgbColor[1], $rgbColor[2], $element->getOpacity());

                        $linesStr = $element->wrappText();
                        $cords = $element->calculateTextBox($element->getSize(), $element->getAngle(), $element->getFontface(), $element->getString());

                        // Alignment
                        $x = $cords['left'] + $element->getLeft();
                        $y = $element->getTop() + $cords['top'];

                        if ($element->getAlign() == 'center') {
                            $x = ($element->getWidth() - $cords['width']) / 2;
                        }

                        if ($element->getValign() == 'center') {
                            $y = ($element->getHeight() - $cords['height']) / 2;
                        }

                        // Line height
                        $line_height = $element->getLineHeight() * $element->getSize();
                        $size = $element->getSize();
                        $angle = $element->getAngle();
                        $font = $element->getFontface();

                        foreach ($linesStr as $i => $lineStr) {
                            $ny = $y + ($line_height * $i);
                            imagettftext($canvas, $size, $angle, $x, $ny, $color, $font, $lineStr);
                        }
                    }
                }
            }

            $this->resource = $canvas;
        } else {
            throw new \Exception(''
            . 'Image or Figure class is not assigned. '
            . 'You can do it using the "Canvas->from($element)" method.'
            . '');
        }

        return $this;
    }
}
