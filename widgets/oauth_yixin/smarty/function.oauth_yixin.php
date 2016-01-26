<?php defined('BASEPATH') or exit('No direct script access allowed');

function smarty_function_oauth_yixin($params, $template) {
    $label = lang('Yixin');
    $check = check_need_to_show('Yixin');
    switch($check){
        case 0:
            return '';
            break;
        case 2:
            $label = lang('Let Me Online');
            break;
    }
    $type = 'yixin';
    $CI = &get_instance();
    $CI->load->model(array('login_model', 'user_social_app_model'));
    $args = $CI->login_model->getLoginArgs();
    if(isset($args->appid))
    {
        $oauth_info = $CI->user_social_app_model->getSocialAppByType($args->appid,$type);
        if(isset($oauth_info->appid) && $oauth_info->appid){
            unset($params['uri']);
            return anchor(site_url('oauth/session/'.$type.'/'.$args->appid), $label, $params);
        }
    }
    return '';
}