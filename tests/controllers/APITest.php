<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once(FCPATH.APPPATH.'controllers/api.php');

class APITest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->library(array('login_token', 'session', 'test_data'));
		$this->helper(array('login', 'cookie', 'session'));
		$this->model(array('login_model', 'user_basic_info_model'));
		$this->clips = $this->CI->clips;
	}

	public function testShowLoginPage() {
		$this->clips->clear();
		$this->test_data->addUserBasicInfo();
		$this->test_data->addSsoApp();

		$_GET['appid'] = 1;
		$_GET['callback'] = 'abc';
		$_GET['appid'] = $this->test_data->the_sso_app->appid;

		$this->model('login_model');

		$facts = array($this->login_model);
		foreach($this->login_model->getLoginArgs() as $k => $v) {
			$facts []= array('args', $k, $v);
		}
		$this->clips->assertFacts($facts);
	}

	private function login() {
		$this->clips->clear();
		$facts = array($this->login_model);
		$this->clips->template(array('Guess_Args', 'Login_User', 'Login_Device', 'OAuth_User'));

		foreach($this->login_model->getLoginArgs() as $k => $v) {
			if($k == 'oauth_details') {
				$details = $v;
				if(isset($details) && is_string($details)) {
					$obj = json_decode($details);
					if($obj && (is_object($obj) || is_array($obj))) {
						foreach($obj as $k => $v) {
							$facts []= array('detail', $k, $v);
						}
					}
				}
				$facts []= array('detail', 'details', base64_encode($details));
			}
			else 
				$facts []= array('args', $k, $v);
		}

		$this->clips->assertFacts($facts);

		// Load the login rules
		$this->clips->load('application/config/rules/api/login.rules');
		// Let's do the login test
		$this->clips->agenda();
		$this->clips->run();
	}

	public function testLoginUsingUsername() {
		$this->clips->clear();
		$this->test_data->addUserBasicInfo();

		$_GET['callback'] = 'abc';
		$_GET['username'] = $this->test_data->the_user_basic_info->username;
		$_GET['password'] = 'jack';
		$_GET['appid'] = 2;
		
		$this->login();
	}

	public function testLoginUsingOAuthCreate() {
		$_GET['callback'] = 'abc';
		$_GET['appid'] = 1;
		$_GET['oauth_type'] = 'weibo';
		$_GET['oauth_details'] = '{"id":1913508277,"idstr":"1913508277","class":1,"screen_name":"Jake__Xu","name":"Jake__Xu","province":"32","city":"5","location":"\u6c5f\u82cf \u82cf\u5dde","description":"xiaomiwozhidao.taobao.com\u6c5f\u5357\u4e00\u54c1\u7ee3\uff0c\u7ed9\u60a8365\u5929\u7684\u5475\u62a4\uff01\uff01\uff01","url":"","profile_image_url":"http:\/\/tp2.sinaimg.cn\/1913508277\/50\/40049596204\/1","profile_url":"u\/1913508277","domain":"","weihao":"","gender":"m","followers_count":74,"friends_count":1733,"pagefriends_count":0,"statuses_count":518,"favourites_count":0,"created_at":"Sat Oct 08 11:18:50 +0800 2011","following":false,"allow_all_act_msg":false,"geo_enabled":true,"verified":false,"verified_type":-1,"remark":"","status":{"created_at":"Thu Aug 28 08:46:29 +0800 2014","id":3748463437402119,"mid":"3748463437402119","idstr":"3748463437402119","text":"\u4f60\u597d \u6d3e\u5c14","source_type":1,"source":"\u672a\u901a\u8fc7\u5ba1\u6838\u5e94\u7528<\/a>","favorited":false,"truncated":false,"in_reply_to_status_id":"","in_reply_to_user_id":"","in_reply_to_screen_name":"","pic_urls":[{"thumbnail_pic":"http:\/\/ww2.sinaimg.cn\/thumbnail\/720dd1b5jw1ejs26v0zr6j20hs0a0glt.jpg"}],"thumbnail_pic":"http:\/\/ww2.sinaimg.cn\/thumbnail\/720dd1b5jw1ejs26v0zr6j20hs0a0glt.jpg","bmiddle_pic":"http:\/\/ww2.sinaimg.cn\/bmiddle\/720dd1b5jw1ejs26v0zr6j20hs0a0glt.jpg","original_pic":"http:\/\/ww2.sinaimg.cn\/large\/720dd1b5jw1ejs26v0zr6j20hs0a0glt.jpg","geo":null,"annotations":[{"place":{"poiid":"B2094650D164A6FC4899","lon":"120.72925","title":"\u661f\u6e56\u8857\u82e5\u6c34\u8def","public":1,"type":"checkin","lat":"31.25405"}}],"reposts_count":0,"comments_count":0,"attitudes_count":0,"mlevel":0,"visible":{"type":0,"list_id":0},"darwin_tags":[]},"ptype":0,"allow_all_comment":true,"avatar_large":"http:\/\/tp2.sinaimg.cn\/1913508277\/180\/40049596204\/1","avatar_hd":"http:\/\/ww1.sinaimg.cn\/crop.73.0.402.402.1024\/720dd1b5gw1eegrk1cdqhj20im0dygp5.jpg","verified_reason":"","verified_trade":"","verified_reason_url":"","verified_source":"","verified_source_url":"","follow_me":false,"online_status":0,"bi_followers_count":3,"lang":"zh-cn","star":0,"mbtype":0,"mbrank":0,"block_word":0,"block_app":0,"credit_score":80,"urank":10}';

		$this->login();
		$this->model('user_model');
	}

	public function testLoginUsingOAuth() {
		$this->test_data->addSocialAccount();

		$_GET['callback'] = 'abc';
		$_GET['appid'] = 1;
		$_GET['oauth_type'] = 'weibo';
		$_GET['oauth_details'] = '{"id":1913508277,"idstr":"1913508277","class":1,"screen_name":"Jake__Xu","name":"Jake__Xu","province":"32","city":"5","location":"\u6c5f\u82cf \u82cf\u5dde","description":"xiaomiwozhidao.taobao.com\u6c5f\u5357\u4e00\u54c1\u7ee3\uff0c\u7ed9\u60a8365\u5929\u7684\u5475\u62a4\uff01\uff01\uff01","url":"","profile_image_url":"http:\/\/tp2.sinaimg.cn\/1913508277\/50\/40049596204\/1","profile_url":"u\/1913508277","domain":"","weihao":"","gender":"m","followers_count":74,"friends_count":1733,"pagefriends_count":0,"statuses_count":518,"favourites_count":0,"created_at":"Sat Oct 08 11:18:50 +0800 2011","following":false,"allow_all_act_msg":false,"geo_enabled":true,"verified":false,"verified_type":-1,"remark":"","status":{"created_at":"Thu Aug 28 08:46:29 +0800 2014","id":3748463437402119,"mid":"3748463437402119","idstr":"3748463437402119","text":"\u4f60\u597d \u6d3e\u5c14","source_type":1,"source":"\u672a\u901a\u8fc7\u5ba1\u6838\u5e94\u7528<\/a>","favorited":false,"truncated":false,"in_reply_to_status_id":"","in_reply_to_user_id":"","in_reply_to_screen_name":"","pic_urls":[{"thumbnail_pic":"http:\/\/ww2.sinaimg.cn\/thumbnail\/720dd1b5jw1ejs26v0zr6j20hs0a0glt.jpg"}],"thumbnail_pic":"http:\/\/ww2.sinaimg.cn\/thumbnail\/720dd1b5jw1ejs26v0zr6j20hs0a0glt.jpg","bmiddle_pic":"http:\/\/ww2.sinaimg.cn\/bmiddle\/720dd1b5jw1ejs26v0zr6j20hs0a0glt.jpg","original_pic":"http:\/\/ww2.sinaimg.cn\/large\/720dd1b5jw1ejs26v0zr6j20hs0a0glt.jpg","geo":null,"annotations":[{"place":{"poiid":"B2094650D164A6FC4899","lon":"120.72925","title":"\u661f\u6e56\u8857\u82e5\u6c34\u8def","public":1,"type":"checkin","lat":"31.25405"}}],"reposts_count":0,"comments_count":0,"attitudes_count":0,"mlevel":0,"visible":{"type":0,"list_id":0},"darwin_tags":[]},"ptype":0,"allow_all_comment":true,"avatar_large":"http:\/\/tp2.sinaimg.cn\/1913508277\/180\/40049596204\/1","avatar_hd":"http:\/\/ww1.sinaimg.cn\/crop.73.0.402.402.1024\/720dd1b5gw1eegrk1cdqhj20im0dygp5.jpg","verified_reason":"","verified_trade":"","verified_reason_url":"","verified_source":"","verified_source_url":"","follow_me":false,"online_status":0,"bi_followers_count":3,"lang":"zh-cn","star":0,"mbtype":0,"mbrank":0,"block_word":0,"block_app":0,"credit_score":80,"urank":10}';

		$this->login();
	}

    public function testLoginUsingSMS() {
        $this->clips->clear();
        $this->test_data->addUserBasicInfo();

        $_GET['callback'] = 'abc';
        $_GET['mobile'] = '123456';
        $this->session->set_userdata('mobile', '123456');
        $_GET['validation_code'] = 'jack';
        $_GET['appid'] = -1;

        $this->login();
        $this->assertEquals(count($this->user_basic_info_model->get_all()), 1);
    }

	public function doTearDown() {
		$this->test_data->clear();
		$this->login_model->logout();
	}
}
