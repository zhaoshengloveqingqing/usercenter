<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/**
 * define all kinds of categories URL
 */
//QQ
define('OAUTH_QQ_AUTHORIZE_URL','https://graph.qq.com/oauth2.0/authorize');
define('OAUTH_QQ_ACCESS_TOKEN_URL','https://graph.qq.com/oauth2.0/token');
define('OAUTH_QQ_USER_ME_URL','https://graph.qq.com/oauth2.0/me');
define('OAUTH_QQ_USER_INFO_URL','https://graph.qq.com/user/get_user_info');
define('OAUTH_QQ_FOLLOW','https://graph.qq.com/relation/add_idol');
define('OAUTH_QQ_TWEET','https://graph.qq.com/t/add_t');
define('OAUTH_QQ_TWEET_IMG','https://graph.qq.com/t/add_pic_t');
//WECHAT
define('OAUTH_WECHAT_AUTHORIZE_URL','https://open.weixin.qq.com/connect/oauth2/authorize');
define('OAUTH_WECHAT_ACCESS_TOKEN_URL','https://api.weixin.qq.com/sns/oauth2/access_token');
define('OAUTH_WECHAT_USER_INFO_URL','https://api.weixin.qq.com/sns/userinfo');
//WEIBO
define('OAUTH_WEIBO_AUTHORIZE_URL','https://api.weibo.com/oauth2/authorize');
define('OAUTH_WEIBO_ACCESS_TOKEN_URL','https://api.weibo.com/oauth2/access_token');
define('OAUTH_WEIBO_USER_INFO_URL','https://api.weibo.com/2/users/show.json');
define('OAUTH_WEIBO_FOLLOW','https://api.weibo.com/2/friendships/create.json');
define('OAUTH_WEIBO_TWEET','https://api.weibo.com/2/statuses/update.json');
define('OAUTH_WEIBO_TWEET_IMG','https://upload.api.weibo.com/2/statuses/upload.json');
define('OAUTH_WEIBO_CHECKIN','https://api.weibo.com/2/place/pois/add_checkin.json');
define('OAUTH_WEIBO_POI','https://api.weibo.com/2/place/pois/search.json');
//YIXIN
define('OAUTH_YIXIN_AUTHORIZE_URL','http://open.plus.yixin.im/connect/oauth2/authorize');
define('OAUTH_YIXIN_ACCESS_TOKEN_URL','https://api.yixin.im/sns/oauth2/access_token');
define('OAUTH_YIXIN_USER_INFO_URL','https://api.yixin.im/sns/userinfo');

//Navigations
define('MAIN_NAVIGATION', 'main_navigation');
define('SECURITY_ALLOW', 'allow');
/* End of file constants.php */
/* Location: ./application/config/constants.php */
