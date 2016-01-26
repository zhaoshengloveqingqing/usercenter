<?php defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends Pinet_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library(array('rule_manager'));
	}

	public function showlog() {
		clips_log("Hello");
		$this->tool->info("Hello world {tool}", array('tool' => 'jack'));
	}

	public function form() {
		$this->load->widget(array('form'));
		$this->render('form');
	}

	public function show_login($args) {
		var_dump($args);
		echo "Welcome\n";
	}

	public function test() {
		var_dump($this->input->get('token'));
	}

	public function index() {
		$this->load->widget(array('sample', 'revive_banner', 'button'));
		$this->scss('welcome/index');
//		$this->sasscompiler->resolutions = array(1024);
		$this->title = 'Welcome';
		$items = array(
			array(
				'label' => 'Pinet',
				'uri' => 'http://www.pinet.co'
			),
			array(),
			array(
				'label' => 'HiCT',
				'uri' => 'http://www.hict.cc'
			)
		);

		$actions = array();
		$actions []= new Action('Welcome', 'welcome', '');
		$actions []= array();
		$actions []= new Action('Hello', 'hellow', 'world');

		$this->render('index', array('items' => $items, 'actions' => $actions));
	}

	function select() {
		$this->load->widget(array('bootstrap', 'form'));
		$this->render('select', array('form_data' => (object) array(
			'province' => 6,
			'city' => 77
		)));
	}

	/** @RunRule('common.rules') */
	function rule() {
		echo file_get_contents('ci://config/rules/common.rules');
		echo "haha";
	}
}
