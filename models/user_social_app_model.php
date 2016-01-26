<?php defined("BASEPATH") or exit("No direct script access allowed");

class User_Social_App_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('user_social_apps');
	}

    public function getSocialApp($id){
        $this->result_mode = 'object';
        return $this->get(array(
            'id' => $id
        ));
    }

    public function getSocialAppByType($appid, $type){
        $this->db->select('usa.id, usa.type, usa.appid, usa.appsecret');
        $this->db->from('sso_apps as sa');
        $this->db->join('user_social_apps usa', 'sa.uid=usa.uid', 'inner');
        $this->db->where('sa.appid', $appid);
        $this->db->where('usa.type', $type);
        $this->db->where('sa.status', 'active');
        $this->db->where('usa.status', 'active');
        return $this->db->get()->row();
    }
}
