<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test_Data {

	public $models = array('user_model', 'login_model', 'sso_app_model', 'user_basic_info_model'
	, 'user_device_model', 'user_social_account_model');

	private $data =  array();

	public function __construct() { 
		$CI = &get_instance();
		$CI->load->model($this->models);
		$this->data['CI'] = $CI;
		$this->clear();
	}

	public function __get($property) {
		if(isset($this->$property))
			return $this->$property;
		if(isset($this->data[$property]))
			return $this->data[$property];
		if(isset($this->CI->$property))
			return $this->CI->$property;
		return false;
	}

	public function __set($property, $value) {
		$this->data[$property] = $value;
	}

	public function addDevice() {
		if(!$this->the_user_id)
			$this->addUser();
		$this->the_device_id = 
			$this->user_device_model->createDevice('06:18:d1:e5:bc:d1', $this->the_user_id);
		$this->the_device = $this->user_device_model->load($this->the_device_id);
	}

	public function addSocialAccount() {
		if(!$this->the_user_id)
			$this->addUser();
		$this->the_social_account_id = $this->user_social_account_model->insert(array(
			'uid' => $this->the_user_id,
			'social_id' => '1913508277',
			'type' => 'weibo'
		));
		$this->the_social_account = $this->user_social_account_model->load(
			$this->the_social_account_id);
	}

	public function addUser() {
		$this->the_user_id = $this->user_model->insert(array(
			'id' => 1000,
			'status' => ''
		));
		$this->the_user = $this->user_model->load($this->the_user_id);
	}

	public function addUserBasicInfo() {
		if(!$this->the_user_id)
			$this->addUser();
		$this->the_user_basic_info_id = $this->user_basic_info_model->insert(array(
			'id' => 1000,
			'uid' => $this->the_user_id,
			'username' => 'jack',
			'password' => hash_password('jack'),
			'mobile' => '123456'
		));
		$this->the_user_basic_info = $this->user_basic_info_model->load($this->the_user_basic_info_id);
	}

	public function addSsoApp() {
		if(!$this->the_user_id)
			$this->addUser();

		$this->the_sso_app_id = $this->sso_app_model->insert(array(
			'id' => 1000,
			'uid' => $this->the_user_id,
			'appid' => '32904098-E13A-4E83-AD7E-4987CDFE482D',
			'appsecret' => '123',
			'create_date' => time(),
			'config' => '{"test_config":1}'
		));
		$this->the_sso_app = $this->sso_app_model->load($this->the_sso_app_id);
	}

	public function clear() {
		foreach($this->models as $model) {
			if(method_exists($this->$model, 'clear'))
				$this->$model->clear();
		}
	}
}
