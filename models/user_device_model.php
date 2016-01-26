<?php defined("BASEPATH") or exit("No direct script access allowed");

class User_Device_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('user_devices');
		$this->load->helper('uagent');
	}

    public function assignOwner($id, $uid){
        return $this->update($id, array('uid'=>$uid));
    }

	public function getDeviceByMac($mac) {
		$this->result_mode = 'object';
		$ret = $this->get('mac', $mac);
		return $ret;
	}

    public function getDeviceByUid($uid){
        $this->result_mode = 'object';
        return $this->get('uid', $uid);
    }

	public function deviceExists($mac) {
		return isset($this->getDeviceByMac($mac)->id);
	}

	public function createDevice($mac, $uid = null) {
		if($mac) { // TODO Validate the mac address
			$ua = parse_uagent($this->input->server('HTTP_USER_AGENT'));
			$arr = array(
				'mac' => $mac,
				'os' => $ua->os->family,
				'os_version' => $ua->os->toVersion(),
				'uagent' => $ua->originalUserAgent
			);
			if($uid)
				$arr['uid'] = $uid;
			return $this->insert($arr);
		}
		return null;
	}
}
