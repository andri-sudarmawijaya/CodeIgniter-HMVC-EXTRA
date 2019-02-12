<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_security extends MX_Controller {

    function __construct() {
        parent::__construct();
    }

    public function not_allowed() {
        die("You are not allowed to view that page.");
    }

    function _get_module_name() {
        $uri = $this->uri->segment(1);
        if (empty($uri)) {
            $module = "welcome";
        } else {
            $module = $uri;
        }
        return $module;
    }

    function _get_logged_user() {
	    $this->load->module('user');
	    $user_id = $this->session->user_id;
	    if (isset($user_id)) {
	        $user = $this->user->get_where_row('id', $user_id);
	    } else {
	        $user = FALSE;
	    }

	    return $user;
    }

    function _check_login() {
        $user_id = $this->session->user_id;
        if (isset($user_id)) {
            $return = TRUE;
        } else {
            $return = FALSE;
        }

        return $return;
    }

    function _make_sure_is_admin() {
        $this->load->module('user');
        $user_id = $this->session->user_id;
        $logged_user = $this->user->get_where_row('id', $user_id);
        if ($logged_user) {
            if ($logged_user->role == 'admin') {
                $is_admin = TRUE;
            } else {
                $this->not_allowed();
            }
        } else {
            redirect('admin/login');
        }
        return $is_admin;
    }

    function _alert($type, $css_class, $message) {
        $this->session->set_userdata('alert', '
            <div class="alert ' . $css_class . ' alert-dismissible fade show" role="alert">
                <strong>' . $type . '</strong> ' . $message . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        $this->session->mark_as_flash('alert');
    }

    function _config_pagination($base_url, $uri_segment) {
        $per_page = 10;
        $config['base_url'] = base_url($base_url);
        $config['uri_segment'] = $uri_segment;
        $config['per_page'] = $per_page;
        $config['num_links'] = 1;
        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='active'><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";
        $config['next_link'] = '<i title="Next Page" class="fa fa-angle-double-right"></i>';
        $config['prev_link'] = '<i title="Previous Page" class="fa fa-angle-double-left"></i>';
        $config['first_link'] = '<i title="First page" class="fa fa-step-backward"></i>';
        $config['last_link'] = '<i title="Last page" class="fa fa-step-forward"></i>';

        return $config;

    }



}