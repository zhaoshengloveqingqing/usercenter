<?php defined("BASEPATH") or exit("No direct script access allowed");

class User_Social_Account_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('user_social_accounts');
	}

	public function getByOid($oid) {
		$this->result_mode = 'object';
		return $this->get('social_id', $oid);
	}

	public function createAccount($user = null) {
		if($user) {
			$user->social_id = $user->oid;
			unset($user->oid);
			if(isset($user->detail))
				$user->detail = base64_decode($user->detail);
			return $this->insert((array) $user);
		}
		return -1;
	}

	public function accountExists($oid) {
		return isset($this->getByOid($oid)->id);
	}

    public function assignOwner($id, $uid){
        return $this->update($id, array('uid'=>$uid));
    }

    public function getAccountByUid($uid){
        $this->result_mode = 'object';
        return $this->get('uid', $uid);
    }
}
