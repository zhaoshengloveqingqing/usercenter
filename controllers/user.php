<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends Pinet_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->default_model = array(
			'index' => $this->user_model);
	}

	public function index() {
		$this->load->widget(array('bootstrap', 'datatable'));
		$this->render('user/list', array('title' => 'User List'));
	}

	public function show_form() {
		$user = $this->input->post();
		$this->user_model->update(
			$user['id'], $user
		);
		redirect(site_url('user'));
	}

	public function show($id = null) {
		if($id) {
			$this->load->widget(array('bootstrap', 'jquery_ui_common', 'form', 'button'));
			$this->render('user/show', array('title' => 'Edit User', 
				'form_data' => $this->user_model->load($id)));
		}
		else {
			show_error('Muste have valid user id!');
		}
	}
}
