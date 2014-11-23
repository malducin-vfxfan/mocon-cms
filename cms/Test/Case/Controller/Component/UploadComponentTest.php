<?php
/**
 * Upload Component test.
 *
 * Test the UploadComponent.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Test.Case.Controller.Component
 */
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('UploadComponent', 'Controller/Component');

// A fake controller to test against
// A fake controller to test against
class UploadControllerTest extends Controller {
}

class UploadComponentTest extends CakeTestCase {
	public $UploafComponent = null;
	public $Controller = null;

	public function setUp() {
		parent::setUp();
		// Setup our component and fake test controller
		$Collection = new ComponentCollection();
		$this->UploadComponent = new UploadComponent($Collection);
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->Controller = new UploadControllerTest($CakeRequest, $CakeResponse);
		$this->UploadComponent->startup($this->Controller);
	}

	public function testConvertFilenameToId() {
		// Test our convertFilenameToId method with different parameters
		$this->assertEquals('0000000001.jpg', $this->UploadComponent->convertFilenameToId('1', 'star-wars.jpg'));

		$this->assertEquals('0000000001.jpg', $this->UploadComponent->convertFilenameToId('1', 'star-wars.md.jpg'));

		$this->assertEquals('0000000000.jpg', $this->UploadComponent->convertFilenameToId('', 'star-wars.jpg'));

		$this->assertEquals('0000000001', $this->UploadComponent->convertFilenameToId('1', ''));

		$this->assertEquals('0000000000', $this->UploadComponent->convertFilenameToId('', ''));
	}

	public function tearDown() {
		parent::tearDown();
		// Clean up after we're done
		unset($this->UploadComponent);
		unset($this->Controller);
	}

}
