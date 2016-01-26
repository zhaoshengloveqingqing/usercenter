<?php defined('BASEPATH') or exit('No direct script access allowed');

class EntityTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetup() {
		$this->library(array('test_data', 'entity'));
		$this->model(array('user_model', 'user_basic_info_model'));
	}

	public function testEntity() {
		$entity = new Entity($this->user_model);
		$CI = &get_instance();
		$entity->addMixin($CI->load->mixin('user_basic_info'));
		$this->test_data->addUser();
		$this->test_data->addUserBasicInfo();
		$this->assertNotNull($this->entity);

		$entity->load($this->test_data->the_user_id);
		$entity->status = 'jack';
		$entity->apply();
		$user = $this->user_model->load($entity->id);
		$this->assertEquals($entity->status, $user->status);

		$this->assertEquals($entity->username, 'jack');
		$entity->password = 'jack';
		$entity->apply();
		$user = $this->user_basic_info_model->getByUid($entity->id);
		$this->assertEquals($entity->password, $user->password);
	}

	public function doTearDown() {
		$this->test_data->clear();
	}
}
