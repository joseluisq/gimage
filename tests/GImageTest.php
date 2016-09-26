<?php

namespace GImage\Test;

use GImage\Image;
use GImage\Text;
use GImage\Figure;
use GImage\Canvas;

if (!defined('DS')) {
  define('DS', DIRECTORY_SEPARATOR);
}

define('GIMAGE_PATH_APP', dirname(dirname(__FILE__)));
define('GIMAGE_PATH_TMP', GIMAGE_PATH_APP . DS . 'tmp');

/**
 * PHPUnit / GImage Test Class
 * @package GImage
 * @version 1.0.3
 * @author José Luis Quintana <quintana.io>
 * @license https://github.com/joseluisq/gimage/blob/master/license.md
 */
class GImageTest extends \PHPUnit_Framework_TestCase {

  public function testLoad() {
    // Loading an image (200x200) from Gravatar
    $img = new Image();
    $img_loaded = $img->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200.jpg');

    $this->assertTrue($img_loaded);

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testGetResource(Image $img) {
    $this->assertNotEmpty($img->getResource());
    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testGetResource
   */
  public function testIsJPG(Image $img) {
    $this->assertTrue($img->isJPG());
  }

  /**
   * @depends testGetResource
   */
  public function testIsNotPNG(Image $img) {
    $this->assertFalse($img->isPNG());
  }

  /**
   * @depends testGetResource
   */
  public function testIsNotGif(Image $img) {
    $this->assertFalse($img->isGIF());
  }

  /**
   * @depends testGetResource
   */
  public function testIsLocal(Image $img) {
    $this->assertFalse($img->isLocal());
  }

  /**
   * @depends testGetResource
   */
  public function testIsExternal(Image $img) {
    $this->assertTrue($img->isExternal());
  }

  /**
   * @depends testLoad
   */
  public function testScale(Image $img) {
    // Scaling to 50% (100x100)
    $img->scale(50);

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testCenterCrop(Image $img) {
    // Center and croping to 100px
    $img->centerCrop(100, 100);

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testRotate(Image $img) {
    // Rotating to 180º
    $img->rotate(180);

    return $img;
  }

  public function testCreateFigure() {
    $figure = new Figure(400, 250);
    $figure->setBackgroundColor(47, 42, 39);
    $figure->create();

    $this->assertInstanceOf('GImage\Figure', $figure);

    return $figure;
  }

  /**
   * @depends testCreateFigure
   */
  public function testCreateCanvas(Figure $figure) {
    $canvas = new Canvas();
    $canvas->from($figure);

    $this->assertInstanceOf('GImage\Image', $canvas);

    return $canvas;
  }

  public function testCreateText() {
    $text = new Text('This is cool text!');
    $text->setWidth(400);
    $text->setHeight(250);
    $text->setAlign('center');
    $text->setValign('center');
    $text->setLineHeight(1.2);
    $text->setSize(22);
    $text->setColor(255, 255, 255);
    $text->setFontface(GIMAGE_PATH_APP . DS . 'examples/fonts/Lato-Lig.ttf');

    $this->assertInstanceOf('GImage\Text', $text);

    return $text;
  }

  /**
   * @depends testCreateCanvas
   * @depends testCreateText
   */
  public function testCanvasAppendText(Canvas $canvas, Text $text) {
    $canvas->append($text);
    $canvas->toJPG();
    $canvas->draw();

    $this->assertEquals($canvas->getType(), IMAGETYPE_JPEG);

    return $canvas;
  }

  /**
   * @depends testScale
   */
  public function testPreserveResource(Image $img) {
    $img->preserve();
    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testPreserveResource
   */
  public function testSavePreserved(Image $img) {
    $this->assertTrue($img->save(GIMAGE_PATH_TMP . DS . 'test1.jpg'));
    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testScale
   */
  public function testNotPreserveResource(Image $img) {
    $img->preserve(FALSE);

    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testNotPreserveResource
   */
  public function testSaveNotPreserved(Image $img) {
    $this->assertTrue($img->save(GIMAGE_PATH_TMP . DS . 'test2.jpg'));
    $this->assertNull($img->getResource());

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testDestroyResource(Image $img) {
    $img->destroy();
    $this->assertNull($img->getResource());
  }

  /**
   * @depends testCanvasAppendText
   */
  public function testCanvasSave(Canvas $canvas) {
    $this->assertFalse($canvas->save());
    $this->assertTrue($canvas->save(GIMAGE_PATH_TMP . DS . 'test3.jpg'));
  }

}
