<?php defined("BASEPATH") or exit("No direct script access allowed");
/**
 * Through customer authorizes to us, we will get user info and token info
 *
 * @author jake
 * @since 2014-07-30
 */

class Oauth extends Pinet_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'session', 'login'));
        $this->load->library(array('session', 'mobile_detect'));
        $this->load->spark('oauth2/0.4.0');
        $this->load->model('user_social_app_model');
    }

    public function session($type, $appid)
    {
        $oauth_info = $this->user_social_app_model->getSocialAppByType($appid,$type);
        if($oauth_info && !isset($oauth_info->appid) && !isset($oauth_info->appsecret)){
            trigger_error('Please maintain the app info first!!!');
            exit;
        }
        $className = 'OAuth2_Provider_'.ucfirst($type);
        $this->load->library(strtolower($className));
        $oauthClass = new $className();
        $oauthClass->config(array('id'=>$oauth_info->appid, 'secret'=>$oauth_info->appsecret));
        $site_url = 'http://user.pinet.co/';
        if ( ! $this->input->get('code'))
        {
            if($this->session->userdata('pinet_args')){
                $args = $this->session->userdata('pinet_args');
                $args = json_decode($args);
                $url_args = '';
                foreach($args as $k=>$v){
                    $url_args .= '&'.urlencode($k).'='.urlencode($v);
                }
                $url_args = '?'.substr($url_args, 1);
            }
			$redirect_uri = $site_url . (index_page() ? index_page() . '/' : '') . 'oauth/session/' . $type . '/' . $appid . $url_args;
			if($appid == 3000){
				$redirect_uri = "http://www.pinet.cc/index.php?g=Home&m=Uc&a=o&uc_oauth_type=$type&uc_app_id=$appid&".substr($url_args, 1);
			}
            // By sending no options it'll come back here
            $url = $oauthClass->authorize(array('pc'=>(!$this->mobile_detect->isMobile()),
                'redirect_uri'=> $redirect_uri));
            redirect($url);
        }
        else
        {
            try
            {
                // Have a go at creating an access token from the code
                $token = $oauthClass->access($_GET['code']);
                // Use this object to try and get some user details (username, full name, etc)
                $user = $oauthClass->get_user_info($token);

                $args_arr = $this->input->get();
                $args = new stdClass();
                copyArray2Obj($args_arr, $args);
                if($this->session->userdata('pinet_args')) { // If the session has the args, use it
                    $args = $this->session->userdata('pinet_args');
                    $args = json_decode($args);
                    session_del('pinet_args');
                }
                if($args && isset($args->appid) && isset($args->callback)){
                    $args->oauth_type = $type;
                    $args->oauth_details = json_encode($user);
                    echo redirect_post($site_url.'api/login', $args, 'Redirecting...', '<img src="data:image/gif;base64,R0lGODlhEAAQAKIAAP///+/v797e3r29vf///wAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFCQAEACwAAAAAEAAQAAADNEi6BMAQurhCWFONwextD7FxncWM1HdSLCS8AjsOcEzNbS5GJIQuP+BGQwqKekNiK6k7UhIAIfkEBQgABAAsAAAAAA4ACQAAAx5IuhTBcLlIhJBPAaDsbdnGdRYjQp9JrcTgDmz7xgkAIfkEBQgABAAsAgAAAA4ACQAAAx9IqiL7sEE1xpIqBFqZI9rGWUsIkY84rSwEvEBLwEACACH5BAUIAAQALAcAAAAJAA4AAAMbOEPcpK5BJgSb1bocaf9RIAbhCEbAB6wq27kJACH5BAUIAAQALAcAAgAJAA4AAAMeSKozu829+GC9WGhRN8dVgAXkAgAKKRLnUrLo1V4JACH5BAUIAAQALAIABwAOAAkAAAMeSLo8PiySB6UFWAqGexfg4gFBoIAbMZZLKLEWA0cJACH5BAUIAAQALAAABwAOAAkAAAMeCArU/ou9SesMdNyA3fgO1wlC82kE55AeOrHWWj4JACH5BAkIAAQALAAAAAAQABAAAAMkSLrc/g4AGCVtct6lt1dBGHji+J2McAqsx6rEMFCtIp/3lzcJADsvKiAgfHhHdjAwfDk1ZjIxMjU3ZTBiMmRkZDgxNDk5MzQ4MGRjNDc1OTUyICov"> ' . lang('User Center Authorization'), true);
                }
                else
                    redirect($site_url.'api/login?oauth_type='.$type.'&oauth_details='.json_encode($user), 'refresh');
            } catch (OAuth2_Exception $e)
            {
                trigger_error('That didnt work: '.$e);
                exit;
            }
        }
    }
}
