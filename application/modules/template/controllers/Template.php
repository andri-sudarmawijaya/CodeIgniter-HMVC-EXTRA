<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->module('site_security');
		$this->load->module('site_settings');
	}

	function public_full($data) {
		$data['theme_url'] = base_url('themes/public/default/');
		$this->load->view('public_full', $data);
	}

	function admin($data) {
		$data['theme_url'] = base_url('themes/admin/vali/');
		$this->load->view('admin', $data);
	}

}
