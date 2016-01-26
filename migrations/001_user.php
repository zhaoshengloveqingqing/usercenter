<?php defined("BASEPATH") or exit("No direct script access allowed");

class Migration_User extends MY_Migration {
	/**
	 * The users table is just used for relation queries
	 */
	private function addUsers() {
		$this->add_table('users',
			array(
				'status' => $this->varchar(16, false, true, 'registered'),
				'create_type' => $this->varchar(16),
				'create_date' => $this->datetime(),
				'tag' => $this->text(),
				'modify_date' => $this->datetime()
			),
			array('status', 'create_date', 'modify_date')
		);
	}

	private function addUserBasicInfos() {
		$this->add_table('user_basic_infos',
			array(
				'uid' => $this->int(),
				'username' => $this->varchar(20, true),
				'password' =>$this->varchar(50),
				'email' =>$this->varchar(100),
				'first_name' => $this->varchar(20),
				'last_name' => $this->varchar(20),
				'sex' => $this->varchar(1,false,false,'n'),
				'mobile' => $this->varchar(128),
				'profile_image' => $this->varchar(1024),
				'create_date' => $this->datetime(),
				'modify_date' => $this->datetime()
			),
			array('uid', 'mobile', 'sex', 'create_date', 'modify_date')
		);
	}

	private function addUserContactInfos() {
		$this->add_table('user_contact_infos',
			array(
				'uid' => $this->int(),
				'country' => $this->varchar(10),
				'province' => $this->varchar(10),
				'city' => $this->varchar(30),
				'street' => $this->varchar(300),					
				'postcode' => $this->varchar(6),
				'create_date' => $this->datetime(),
				'modify_date' => $this->datetime()
			),
			array('uid', 'create_date', 'modify_date')
		);
	}

	private function addGroups(){
		$this->add_table(
			'groups',
			array(
				'name' =>$this->varchar(50,true),
				'note' =>$this->varchar(1024),
				'create_date' => $this->datetime(),
				'modify_date' => $this->datetime()
			),
			array('name', 'create_date', 'modify_date')
		);		
	}

	private function addGroupsUsers(){
		$this->add_table(
				'groups_users',
				array(
					'uid' =>$this->int(),
					'gid' =>$this->int()
				),
				array('uid', 'gid')
		);		
	}

	private function addUserSocialAccounts() {
		$this->add_table(
			'user_social_accounts',
			array(
				'uid' =>$this->int(),
				'type' => $this->varchar(),
				'social_id' => $this->varchar(),
				'nickname' =>$this->varchar(),
				'profile_image' => $this->varchar(1024),
				'detail' => $this->text(),
				'create_date' => $this->datetime(),
				'modify_date' => $this->datetime()
			),
			array('uid', 'create_date', 'modify_date')
		);
	}

	private function addUserLoginRecords() {
		$this->add_table(
			'user_login_records',
			array(
				'uid' => $this->int(), // The login user's id
				'sso_token_id' => $this->int(), // The login user's token id
				'type' => $this->varchar(8), // The login type, password or oauth
				'device_id' => $this->int(), // The device that user used to login(Only the user login using gateway has this information)
				'social_account_id' => $this->int(), // The social account id that user used for this login, if login using password or message code won't have any effect
				'from' => $this->varchar(), // The from field will record where the user comming from, for this version, will support for the refer and the gateway serial
				'status' => $this->varchar(8)
			),
			array('uid', 'type', 'device_id', 'social_account_id', 'status')
		);
	}

	private function addSsoApps() {
		$this->add_table(
			'sso_apps',
			array(
				'uid' => $this->int(),
				'appid' =>$this->varchar(),
				'appsecret' =>$this->varchar(),
				'create_date' => $this->datetime(),
				'config' => $this->text(),
				'modify_date' => $this->datetime(),
				'template' => $this->varchar(128, false, false, 'default_sso_template'),
				'status' => $this->varchar(16, false, true, 'active'),
				'callback' => $this->varchar(1024)
			),
			array('uid', 'appid', 'status', 'create_date', 'modify_date')
		);
	}

	private function addSsoTokens() {
		$this->add_table(
			'sso_tokens',
			array(
				'uid' => $this->int(),
				'appid' =>$this->varchar(),
				'token' => $this->varchar(200),
				'create_date' => $this->timestamp(),
				'status' => $this->varchar(16, false, true, 'active')
			),
			array('uid', 'appid', 'token', 'status', 'create_date')
		);
	}

	private function addUserSocialApps() {
		$this->add_table(
			'user_social_apps',
			array(
				'uid' =>$this->int(),
				'type' =>$this->varchar(),
				'appid' =>$this->varchar(),
				'appsecret' =>$this->varchar(),
				'status' =>$this->varchar(16, false, true, 'active'),
				'create_date' => $this->datetime(),
				'modify_date' => $this->datetime()
			),
			array('uid', 'appid', 'appsecret', 'create_date', 'modify_date')
		);
	}

	private function addUserDevices() { 
        $this->add_table(      
			'user_devices',     
			array(         
				'uid' => $this->int(),     
				'mac' => $this->varchar(17),    
				'os'=>$this->varchar(16),       
				'os_version'=>$this->varchar(16),
				'browser'=>$this->varchar(16),  
				'browser_version'=>$this->varchar(16),
				'uagent'=>$this->varchar(255),
				'create_date' => $this->datetime(),
				'modify_date' => $this->datetime()
			),             
			array('uid', 'mac', 'os', 'os_version', 'browser', 'browser_version')
        );                     
    } 

	public function up() {
		// The user and the group informations
		$this->addUsers();
		$this->addUserBasicInfos();
		$this->addUserContactInfos(); // contact info * - 1 user
		$this->addGroups();
		$this->addGroupsUsers();

		// The user login information part
		$this->addUserDevices();
		$this->addUserSocialAccounts();
		$this->addUserLoginRecords();

		// The user social application
		$this->addUserSocialApps();

		// For sso application
		$this->addSsoApps();
		$this->addSsoTokens();
	}

	public function down() {
		$this->drop_table('groups', 'user_basic_infos', 'user_contact_infos', 'users');
	}
}
