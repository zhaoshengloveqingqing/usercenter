<?php defined('BASEPATH') or exit('No direct script access allowed');

function smarty_function_oauth_wechat($params, $template) {
    $label = lang('Wechat');
    $check = check_need_to_show('MicroMessenger');
    switch($check){
        case 0:
            return '';
            break;
        case 2:
            $label = lang('Let Me Online');
            break;
    }
    $type = 'wechat';
    $CI = &get_instance();
    $CI->load->model(array('login_model', 'user_social_app_model'));
    $args = $CI->login_model->getLoginArgs();
    if(isset($args->appid))
    {
        $oauth_info = $CI->user_social_app_model->getSocialAppByType($args->appid, $type);
        if(isset($oauth_info->appid) && $oauth_info->appid){
            unset($params['uri']);
			if($check == 1 && isset($args->serial) && isset($args->gateway_ip) && isset($args->gateway_port) && isset($args->ip) && isset($args->mac)){
				$CI->load->library('encryptor');
				$now = new DateTime();
				$expire = new DateTime();
				$expire->add(DateInterval::createFromDateString('5 minute'));
				$token = $CI->encryptor->encrypt(json_encode(array(
					'uid' => 'activate',
					'createDate' => $now->getTimestamp(),
					'expireDate' => $expire->getTimestamp())));
				return anchor('http://' . $args->gateway_ip . ':' . $args->gateway_port . '/pinet/auth?token=' .urlencode($token). '&url='. urlencode('http://www.pinet.co/auth/tip'), $label, $params);
			}
            return anchor(site_url('oauth/session/'.$type.'/'.$args->appid), $label, $params);
        }
    }
    return '';
}