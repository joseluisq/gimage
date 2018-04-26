<?php
/*
 * This file is part of GImage.
 *
 * (c) José Luis Quintana <https://git.io/joseluisq>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GImage\Test;

use GImage\Image;
use GImage\Text;
use GImage\Figure;
use GImage\Canvas;
use PHPUnit\Framework\TestCase;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('GIMAGE_PATH_APP', dirname(dirname(__FILE__)));
define('GIMAGE_PATH_TMP', sys_get_temp_dir());

/**
 * GImage Test suite.
 *
 * @package GImage
 * @author Jose Luis Quintana <https://git.io/joseluisq>
 */
class GImageTest extends TestCase
{
    public function testLoad()
    {
        // Loading an image (200x200) from Gravatar
        $img = new Image();
        $resource = $img->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200.jpg');

        $this->assertNotNull($resource);

        return $img;
    }

    /**
    * @depends testLoad
    */
    public function testGetResource(Image $img)
    {
        $this->assertNotEmpty($img->getResource());
        $this->assertNotNull($img->getResource());

        return $img;
    }

    /**
    * @depends testGetResource
    */
    public function testIsJPG(Image $img)
    {
        $this->assertTrue($img->isJPG());
    }

    /**
    * @depends testGetResource
    */
    public function testIsNotPNG(Image $img)
    {
        $this->assertFalse($img->isPNG());
    }

    /**
    * @depends testGetResource
    */
    public function testIsNotGif(Image $img)
    {
        $this->assertFalse($img->isGIF());
    }

    /**
    * @depends testGetResource
    */
    public function testIsLocal(Image $img)
    {
        $this->assertFalse($img->isLocal());
    }

    /**
    * @depends testGetResource
    */
    public function testIsExternal(Image $img)
    {
        $this->assertTrue($img->isExternal());
    }

    /**
    * @depends testGetResource
    */
    public function testIsImageString(Image $img)
    {
        $this->assertFalse($img->isImageString());
    }

    /**
    * @depends testLoad
    */
    public function testScale(Image $img)
    {
        // Scaling to 50% (100x100)
        $img->scale(0.5);

        $this->assertEquals($img->getWidth(), 100);
        $this->assertEquals($img->getHeight(), 100);

        return $img;
    }

    /**
    * @depends testLoad
    */
    public function testCenterCrop(Image $img)
    {
        // Center and croping to 100px
        $img->centerCrop(100, 100);

        $this->assertEquals($img->getWidth(), 100);
        $this->assertEquals($img->getHeight(), 100);

        return $img;
    }

    /**
    * @depends testLoad
    */
    public function testRotate(Image $img)
    {
        // Rotating to 180º
        $resource = $img->getResource();
        $img->rotate(180);

        $this->assertNotEquals($resource, $img->getResource());

        return $img;
    }

    public function testCreateFigure()
    {
        $figure = new Figure(400, 250);
        $figure
            ->setBackgroundColor(47, 42, 39)
            ->create();

        $this->assertInstanceOf('GImage\Figure', $figure);

        return $figure;
    }

    /**
    * @depends testCreateFigure
    */
    public function testCreateCanvas(Figure $figure)
    {
        $canvas = new Canvas();
        $canvas->from($figure);

        $this->assertInstanceOf('GImage\Image', $canvas);

        return $canvas;
    }

    public function testCreateText()
    {
        $text = new Text('This is cool text!');
        $text
            ->setWidth(400)
            ->setHeight(250)
            ->setAlign('center')
            ->setValign('center')
            ->setLineHeight(1.2)
            ->setSize(22)
            ->setColor(255, 255, 255)
            ->setFontface(GIMAGE_PATH_APP . DS . 'examples/fonts/Lato-Lig.ttf');

        $this->assertInstanceOf('GImage\Text', $text);

        return $text;
    }

    /**
    * @depends testCreateCanvas
    * @depends testCreateText
    */
    public function testCanvasAppendText(Canvas $canvas, Text $text)
    {
        $canvas
            ->append($text)
            ->toJPG()
            ->draw();

        $this->assertEquals($canvas->getType(), IMAGETYPE_JPEG);

        return $canvas;
    }

    /**
    * @depends testScale
    */
    public function testPreserveResource(Image $img)
    {
        $img->preserve();
        $this->assertNotNull($img->getResource());

        return $img;
    }

    /**
    * @depends testPreserveResource
    */
    public function testSavePreserved(Image $img)
    {
        $this->assertNotNull($img->save(GIMAGE_PATH_TMP . DS . 'test1.jpg'));
        $this->assertNotNull($img->getResource());

        return $img;
    }

    /**
    * @depends testScale
    */
    public function testNotPreserveResource(Image $img)
    {
        $img->preserve(false);

        $this->assertNotNull($img->getResource());

        return $img;
    }

    /**
    * @depends testNotPreserveResource
    */
    public function testSaveNotPreserved(Image $img)
    {
        $this->assertNotNull($img->save(GIMAGE_PATH_TMP . DS . 'test2.jpg'));
        $this->assertNull($img->getResource());

        return $img;
    }

    /**
    * @depends testLoad
    */
    public function testDestroyResource(Image $img)
    {
        $img->destroy();

        $this->assertNull($img->getResource());
    }

    /**
    * @depends testCanvasAppendText
    */
    public function testCanvasSave(Canvas $canvas)
    {
        $this->assertNotNull($canvas->save(GIMAGE_PATH_TMP . DS . 'test3.jpg'));

        return $canvas;
    }

    /**
    * @depends testCanvasSave
    */
    public function testLoadImageString(Canvas $canvas)
    {
        $imagestring = file_get_contents(GIMAGE_PATH_TMP . DS . 'test3.jpg');
        $this->assertNotNull($imagestring);

        $img = new Image();
        $img
            ->load($imagestring)
            ->scale(0.50)
            ->toPNG();

        $this->assertTrue($img->isImageString());
        $this->assertNotNull($img->save(GIMAGE_PATH_TMP . DS . 'rectangle.png'));
    }
}
