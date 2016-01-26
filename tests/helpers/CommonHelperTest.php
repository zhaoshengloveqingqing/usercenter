<?php defined("BASEPATH") or exit("No direct script access allowed");

class CommonHelperTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
	}

	public function testMergeObjects() {
		$o1 = (object) array('a' => 1, 'b' => 2);
		$o2 = (object) array('c' => 3, 'b' => 3);
		$o3 = merge_objects($o1, $o2);
		$this->assertEquals($o3, (object)array(
			'a' => 1,
			'b' => 2,
			'c' => 3
		));
		$o4 = merge_objects($o1, $o2, $o3, array('d' => 4), 1, 2, 3);
		$this->assertEquals($o4, (object)array(
			'a' => 1,
			'b' => 2,
			'c' => 3,
			'd' => 4
		));
	}
}
