<?php defined("BASEPATH") or exit("No direct script access allowed");

class API extends Pinet_Controller {
    var $title = 'api';
    var $messages = 'api';

	public function __construct() {
		parent::__construct();
		$this->load->library(array('rule_manager', 'login_token', 'session'));
		$this->load->helper(array('login', 'cookie', 'session'));
	}

    /** @RunRule("test.rules") */
    public function test() {
        $this->clips->assertFacts(array(array("testa", "asdfasdgasdg")));
    }

	/** @RunRule("api/login.rules") */
	public function login() {
		// Add the login model to the rule context
		$this->load->model('login_model');

		$this->clips->template(array('Guess_Args', 'Login_User', 'Login_Device', 'OAuth_User'));
		$facts = array($this->login_model);
		foreach($this->login_model->getLoginArgs() as $k => $v) {
			$facts []= array('args', $k, $v);
		}
		$this->clips->assertFacts($facts);
	}

	public function logout() {
		$this->load->model('login_model');
		$this->login_model->logout();
        $parameter = $this->input->get();
        if($parameter && isset($parameter['callback'])){
			if(isset($parameter['ndr'])){
				redirect(site_url('/api/login?'.http_build_query($parameter)));
			}else{
				redirect($parameter['callback']);
			}
		}
        else
            redirect(site_url('/api/login?callback='.site_url('/welcome/test').'&appid=2000'));
	}

	public function login_success() {
		$args = get_login_args();

		if($this->session->userdata('pinet_args')) { // If the session has the args, use it
			$args = $this->session->userdata('pinet_args');
			$args = json_decode($args);
			session_del('pinet_args');
		}
		$token = session_get('pinet_token');
		$args->token = $token;
		$query = array();
		foreach($args as $k => $v) {
            if(!in_array($k, array('callback', 'oauth_details'))){
                $query []= $k.'='.$v;
            }
		}
		redirect($args->callback.'?'.implode('&', $query));
	}

	public function show_login() {
        $this->setLang('chinese');
		$login_args = get_login_args();
		if(!isset($login_args)) {
			show_error('Can\'t find any args for login.');
			return;
		}
		$this->load->widget(array('grid', 'image', 'link', 'login_form', 'oauth_qq', 'oauth_weibo', 'oauth_wechat', 'oauth_yixin'));
		       $data = array(
		            'logo' => 'signin-logo.png',
		            'company'=> lang('Waldorf Astoria')
		            );
		$this->sass_suffix = '-'.$login_args->template;
		$this->scss('login/'.$login_args->template);
		$this->sasscompiler->resolutions = array(180, 320, 400, 480, 640, 720, 800, 960, 1280, 1440, 1920);
		$this->render('login/'.$login_args->template, $data);
	}

	function register(){
		$this->scss('login/register');
		$this->load->widget(array('grid','bootstrap', 'jquery_ui_common', 'form', 'button','responsive','alert','datepicker'));
		$this->sasscompiler->resolutions = array(180, 320, 400, 480, 640, 720, 800, 960, 1280, 1440, 1920);
		$this->render('login/register', array('sexs'=>array('m'=>lang('Male'), 'f'=>lang('Female'))));
	}

	function index() {
		$this->scss('login/index');
		$this->load->widget(array('grid','bootstrap', 'jquery_ui_common', 'form', 'button','responsive','alert','datepicker'));
		$this->sasscompiler->resolutions = array(180, 320, 400, 480, 640, 720, 800, 960, 1280, 1440, 1920);
		$this->render('login/index');
	}


	function forget_password() {
		$this->scss('login/forget_password');
		 // $this->init_responsive();
   //   		   $this->jqBootstrapValidation();
		$this->load->widget(array('grid','bootstrap', 'jquery_ui_common', 'form', 'button','responsive','alert','datepicker'));
		$this->sasscompiler->resolutions = array(180, 320, 400, 480, 640, 720, 800, 960, 1280, 1440, 1920);
		$this->render('login/forget_password');
	}

    public function send_code(){
        $code = str_pad(rand(1,1000000),6,'1');
        $this->session->set_userdata('sms_code', $code);
        $mobile = $this->input->post('mobile');
        $result = json_decode(sms_send_randcode_nocompany($code, $mobile, 596805));
        if($result->code == 0){
            echo json_encode(array('success'=>true, 'msg'=>$code));
        }else{
            echo json_encode(array('success'=>false, 'msg'=>$result->msg));
        }
    }

	public function update_basic_info(){
		$result = array('error_code'=> -1, 'msg'=>'Invalid token');
		$token = $this->input->post('token');
		if(token_is_valid(urlencode($token))){
			$this->load->model('user_basic_info_model');
			$this->load->library('encryptor');
			$token = json_decode($this->encryptor->decrypt($token));
			$basic_info = $this->user_basic_info_model->getByUid($token->uid);
			if(isset($basic_info['id'])){
				$id = $basic_info['id'];
				$basic_info = array_merge($basic_info, $this->input->post());
				unset($basic_info['id']);
				$result = $this->user_basic_info_model->update($id, $basic_info);
			}else{
				$data = $this->input->post();
				$data['uid'] = $token->uid;
				$result = $this->user_basic_info_model->insert($data);
			}
			echo json_encode(array('success'=> $result));
		}else{
			echo json_encode($result);
		}
	}

	public function get_user_data(){
		$result = array('error_code'=> -1, 'msg'=>'Invalid token');
		$token = $this->input->get('token');
		if(token_is_valid(urlencode($token))){
			$this->load->model('user_basic_info_model');
			$this->load->library('encryptor');
			$token = json_decode($this->encryptor->decrypt($token));
			$basic_info = $this->user_basic_info_model->getByUid($token->uid);
			unset($basic_info['password']);
			echo json_encode($basic_info);
		}else{
			echo json_encode($result);
		}
	}
}
