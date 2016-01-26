<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login_User {
	public $uid;
}

class Login_Device {
	public $id;
	public $mac;
	public $uid;
}

class OAuth_User {
	public $id;
	public $uid;
	public $type;
	public $oid;
	public $detail;
	public $nickname;
	public $profile_image;
}

class Guess_Args {
	public $mac;
	public $uid;
	public $oid;
	public $type;
	public $detail;
	public $mobile;

	public function __construct($args = null) {
		if(is_array($args)) {
			merge_objects($this, (object) $args);
		}
	}
}

class Login_Args {
	public function __construct($args = null) {
		if(is_array($args)) {
			merge_objects($this, (object) $args);
		}
	}
}

class Login_Model {
	public $uid;
	public $is_loggedin = false;
	public $token = null;

	public function __construct() {
		$CI = &get_instance();
		$CI->load->model('user_basic_info_model');
		$this->_info_model = $CI->user_basic_info_model;
	}

	public function testUsername($username) {
		return $this->_info_model->usernameExists($username);
	}

	public function testPassword($username, $password) {
		return $this->_info_model->testPassword($username, $password);
	}

	public function genToken($uid) {
		if($uid) {
			$CI = &get_instance();
			$CI->load->library('login_token');
			$token = new Login_Token();
			$token->uid = $uid;
			return $token->genToken();
		}
		return null;
	}

	public function usernameToToken($username) {
		$info = $this->_info_model->getByUsername($username);
		if(isset($info)) {
			return $this->genToken($info->uid);
		}
		return null;
	}

	public function guessUser($args) {
		$CI = &get_instance();

		$clips = $CI->clips;
		$clips->clear(); // Clear first
		$clips->template(array('Guess_Args', 'Login_User', 'Login_Device', 'OAuth_User'));
		if(is_object($args) && get_class($args) == 'Guess_Args') {
			$guess_args = $args;
		}
		else {
			$guess_args = new Guess_Args($args);
		}

		$facts = array($guess_args);

		if(isset($guess_args->detail)) {
			$obj = json_decode($guess_args->detail);
			if($obj && (is_object($obj) || is_array($obj))) {
				foreach($obj as $k => $v) {
					$facts []= array('detail', $k, $v);
				}
			}
			$guess_args->detail = base64_encode($guess_args->detail);
		}
		$clips->load('application/config/rules/api/guess.rules');
		$clips->assertFacts($facts);
		$clips->run();
		return $clips->queryFacts('Login_User');
	}

	public function logout() {
		session_del('pinet_token');
		session_del('pinet_args');
		session_del('pinet_callback');
		session_del('mobile');
		session_del('validation_code');
		$CI = &get_instance();
		if(!$CI->input->is_cli_request()) // Skip the breadscrum for cli request
			delete_cookie('pinet_token');
	}

	public function getLoginArgs() {
		$CI = &get_instance();
		$CI->load->model('sso_app_model'); // Load sso apps model by default

		if($CI->input->get()) {
			$args = new Login_Args($CI->input->get());
		}
		else {
			$args = new Login_Args($CI->input->post());
		}

		$CI->load->library('session');

		if(isset($args->appid)) {
			$app = $CI->sso_app_model->getApp($args->appid);

			if(isset($app->config)) { // Merge the configurations to the app object first
				$app = merge_objects($app, (object)json_decode($app->config));
				unset($app->config);
			}

			$args = merge_objects($args, $app);
		}
		return $args;
	}
}
