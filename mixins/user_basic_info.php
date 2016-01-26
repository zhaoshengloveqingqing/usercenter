<?php defined("BASEPATH") or exit("No direct script access allowed");

class User_Basic_Info_Mixin extends Mixin {
	public function _propertyNames() {
		return array('username', 'password',
			'first_name', 'last_name', 'sex', 'mobile',
			'profile_image');
	}

	public function __get($key) {
		$obj = $this->user_basic_info_model->getByUid($this->getID());
		return $obj->$key;
	}

	public function apply($p, $v) {
		$this->user_basic_info_model->update($this->getID(), array($p => $v));
	}

	public function init() {
		parent::init();
		$this->model(array('user_basic_info_model'));
	}

}
