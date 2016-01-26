<?php defined('BASEPATH') or exit('No direct script access allowed');

class LoginTokenTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->library(array('login_token', 'encryptor'));
	}
	public function testIsValid() {
		$token = new Login_Token(null);
		$this->assertFalse($token->isValid());
		$token->createDate = strtotime('today');
		$this->assertFalse($token->isValid());
		$token->uid = 1;
		$this->assertTrue($token->isValid());
		$token->expireDate = strtotime('yesterday');
		$this->assertFalse($token->isValid());
		$token->expireDate = strtotime('tomorrow');
		$this->assertTrue($token->isValid());
	}

	public function testSetToken() {
		$token = new Login_Token();
		$token->uid = 1;
		$this->assertEquals($token->uid, 1);
		$token->createDate = strtotime('today');

		$another_token = new Login_Token($token->genToken());
		$this->assertEquals($another_token, $token);
	}

	public function doTearDown() {
	}
}
