<?php
/*
 * This file is part of GImage.
 *
 * (c) Jose Quintana <https://git.io/joseluisq>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GImage;

/**
 * A Text class to embed string into Canvas.
 *
 * @package GImage
 * @author Jose Quintana <https://git.io/joseluisq>
 *
 * @property string $string String text.
 * @property string $fontface Font face .ttf filename.
 * @property string $align Horizontal align mode.
 * @property string $valign Vertical align mode.
 * @property int $angle Angle for the text.
 * @property int $opacity Opacity for the text.
 * @property int $width
 * @property int $height
 * @property float $lineHeight
 * @property int $size
 * @property int $x
 * @property int $y
 * @property int $red
 * @property int $green
 * @property int $blue
 */
class Text
{
    private $string = '';
    private $fontface;
    private $align = 'none';
    private $valign = 'none';
    private $angle = 0;
    private $opacity = 0;
    private $width = 100;
    private $height = 50;
    private $lineHeight = 1.2;
    private $size = 12;
    private $x = 0;
    private $y = 0;
    private $red = 0;
    private $green = 0;
    private $blue = 0;

    /**
     * Sets the plain text.
     *
     * @access public
     * @param string $string Plain text.
     */
    public function __construct($string = '')
    {
        $this->setContent($string);
    }

    /**
     * Sets a plain text.
     *
     * @access public
     * @param string $string Plain text.
     * @return $this
     */
    public function setContent($string = '')
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Sets RGB color for text.
     *
     * @access public
     * @param int $red Red color.
     * @param int $green Green color.
     * @param int $blue Blue color.
     * @return $this
     */
    public function setColor($red, $green, $blue)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;

        return $this;
    }

    /**
     * Sets font size for text.
     *
     * @access public
     * @param int $size Font size.
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Sets font face (TTF font) for text.
     *
     * @access public
     * @param string $fontface Path of TTF font.
     * @return $this
     */
    public function setFontface($fontface)
    {
        $this->fontface = $fontface;

        return $this;
    }

    /**
     * Sets text's opacity.
     *
     * @access public
     * @param int $opacity Opacity value from 0 to 1
     * @return $this
     */
    public function setOpacity($opacity)
    {
        $this->opacity = $opacity;

        return $this;
    }

    /**
     * Sets the horizontal alignment for text.
     *
     * @access public
     * @param string $align Values supported: none, center
     * @return $this
     */
    public function setAlign($align)
    {
        $this->align = $align;

        return $this;
    }

    /**
     * Sets the vertical alignment for text.
     *
     * @access public
     * @param string $valign Two values supported: 'none' or 'center'
     * @return $this
     */
    public function setValign($valign)
    {
        $this->valign = $valign;

        return $this;
    }

    /**
     * Sets text's angle.
     *
     * @access public
     * @param int $angle Angle
     * @return $this
     */
    public function setAngle($angle)
    {
        $this->angle = $angle;

        return $this;
    }

    /**
     * Sets box width.
     *
     * @access public
     * @param int $width Width
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Sets box height.
     *
     * @access public
     * @param int $height Height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Sets top position.
     *
     * @access public
     * @param int $y position
     * @return $this
     */
    public function setTop($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Sets left position.
     *
     * @access public
     * @param int $x position
     * @return $this
     */
    public function setLeft($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Sets line height.
     *
     * @access public
     * @param float $lineHeight line-height
     * @return $this
     */
    public function setLineHeight($lineHeight)
    {
        $this->lineHeight = $lineHeight;

        return $this;
    }

    /**
     * Gets line height.
     *
     * @access public
     * @return float
     */
    public function getLineHeight()
    {
        return $this->lineHeight;
    }

    /**
     * Wrapps the text.
     *
     * @access public
     * @return array
     */
    public function wrappText()
    {
        $wrapp = $this->getWrappedText(
            $this->size,
            $this->angle,
            $this->fontface,
            $this->string,
            $this->width
        );

        return $wrapp;
    }

    /**
     * Gets wrapped text.
     *
     * @access public
     * @param int $size Font size fot the text.
     * @param int $angle Angole for the text.
     * @param string $fontface Path of TTF font.
     * @param string $string String text.
     * @param int $width Width for text box area.
     * @return array
     */
    public function getWrappedText($size, $angle, $fontface, $string, $width = 100)
    {
        $str = '';
        $words = explode(' ', $string);

        foreach ($words as $word) {
            $testStr = $str . ' ' . $word;
            $box = imagettfbbox($size, $angle, $fontface, $testStr);

            if ($box[2] > $width) {
                $str .= ($str == '' ? '' : "\n") . $word;
            } else {
                $str .= ($str == '' ? '' : ' ') . $word;
            }
        }

        $this->string = $str;
        $lines = explode("\n", $str);

        return $lines;
    }

    /**
     * Calculates bounding box of text using the TrueType font.
     * Returns an array with 'left', 'top', 'width' and 'height' values.
     *
     * @author <blackbart@simail.it> <http://www.php.net/manual/en/function.imagettfbbox.php#97357>
     * @access public
     * @param int $fontSize Font size fot the text.
     * @param int $fontAngle Angole for the text.
     * @param string $fontFile Path of TTF font.
     * @param string $text String text.
     * @return array|boolean
     */
    private function getBoundingBox($fontSize, $fontAngle, $fontFile, $text)
    {
        $box = imagettfbbox($fontSize, $fontAngle, $fontFile, $text);

        if (!$box) {
            return false;
        }

        $minX = min([$box[0], $box[2], $box[4], $box[6]]);
        $maxX = max([$box[0], $box[2], $box[4], $box[6]]);
        $minY = min([$box[1], $box[3], $box[5], $box[7]]);
        $maxY = max([$box[1], $box[3], $box[5], $box[7]]);
        $width = ($maxX - $minX);
        $height = ($maxY - $minY);
        $left = abs($minX) + $width;
        $top = abs($minY) + $height;

        // to calculate the exact bounding box i write the text in a large image
        $img = imagecreatetruecolor($width << 2, $height << 2);
        $white = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 0);
        imagefilledrectangle($img, 0, 0, imagesx($img), imagesy($img), $black);
        // for sure the text is completely in the image!
        imagettftext($img, $fontSize, $fontAngle, $left, $top, $white, $fontFile, $text);
        // start scanning (0=> black => empty)
        $rleft = $w4 = $width << 2;
        $rright = 0;
        $rbottom = 0;
        $rtop = $h4 = $height << 2;

        for ($x = 0; $x < $w4; $x++) {
            for ($y = 0; $y < $h4; $y++) {
                if (imagecolorat($img, $x, $y)) {
                    $rleft = min($rleft, $x);
                    $rright = max($rright, $x);
                    $rtop = min($rtop, $y);
                    $rbottom = max($rbottom, $y);
                }
            }
        }

        // destroy img and serve the result
        imagedestroy($img);

        return [
            'left' => $left - $rleft,
            'top' => $top - $rtop,
            'width' => $rright - $rleft + 1,
            'height' => $rbottom - $rtop + 1
        ];
    }

    /**
     * Get the text cords [x, y].
     *
     * @access public
     * @return array An array with [x, y] cords.
     */
    public function getCords()
    {
        $box = $this->getBoundingBox(
            $this->getSize(),
            $this->getAngle(),
            $this->getFontface(),
            $this->getContent()
        );

        $x = $box['left'] + $this->getLeft();
        $y = $this->getTop() + $box['top'];

        if ($this->getAlign() == 'center') {
            $x = ($this->getWidth() - $box['width']) / 2;
        }

        if ($this->getValign() == 'center') {
            $y = ($this->getHeight() - $box['height']) / 2;
        }

        return [$x, $y];
    }

    /**
     * Gets the plain text.
     *
     * @access public
     * @return string
     */
    public function getContent()
    {
        return $this->string;
    }

    /**
     * Gets an array with rgb color.
     *
     * @access public
     * @return array
     */
    public function getColor()
    {
        return [
            $this->red,
            $this->green,
            $this->blue
        ];
    }

    /**
     * Gets the font face.
     *
     * @access public
     * @return string
     */
    public function getFontface()
    {
        return $this->fontface;
    }

    /**
     * Gets fthe ont size.
     *
     * @access public
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Gets the opacity.
     *
     * @access public
     * @return int
     */
    public function getOpacity()
    {
        return $this->opacity;
    }

    /**
     * Gets the horizontal alignment for text.
     *
     * @access public
     * @return string Alignment supported: 'none' or 'center'.
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * Gets the vertical alignment for text.
     *
     * @access public
     * @return string Alignment supported: 'none' or 'center'.
     */
    public function getValign()
    {
        return $this->valign;
    }

    /**
     * Gets the angle.
     *
     * @access public
     * @return int
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * Gets width.
     *
     * @access public
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Gets height.
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
     * @access public
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
}
