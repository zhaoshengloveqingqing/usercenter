<?php defined("BASEPATH") or exit("No direct script access allowed");

class User_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('users');
	}

	public function createUser($type = 'register', $status = '') {
		$insert = array('create_type' => $type);
		if(func_num_args() > 2) {
			$arr = func_get_args();
			$insert['type'] = array_shift($arr); // Popout the type
			$insert['status'] = array_shift($arr); // Popout the status
			$insert['tag'] = json_encode($arr);
		}

		if(isset($status))
			$insert['status'] = $status;

        $uid = $this->insert($insert);

        if($type == 'mobile'){
            $this->myinsert('user_basic_infos', array('uid'=> $uid, 'mobile'=> func_get_args()[2]));
        }

		return $uid;
	}
}
