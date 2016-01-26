<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_FakeData extends MY_Migration {
	private $the_user_id = 2000;
	private $the_basic_info_id = 2000;
    private $the_sso_app_id = 2000;

	public function __construct() {
		parent::__construct();
		$this->helper(array('common', 'login'));
		$this->model(array('user_model', 'user_basic_info_model', 'sso_app_model', 'user_social_app_model'));
	}

	private function addFakeUsers() {
		$this->user_model->insert(array(
			'id' => $this->the_user_id,
			'status' => ''
		));
		$this->user_basic_info_model->insert(array(
			'id' => $this->the_basic_info_id,
			'uid' => $this->the_user_id,
			'username' => 'jack',
			'password' => hash_password('jack')
		));
	}

    private function addFakeApps(){
        $this->sso_app_model->insert(array(
            'id' => $this->the_sso_app_id,
            'uid' => $this->the_user_id,
            'appid' => $this->the_user_id,
            'appsecret' => $this->the_user_id,
            'template' => 'default'
        ));
        $this->user_social_app_model->insert(array(
            'uid' => $this->the_user_id,
            'type' => 'qq',
            'appid' => '100569850',
            'appsecret' => '777a5420d7e90a13d49dbe3648aaab35'
        ));
        $this->user_social_app_model->insert(array(
            'uid' => $this->the_user_id,
            'type' => 'weibo',
            'appid' => '3275164829',
            'appsecret' => '69e1fae42120dba5238053aa265ed6e5'
        ));
        $this->user_social_app_model->insert(array(
            'uid' => $this->the_user_id,
            'type' => 'wechat',
            'appid' => 'wxf0c1d6198e106e87',
            'appsecret' => '9dd7eb477d67407a50f815e0fdcf06df'
        ));
        $this->user_social_app_model->insert(array(
            'uid' => $this->the_user_id,
            'type' => 'yixin',
            'appid' => '5629b8722819497cb857b1e196cb0708',
            'appsecret' => 'f7bb800175564f57b4d88e7e8c4afb7b'
        ));
    }

	public function up() {
        $this->down();
		$this->addFakeUsers();
        $this->addFakeApps();
	}

	public function down() {
		$this->user_model->delete('id', $this->the_user_id);
		$this->user_basic_info_model->delete('id', $this->the_basic_info_id);
		$this->sso_app_model->delete('id', $this->the_sso_app_id);
		$this->user_social_app_model->delete('uid', $this->the_user_id);
	}
}
