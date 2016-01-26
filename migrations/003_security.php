<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Security extends MY_Migration {
	private function addActions() {
		$this->add_table(
			'actions',
			array(
				'controller' => $this->varchar(32),
				'method' => $this->varchar(32, false, true),
				'group' => $this->varchar(32, false, true, 'main_navigation'),
				'logo' => $this->varchar(128),
				'name' => $this->varchar(128),
				'label' => $this->varchar(128),
				'args' => $this->varchar(128),
				'fields' => $this->text(),
			),
			array('controller', 'method', 'group')
		);
	}

	public function up() {
		$this->addActions();
	}

	public function down() {
		$this->drop_table('actions');
	}
}
