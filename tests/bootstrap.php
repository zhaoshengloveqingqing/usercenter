<?php

/*
 *---------------------------------------------------------------
 * OVERRIDE FUNCTIONS
 *---------------------------------------------------------------
 *
 * This will "override" later functions meant to be defined
 * in core\Common.php, so they throw erros instead of output strings
 */
 
function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered') {
	throw new PHPUnit_Framework_Exception($message, $status_code);
}

function show_404($page = '', $log_error = TRUE) {
	throw new PHPUnit_Framework_Exception($page, 404);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP
 *---------------------------------------------------------------
 *
 * Bootstrap CodeIgniter from index.php as usual
 */

$script_name = getenv('PINET_SITE');
if(isset($script_name)) {
	$_SERVER['SCRIPT_NAME'] = $script_name;
}
 
require_once dirname(__FILE__) . '/../../index.php';

class Test_Session{
    function set_userdata($key, $value){
        $this->{$key} = $value;
    }

    function userdata($key){
		if(!isset($this->$key))
			return '';
        return $this->{$key};
    }

    function unset_userdata($key){
        unset($this->{$key});
    }
}

$CI = &get_instance();
$CI->load->helper(array('uagent','common'));
$CI->load->preventLoad('session');
$CI->session = new Test_Session();
$CI->session->set_userdata('serial', 'test');
$CI->session->set_userdata('mac', 'test');
$CI->session->set_userdata('email_address', 'test@test.cc');
$CI->session->set_userdata('password', 'test');
$CI->load->library('Pinet_PHPUnit_Framework_TestCase');
