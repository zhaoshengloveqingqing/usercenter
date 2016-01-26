<?php defined("BASEPATH") or exit("No direct script access allowed");

class User_Basic_Info_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('user_basic_infos');
	}

	public function getByUid($uid) {
		return $this->get('uid', $uid);
	}

	public function getByUsername($username) {
        $this->result_mode = 'object';
		return $this->get('username', $username);
	}

	public function usernameExists($username) {
		$this->result_mode = 'object';
		$user = $this->getByUsername($username);
		return isset($user->id);
	}

	public function testPassword($username, $password) {
		$user = $this->getByUsername($username);
		if(isset($user->id)) {
			return $user->password == $password;
		}
		return false;
	}

    public function getByMobile($mobile) {
        $this->result_mode = 'object';
        $ret = $this->get('mobile', $mobile);
        return $ret;
    }

    public function mobileExists($mobile) {
        return isset($this->getByMobile($mobile)->id);
    }
}
