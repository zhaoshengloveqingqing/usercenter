<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Oauth2 SocialAuth for CodeIgniter
 * Weixin OAuth2 Provider
 *
 * @category   Provider
 * @author     Jake
 * @since 2014-08-04
 */
class OAuth2_Provider_Wechat extends Oauth2_Provider {

    public $name = 'wechat';

    public $uid_key = 'openid';

    protected $scope = 'snsapi_userinfo';//'snsapi_login';

    public $method = 'POST';

    public function __construct()
    {
    }

    public function scope_min()
    {
        $this->scope = 'snsapi_base';
    }
    public function url_authorize()
    {
        return OAUTH_WECHAT_AUTHORIZE_URL;
    }

    public function url_access_token()
    {
        return OAUTH_WECHAT_ACCESS_TOKEN_URL;
    }

    public function get_user_info(OAuth2_Token_Access $token)
    {
        $lang = 'en';
        if(get_lang() == 'chinese'){
            $lang = 'zh_CN';
        }
        $url = OAUTH_WECHAT_USER_INFO_URL.'?'.http_build_query(array(
                'access_token' => $token->access_token,
                'openid' => $token->uid,
                'lang' => $lang
            ));
        $user = json_decode(@file_get_contents($url));
        if (array_key_exists("errcode", $user)) {
            throw new OAuth2_Exception((array) $user);
        }

        return $user;
    }

    public function config(array $options = array()){
        if ( ! $this->name)
        {
            // Attempt to guess the name from the class name
            $this->name = strtolower(substr(get_class($this), strlen('OAuth2_Provider_')));
        }

        if (empty($options['id']))
        {
            throw new Exception('Required option not provided: id');
        }

        $this->client_id = $options['id'];

        isset($options['callback']) and $this->callback = $options['callback'];
        isset($options['secret']) and $this->client_secret = $options['secret'];
        isset($options['scope']) and $this->scope = $options['scope'];

        $this->redirect_uri = site_url(get_instance()->uri->uri_string());
    }

    /*
	* Get an authorization code from Facebook.  Redirects to Facebook, which this redirects back to the app using the redirect address you've set.
	*/
    public function authorize($options = array())
    {
        $state = md5(uniqid(rand(), TRUE));
        get_instance()->session->set_userdata('state', $state);

        $params = array(
            'appid' 		=> $this->client_id,
            'redirect_uri' 		=> isset($options['redirect_uri']) ? $options['redirect_uri'] : $this->redirect_uri,
            'response_type' 	=> 'code',
            'scope'				=> is_array($this->scope) ? implode($this->scope_seperator, $this->scope) : $this->scope,
            'state' 			=> $state
        );

        return $this->url_authorize().'?'.http_build_query($params).'#wechat_redirect';
    }

    /*
	* Get access to the API
	*
	* @param	string	The access code
	* @return	object	Success or failure along with the response details
	*/
    public function access($code, $options = array())
    {
        $params = array(
            'appid' 	=> $this->client_id,
            'secret' => $this->client_secret,
            'grant_type' 	=> isset($options['grant_type']) ? $options['grant_type'] : 'authorization_code',
        );

        switch ($params['grant_type'])
        {
            case 'authorization_code':
                $params['code'] = $code;
                $params['redirect_uri'] = isset($options['redirect_uri']) ? $options['redirect_uri'] : $this->redirect_uri;
                break;

            case 'refresh_token':
                $params['refresh_token'] = $code;
                break;
        }

        $response = null;
        $url = $this->url_access_token();

        switch ($this->method)
        {
            case 'GET':

                // Need to switch to Request library, but need to test it on one that works
                $url .= '?'.http_build_query($params);
                $response = @file_get_contents($url);

                $return = $this->parse_response($response);

                break;

            case 'POST':

                $postdata = http_build_query($params);
                $opts = array(
                    'http' => array(
                        'method'  => 'POST',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $postdata
                    )
                );
                $context  = @stream_context_create($opts);
                $response = @file_get_contents($url, false, $context);

                $return = $this->parse_response($response);

                break;

            default:
                throw new OutOfBoundsException("Method '{$this->method}' must be either GET or POST");
        }

        if ( ! empty($return['error']))
        {
            throw new OAuth2_Exception($return);
        }

        return OAuth2_Token::factory('access', $return);
    }

    /**
     * For each response to each response type for using
     *
     * @param string $response
     * @author jake
     * @since 2014-07-30
     * @return response with string | object
     */
    protected function parse_response($response = '')
    {
        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $return = json_decode($response, true);
        }
        elseif (strpos($response, "&") !== false)
        {
            parse_str($response, $return);
            if(isset($return['openid']))
                $return['uid'] = $return['openid'];
        }
        else
        {
            $return = json_decode($response, true);
            if(isset($return['openid']))
                $return['uid'] = $return['openid'];
        }
        return $return;
    }

    public function follow($info){
        return TRUE;
    }

    public function message($info){
        return TRUE;
    }

    public function check_in($info){
        return TRUE;
    }
}