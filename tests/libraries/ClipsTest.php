<?php defined("BASEPATH") or exit("No direct script access allowed");

class Sample {
	public $name = "Jack";
}

class Test_Account {
	public $nickname;
	public $profile_image;
}

class ClipsTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->clips = $this->CI->clips;
		$this->model('login_model');
	}

	public function testDetailMatching() {
		$this->clips->clear();
		$json = '{"nick":"Jack","profile_img":"a.jpg"}';
		$details = json_decode($json);
		$this->clips->assertFacts(array(new Test_Account()));
		$facts = array();
		foreach($details as $k => $v) {
			$facts []= array($k, $v);
		}
		$this->clips->assertFacts($facts);
		$this->clips->facts();
		$this->clips->load(FCPATH.APPPATH.'tests/rules/test_detail.rules');
		$this->clips->run();
		print_r($this->clips->queryFacts('Test_Account'));
	}

	public function testAssertFacts() {
		$this->clips->clear();
		$this->login_model->is_loggedin = 123;
		$this->login_model->token = "adsf";
	}
}
