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
 * Class to embed simple graphic into the Canvas.
 *
 * @author  Jose Quintana <http://git.io/joseluisq>
 *
 * @property int $red   Red color
 * @property int $green Green color
 * @property int $blue  Blue color
 */
class Figure extends Image
{
    protected $height     = 0;
    protected $width      = 0;
    protected $red        = 0;
    protected $green      = 0;
    protected $blue       = 0;
    protected $figureType = 'rectangle';

    /**
     * Sets size for figure.
     *
     * @param int $width  width
     * @param int $height height
     */
    public function __construct($width = 0, $height = 0)
    {
        $this->setSize($width, $height);
        $this->toPNG();

        parent::__construct();
    }

    /**
     * Sets size to figure.
     *
     * @param int $width  width
     * @param int $height height
     *
     * @return \GImage\Figure|static
     */
    public function setSize($width = 0, $height = 0)
    {
        if (!empty($width) && !empty($height)) {
            $this->width  = $this->boxWidth  = $width;
            $this->height = $this->boxHeight = $height;
        }

        return $this;
    }

    /**
     * Sets the figure type as 'rectangle'.
     *
     * @return \GImage\Figure|static
     */
    public function isRectangle()
    {
        $this->figureType = 'rectangle';

        return $this;
    }

    /**
     * Sets the figure type as 'ellipse'.
     *
     * @return \GImage\Figure|static
     */
    public function isEllipse()
    {
        $this->figureType = 'ellipse';

        return $this;
    }

    /**
     * Sets background color in RGB format.
     *
     * @param int $red   red
     * @param int $green green
     * @param int $blue  blue
     *
     * @return \GImage\Figure|static
     */
    public function setBackgroundColor($red, $green, $blue)
    {
        $this->red   = $red;
        $this->green = $green;
        $this->blue  = $blue;

        return $this;
    }

    /**
     * Gets an array with the RGB background colors.
     *
     * @return array an array with RGB colors
     */
    public function getBackgroundColor()
    {
        return [$this->red, $this->green, $this->blue];
    }

    /**
     * Creates the figure with alpha channel.
     *
     * @return \GImage\Figure|static
     */
    public function create()
    {
        $this->resource = imagecreatetruecolor($this->width, $this->height);
        imagesavealpha($this->resource, true);

        $color = imagecolorallocatealpha(
            $this->resource,
            $this->red,
            $this->green,
            $this->blue,
            0
        );

        if ($this->figureType == 'rectangle') {
            $this->createRectangle($color);
        }

        if ($this->figureType == 'ellipse') {
            $this->createEllipse($color);
        }

        $this->addOpacityFilter();

        return $this;
    }

    /**
     * Creates a filled rectangle.
     *
     * @return void
     */
    private function createRectangle($color)
    {
        imagefilledrectangle(
            $this->resource,
            0,
            0,
            $this->width,
            $this->height,
            $color
        );
    }

    /**
     * Creates a filled ellipse.
     *
     * @return void
     */
    private function createEllipse($color)
    {
        $alpha = imagecolorallocatealpha($this->resource, 255, 255, 255, 127);
        imagefill($this->resource, 0, 0, $alpha);

        imagefilledellipse(
            $this->resource,
            $this->width / 2,
            $this->height / 2,
            $this->width,
            $this->height,
            $color
        );
    }
}
