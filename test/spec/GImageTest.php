<?php

if (!defined('DS')) {
  define('DS', DIRECTORY_SEPARATOR);
}

define('GIMAGE_PATH_APP', dirname(dirname(dirname(__FILE__))));
define('GIMAGE_PATH_TMP', GIMAGE_PATH_APP . DS . 'tmp');

/**
 * PHPUnit / GImage Test Class
 * @package GImage
 * @version 1.0.3
 * @author José Luis Quintana <quintana.io>
 * @license https://github.com/quintana-dev/gimage/blob/master/license.md
 */
class GImageTest extends PHPUnit_Framework_TestCase {

  public function testLoad() {
    // Loading an image (200x200) from Gravatar
    $img = new GImage();
    $img_loaded = $img->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200.jpg');

    $this->assertTrue($img_loaded);

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testGetResource(GImage $img) {
    $this->assertNotEmpty($img->getResource());
    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testGetResource
   */
  public function testIsJPG(GImage $img) {
    $this->assertTrue($img->isJPG());
  }

  /**
   * @depends testGetResource
   */
  public function testIsNotPNG(GImage $img) {
    $this->assertFalse($img->isPNG());
  }

  /**
   * @depends testGetResource
   */
  public function testIsNotGif(GImage $img) {
    $this->assertFalse($img->isGIF());
  }

  /**
   * @depends testGetResource
   */
  public function testIsLocal(GImage $img) {
    $this->assertFalse($img->isLocal());
  }

  /**
   * @depends testGetResource
   */
  public function testIsExternal(GImage $img) {
    $this->assertTrue($img->isExternal());
  }

  /**
   * @depends testLoad
   */
  public function testScale(GImage $img) {
    // Scaling to 50% (100x100)
    $img->scale(50);

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testCenterCrop(GImage $img) {
    // Center and croping to 100px
    $img->centerCrop(100, 100);

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testRotate(GImage $img) {
    // Rotating to 180º
    $img->rotate(180);

    return $img;
  }

  public function testCreateFigure() {
    $figure = new GFigure(400, 250);
    $figure->setBackgroundColor(47, 42, 39);
    $figure->create();

    $this->assertInstanceOf('GFigure', $figure);

    return $figure;
  }

  /**
   * @depends testCreateFigure
   */
  public function testCreateCanvas(GFigure $figure) {
    $canvas = new GCanvas();
    $canvas->from($figure);

    $this->assertInstanceOf('GImage', $canvas);

    return $canvas;
  }

  public function testCreateText() {
    $text = new GText('This is cool text!');
    $text->setWidth(400);
    $text->setHeight(250);
    $text->setAlign('center');
    $text->setValign('center');
    $text->setSize(22);
    $text->setColor(255, 255, 255);
    $text->setFontface(GIMAGE_PATH_APP . DS . 'examples/fonts/Lato-Lig.ttf');

    $this->assertInstanceOf('GText', $text);

    return $text;
  }

  /**
   * @depends testCreateCanvas
   * @depends testCreateText
   */
  public function testCanvasAppendText(GCanvas $canvas, GText $text) {
    $canvas->append($text);
    $canvas->toJPG();
    $canvas->draw();

    $this->assertEquals($canvas->getType(), IMAGETYPE_JPEG);

    return $canvas;
  }

  /**
   * @depends testScale
   */
  public function testPreserveResource(GImage $img) {
    $img->preserve();
    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testPreserveResource
   */
  public function testSavePreserved(GImage $img) {
    $this->assertTrue($img->save(GIMAGE_PATH_TMP . DS . 'test1.jpg'));
    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testScale
   */
  public function testNotPreserveResource(GImage $img) {
    $img->preserve(FALSE);

    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testNotPreserveResource
   */
  public function testSaveNotPreserved(GImage $img) {
    $this->assertTrue($img->save(GIMAGE_PATH_TMP . DS . 'test2.jpg'));
    $this->assertNull($img->getResource());

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testDestroyResource(GImage $img) {
    $img->destroy();
    $this->assertNull($img->getResource());
  }

  /**
   * @depends testCanvasAppendText
   */
  public function testCanvasSave(GCanvas $canvas) {
    $this->assertFalse($canvas->save());
    $this->assertTrue($canvas->save(GIMAGE_PATH_TMP . DS . 'test3.jpg'));
  }

}
