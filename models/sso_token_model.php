<?php defined("BASEPATH") or exit("No direct script access allowed");

class Sso_Token_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('sso_tokens');
	}
}
