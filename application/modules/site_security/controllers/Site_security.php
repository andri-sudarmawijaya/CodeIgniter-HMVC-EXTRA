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




}
