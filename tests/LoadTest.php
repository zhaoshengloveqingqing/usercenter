<?php defined('BASEPATH') or exit('No direct script access allowed');

class LoadTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
	}

	public function testLoadUpload() {
		$this->library('upload');
		$this->assertEquals(get_class($this->upload), 'Pinet_Upload');
	}
}
