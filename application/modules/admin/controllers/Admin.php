<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

    protected $model = '';
    protected $_module = '';
    protected $_logged_user = '';

    function __construct() {
        parent::__construct();
        
        $this->load->library('form_validation');
        $this->form_validation->CI = & $this;

        // Set the module from the first uri.
        $this->load->module('site_security');
        $this->_module = $this->site_security->_get_module_name();
        // Get The logged User
        $this->_logged_user = $this->site_security->_get_logged_user();
    }

    public function index() {
        // Check for security
        $this->site_security->_make_sure_is_admin();

        $data['page_title'] = "Administration > Index";
        $data['page_description'] = "";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "index";

        echo Modules::run('template/admin', $data);
    }

    public function login() {
        // Check for security
        if($this->site_security->_check_login()) {
            $this->site_security->_alert('Info!', 'alert alert-info', 'You are logged.');
            redirect('admin');
        }

        $data['page_title'] = "Administration > Login";
        $data['page_description'] = "";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "login";
        $data['theme_url'] = base_url('themes/admin/vali/');

        $this->load->view('admin/login', $data);
    }

    public function run() {
        $username = $this->input->post("username");
        $remember = $this->input->post("remember");
        $password = custom_hash("sha256", $this->input->post("password"), HASH_KEY);

        /* Autenthicate the user */
        $found_user = $this->autenthicate($username, $password);
        if ($found_user) {
            if_remember($remember);
            /* Update last login */
            $this->user->_update($found_user->id, array(
                'last_seen' => time()
            ));
            // Set the user id in session
            $this->session->set_userdata('user_id', $found_user->id);
            // Set the message in session
            $this->site_security->_alert('Info!', 'alert alert-success', 'Login successfully.');

            if ($found_user->role == "admin") {
                // Redirect to admin page
                redirect('admin');
            } else {
                redirect(base_url());
            }
        } else {
            $this->site_security->_alert('Error!', 'alert alert-danger', 'Login incorect.');
            redirect("admin/login");
            return false;
        }
    }

    function autenthicate($username = null, $password = null) {
        if (isset($username) && isset($password) && $username != null && $password != null) {

            $this->db->where('username', $username);
            $this->db->where('hash_pass', $password);
            $this->db->limit(1);
            $query = $this->db->get('user');
            $array = $query->result();
            return array_shift($array);
        }
    }

    public function destroy() {
        $array_items = array('user_id');

        $this->session->unset_userdata($array_items);
        $this->session->sess_destroy();
        sleep(0.2);
        redirect("admin/login");
    }
}
