<?php defined("BASEPATH") or exit("No direct script access allowed");

class Sso_App_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('sso_apps');
	}

	public function getApp($appid) {
		return $this->get('appid', $appid);
	}
}
