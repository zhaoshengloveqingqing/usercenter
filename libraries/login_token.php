<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login_Token {
	private $token;
	public $uid;
	public $createDate; 
	public $expireDate = -1;

	public function __construct($token = null) {
		if(isset($token)) {
			$this->setToken($token);
		}
		else {
			$this->createDate = time(); // The create date is now by default
		}
	}

	public function setToken($token) {
		$CI = &get_instance();
		$CI->load->library('encryptor');
		$decrypted = $CI->encryptor->decrypt(urldecode($token));
		copy_object(json_decode($decrypted), $this);
		$this->token = $token;
	}

	public function genToken() {
		$CI = &get_instance();
		$CI->load->library('encryptor');
		$this->token = urlencode($CI->encryptor->encrypt(json_encode(array(
			'uid' => $this->uid,
			'createDate' => $this->createDate,
			'expireDate' => $this->expireDate))));
		return $this->token;
	}

	public function isValid() {
		if(isset($this->uid)) { // This token must have uid
			if($this->expireDate >= 0) { // If the expire date is below 0, assume the token is valid
				return $this->expireDate > time();
			}
			return true;
		}
		return false;
	}
}
