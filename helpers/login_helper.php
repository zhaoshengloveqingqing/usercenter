<?php defined('BASEPATH') or exit('No direct script access allowed');

function hash_password($pass) {
	return md5($pass);
}

function password_is_valid($username, $password) {
	if($username && $password) {
		$CI = &get_instance();
		$CI->load->model('login_model');
		return $CI->login_model->testPassword($username, $password);
	}
}

function gen_token($uid) {
	if($uid) {
		$CI = &get_instance();
		$CI->load->model('login_model');
		return $CI->login_model->genToken($uid);
	}
	return null;
}

function username_to_uid($username) {
	if($username) {
		$CI = &get_instance();
		$CI->load->model('user_basic_info_model');
		$result = $CI->user_basic_info_model->getByUsername($username);
		if(isset($result->id))
			return $result->id;
	}
	return null;
}

function get_appid() {
    $CI = &get_instance();
    $appid = $CI->input->get('appid');

    ci_log('The appid is %s', $appid);
    if(isset($CI->session)) {
        $args = $CI->session->userdata('pinet_args');
        if(isset($args)) {
            $args = json_decode($args);
            ci_log('The args for appid is', $args);

            return $args->appid;
        }
    }
    return $appid;
}

function username_to_token($username) {
	if($username) {
		$CI = &get_instance();
		$CI->load->model('login_model');
		return $CI->login_model->usernameToToken($username);
	}
	return null;
}

function get_login_args() {
	$CI = &get_instance();
	if(isset($CI->clips)) {
		$login_args = (object)array_reduce($CI->clips->queryFacts('args'), 
		function($carry, $item){
			$carry[$item[0]] = $item[1];
			return $carry;
		}, array());
		return $login_args;
	}
	return null;
}

function store_login_args() {
	$CI = &get_instance();
	$CI->load->library('session');
	ci_log('The args to be stored is ', get_login_args());
    $CI->session->set_userdata('pinet_args', json_encode(get_login_args()));
}

function username_is_valid($username) {
	if($username) {
		$CI = &get_instance();
		$CI->load->model('login_model');
		return $CI->login_model->testUsername($username);
	}
	return false;
}

function store_token($uid, $appid, $token) {
	$CI = &get_instance();
	$CI->load->model('sso_token_model');
	return $CI->sso_token_model->insert(array(
		'uid' => $uid,
		'appid' => $appid,
		'token' => urldecode($token)
	));
}

function login_redirect($uri, $token) {
	$CI = &get_instance();
	if($CI->input->is_cli_request())
		return false;
	redirect(site_url('/api/login_success'));
}

function process_details($details) {
	$CI = &get_instance();
	if(isset($CI->clips)) {
		$facts = array();
		if(isset($details) && is_string($details)) {
			$obj = json_decode($details);
			if($obj && (is_object($obj) || is_array($obj))) {
				foreach($obj as $k => $v) {
					$facts []= array('detail', $k, $v);
				}
			}
		}
		$facts []= array('detail', 'details', base64_encode($details));
		$CI->clips->assertFacts($facts);
	}
}

function token_is_valid($token) {
	if($token) {
		$CI = &get_instance();
		$CI->load->library('login_token');
		$CI->login_token->setToken($token);
		return $CI->login_token->isValid();
	}
	return false;
}

function get_device_id($mac) {
	if($mac) {
		$CI = &get_instance();
		$CI->load->model('user_device_model');
		return get_default($CI->user_device_model->getDeviceByMac($mac), "id", null);
	}
	return null;
}

function create_user() {
	$CI = &get_instance();
	$CI->load->model('user_model');
	$ret = call_user_func_array(array($CI->user_model, 'createUser'), func_get_args());
	return $ret;
}

function create_device($mac) {
	if($mac) {
		$CI = &get_instance();
		$CI->load->model('user_device_model');
		return $CI->user_device_model->createDevice($mac);
	}
	return null;
}

function get_device_uid($mac) {
	if($mac) {
		$CI = &get_instance();
		$CI->load->model('user_device_model');
		$ret = get_default($CI->user_device_model->getDeviceByMac($mac), "uid", null);
		if($ret != 0)
			return $ret;
	}
	return null;
}

function device_exists($mac) {
	if($mac) {
		$CI = &get_instance();
		$CI->load->model('user_device_model');
		return $CI->user_device_model->deviceExists($mac);
	}
	return false;
}

function get_uid_by_mobile($mobile) {
    if($mobile) {
        $CI = &get_instance();
        $CI->load->model('user_basic_info_model');
        $ret = get_default($CI->user_basic_info_model->getByMobile($mobile), "uid", null);
        if($ret != 0)
            return $ret;
    }
    return null;
}

function mobile_exists($mobile) {
    if($mobile) {
        $CI = &get_instance();
        $CI->load->model('user_basic_info_model');
        return $CI->user_basic_info_model->mobileExists($mobile);
    }
    return false;
}

function get_oauth_account_id($oid) {
	if($oid) {
		$CI = &get_instance();
		$CI->load->model('user_social_account_model');
		return get_default($CI->user_social_account_model->getByOid($oid), 'id', null);
	}
	return null;
}

function create_oauth_account($user) {
	if($user) {
		$CI = &get_instance();
		$CI->load->model('user_social_account_model');
		return $CI->user_social_account_model->createAccount($user);
	}
	return null;
}

function update_device_owner($id, $uid) {
    if($id && $uid){
        $CI = &get_instance();
        $CI->load->model('user_device_model');
        $CI->user_device_model->assignOwner($id, $uid);
    }
}

function update_oauth_account_owner($id, $uid){
    if($id && $uid){
        $CI = &get_instance();
        $CI->load->model('user_social_account_model');
        $CI->user_social_account_model->assignOwner($id, $uid);
    }
}

function get_oauth_account_uid($oid) {
	if($oid) {
		$CI = &get_instance();
		$CI->load->model('user_social_account_model');
		$obj = $CI->user_social_account_model->getByOid($oid);
		if(isset($obj->uid) && $obj->uid != 0)
			return $obj->uid;
	}
	return null;
}

function get_groups($token) {
	return array('admin');
}

function oauth_account_exists($oid) {
	if($oid) {
		$CI = &get_instance();
		$CI->load->model('user_social_account_model');
		return $CI->user_social_account_model->accountExists($oid);
	}
	return false;
}
