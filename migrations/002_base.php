<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Base extends MY_Migration {
    private function addLangTable() {
        $this->add_table(
            'languages',       
            array(             
                'line' => $this->varchar(255),  
                'lang' => $this->varchar(8),    
                'value' => $this->text()        
            ),
            array('line', 'lang')           
        );
    }

    private function addSessionTable() {
        $this->add_table(
            'ci_sessions',
            array(
                'session_id' => $this->varchar(40, true, false, '0'),
                'ip_address' => $this->varchar(45, false, false, 0),
                'user_agent' => $this->varchar(120, false, false),
                'last_activity' => $this->int(),
                'user_data' => $this->text(false),
            ),
            array('last_activity')          
        );
    }

	public function up() {
		$this->addLangTable();
		$this->addSessionTable();
	}

	public function down() {
		$this->drop_table('languages', 'ci_sessions');
	}
}
