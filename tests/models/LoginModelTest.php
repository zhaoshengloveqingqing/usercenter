<?php defined('BASEPATH') or exit('No direct script access allowed');

class LoginModelTest extends Pinet_PHPUnit_Framework_TestCase {
	public function doSetUp() {
		$this->library(array('test_data'));
		$this->clips = $this->CI->clips;
		$this->clips->clear();
		$this->model(array('login_model', 'user_device_model', 'user_social_account_model'));
		$this->test_data->addSsoApp();
		$this->test_data->addUserBasicInfo();
	}

	public function doTearDown() {
		$this->test_data->clear();
	}

	public function testGetLoginArgs() {
		$this->assertNotNull($this->test_data->the_sso_app);
		$_GET['appid'] = $this->test_data->the_sso_app->appid;
		$obj = $this->login_model->getLoginArgs();
		$this->assertEquals($obj->appid, $_GET['appid']);
		$this->assertEquals($obj->uid, $this->test_data->the_user_id);
		$this->assertEquals($obj->id, $this->test_data->the_sso_app->id);
	}

	public function testUsernameToToken() {
		$this->library('login_token');
		$token = $this->login_model->usernameToToken($this->test_data
			->the_user_basic_info->username);
		$t = new Login_Token($token);
		print_r($t);
		$this->assertEquals($t->uid, $this->test_data->the_user_basic_info->uid);
	}

	public function testCreateDevice() {
		$this->login_model->guessUser(array('mac' => '06:18:d1:e5:bc:d1'));
		$this->assertEquals(count($this->clips->queryFacts('Login_Device')), 1);
		$this->assertEquals(count($this->user_device_model->count_all()), 1);
		$device = $this->clips->queryFacts('Login_Device');
		$device = $device[0];
		$this->assertTrue(isset($device->id));
		$device = $this->user_device_model->load($device->id);
		$this->assertTrue(isset($device->id));
	}

	public function testCreateSnsAccount() {
		$ret = $this->login_model->guessUser(array('oid' => '12345', 'type' => 'qq', 'detail' => '{"screen_name":"Jack","idstr":"123456","hello":"world"}'));
		$this->assertEquals(count($this->clips->queryFacts('OAuth_User')), 1);
		$this->assertEquals(count($this->user_social_account_model->count_all()), 1);
		$account = $this->clips->queryFacts('OAuth_User');
		$account = $account[0];
		$this->assertTrue(isset($account->id));
		$account = $this->user_social_account_model->load($account->id);
		$this->assertEquals($account->nickname, 'Jack');
		$this->assertTrue(isset($account->id));
		print_r($ret);
		$this->assertEquals(count($ret), 0);
	}

	public function testFindAndCreateSnsAccount() {
		$this->test_data->addDevice();
		$ret = $this->login_model->guessUser(array('mac' => $this->test_data->the_device->mac, 'oid' => '12345', 'type' => 'qq', 'detail' => '{"screen_name":"Jack","idstr":"123456","hello":"world"}'));
		$this->assertEquals(count($this->clips->queryFacts('OAuth_User')), 1);
		$this->assertEquals(count($this->user_social_account_model->count_all()), 1);
		$account = $this->clips->queryFacts('OAuth_User');
		$account = $account[0];
		$this->assertTrue(isset($account->id));
		$account = $this->user_social_account_model->load($account->id);
		$this->assertEquals($account->nickname, 'Jack');
		$this->assertTrue(isset($account->id));
		$this->assertEquals($account->uid, $this->test_data->the_user_id);
		$this->assertEquals(count($ret), 1);
		$ret = $ret[0];
		$this->assertTrue(isset($ret->uid));
		$this->assertEquals($ret->uid, $this->test_data->the_user_id);
	}

	public function testGetLoginUserByDevice() {
		$this->test_data->addDevice();
		$this->login_model->guessUser(array('mac' => $this->test_data->the_device->mac));
		$this->assertEquals(count($this->clips->queryFacts('Login_Device')), 1);
		$this->assertEquals(count($this->user_device_model->count_all()), 1);
		$device = $this->clips->queryFacts('Login_Device');
		$device = $device[0];
		$this->assertTrue(isset($device->id));
		$device = $this->user_device_model->load($device->id);
		$this->assertTrue(isset($device->id));
		$this->assertEquals(count($this->clips->queryFacts('Login_User')), 1);
	}

    public function testAssignOwner2Device(){
        $this->login_model->guessUser(array('uid' => $this->test_data->the_user_id,
            'mac' => '06:18:d1:e5:bc:d1'));
        $device = $this->user_device_model->getDeviceByUid($this->test_data->the_user_id);
        $this->assertTrue($device->uid == $this->test_data->the_user_id);
    }

    public function testAssignOwner2Account(){
        $this->login_model->guessUser(array('uid' => $this->test_data->the_user_id,
            'oid' => '12345', 'type' => 'qq', 'detail' => '{"nickname":"Jack","idstr":"123456"}'));
        $account = $this->user_social_account_model->getAccountByUid($this->test_data->the_user_id);
        $this->assertTrue($account->uid == $this->test_data->the_user_id);
    }
}
