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
 * A Canvas represents a rectangular image area on which one can append images, text and figures.
 *
 * @author Jose Quintana <https://joseluisq.net>
 *
 * @property array $elementList An array of elements (Image, Figure or Text classes).
 */
class Canvas extends Image
{
    /**
     * List of elements.
     *
     * @var array
     */
    private $elementList = [];

    /**
     * Constructs a new Canvas.
     *
     * @param mixed $element only Image or Figure classes
     */
    public function __construct($element = null)
    {
        parent::__construct($element);
    }

    /**
     * Adds one or more elements to canvas.
     *
     * @param mixed $elements single or array of Image, Figure, Text classes
     *
     * @return \GImage\Canvas|static
     */
    public function append($elements)
    {
        if (!empty($elements)) {
            $elements = is_array($elements) ? $elements : [$elements];

            foreach ($elements as $element) {
                if ($element instanceof Image || $element instanceof Text) {
                    $this->elementList[] = $element;
                }
            }
        }

        return $this;
    }

    /**
     * Draws the canvas.
     *
     * @return \GImage\Canvas|static
     *
     * @throws \Exception
     */
    public function draw()
    {
        $canvas = $this->resource;

        if ($canvas) {
            foreach ($this->elementList as $element) {
                if ($element instanceof Image) {
                    $this->drawImage($element, $canvas);
                }

                if ($element instanceof Text) {
                    $this->drawText($element, $canvas);
                }
            }

            $this->resource = $canvas;
        } else {
            throw new \Exception('' . 'Image or Figure class is not assigned. ' . 'E.g. "new Canvas($image_or_figure)"' . '');
        }

        return $this;
    }

    /**
     * Draw the an Image or Figure element.
     *
     * @param \GImage\Image|\GImage\Figure $element image or Figure element
     * @param mixed                        $canvas
     *
     * @return void
     */
    private function drawImage($element, $canvas)
    {
        $image = $element->getResource();

        imagecopyresampled(
            $canvas,
            $image,
            $element->getLeft(),
            $element->getTop(),
            $element->getBoxLeft(),
            $element->getBoxTop(),
            $element->getBoxWidth(),
            $element->getBoxHeight(),
            $element->getWidth(),
            $element->getHeight()
        );
    }

    /**
     * Draw a Text element.
     *
     * @param \GImage\Text $text   text element
     * @param mixed        $canvas
     *
     * @return void
     */
    private function drawText(Text $text, $canvas)
    {
        list($red, $green, $blue) = $text->getColor();
        $opacity                  = Utils::fixPNGOpacity($text->getOpacity());

        $color = imagecolorallocatealpha(
            $canvas,
            $red,
            $green,
            $blue,
            $opacity < 127 ? $opacity : 0
        );

        $size       = $text->getSize();
        $angle      = $text->getAngle();
        $font       = $text->getFontface();
        $lineHeight = $text->getLineHeight() * $text->getSize();

        list($x, $y) = $text->getCords();
        $x           = (int) floor($x);

        $lines = $text->wrappText();

        foreach ($lines as $i => $line) {
            $ny = (int) floor($y + ($lineHeight * $i));
            imagealphablending($canvas, true);
            imagettftext($canvas, $size, $angle, $x, $ny, $color, $font, $line);
        }
    }
}
