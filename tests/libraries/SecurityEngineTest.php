<?php defined("BASEPATH") or exit("No direct script access allowed");

class SecurityEngineTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->library('security_engine', 'se');
		$this->library(array('session', 'test_data'));
		$this->model('login_model', 'lm');
	}

	public function testValidateAction() {
		echo $this->se->validate(get_controller_meta(), null);
	}

	public function testValidateField() {
		$this->assertNotNull($this->se);
		echo $this->se->validate(new FormField(), null);
	}

	public function testValidateColumn() {
		$this->assertNotNull($this->se);
		echo $this->se->validate('test_col', null);
	}

	public function testWithUserLoggedIn() {
		$this->session->set_userdata('pinet_token', $this->lm->genToken(1));
		$this->se->validate(get_controller_meta(), null);
		$this->assertEquals(count($this->se->clips->runWithEnv(Security_Engine::CLIPS_SECURITY_ENV, function($clips){  return $clips->queryFacts('Pinet_User'); })), 1);
	}

	public function doTearDown() {
	}
}
