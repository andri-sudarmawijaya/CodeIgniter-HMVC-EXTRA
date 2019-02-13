<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MX_Controller {

    protected $model = '';
    protected $_module = '';
    protected $_logged_user = '';

    function __construct() {
        parent::__construct();

        $this->load->model("user_model");
        $this->model = $this->user_model;

        // Set the module from the first uri.
        $this->load->module('site_security');
        $this->_module = $this->site_security->_get_module_name();
        // Get The logged User
		$this->_logged_user = $this->site_security->_get_logged_user();
		// Load the settings module
		$this->load->module('site_settings');
    }

    public function index() {

        $data['page_title'] = "Codeigniter 3.1.10 with HVMC in 2019 by xttrust";
        $data['page_description'] = "Codeigniter 3.1.10 with HVMC in 2019 by xttrust";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "index";

        echo Modules::run('template/public_full', $data);

	}

	public function manage() {

        // in future, check for security
        $this->site_security->_make_sure_is_admin();

        // Count rows for pagination
        $this->load->library('pagination');
        $config = $this->site_settings->_config_pagination("user/manage", 3);
        $result = $this->db->get('user');
        $data['total_rows'] = $config['total_rows'] = $result->num_rows();
        $this->pagination->initialize($config);

        // Get rows for display


		$data['query'] = $this->get_with_limit($config['per_page'], $this->uri->segment(3), 'register_date DESC');

        $data['page_title'] = "Administration > Manage Users";
        $data['page_description'] = "";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "manage";

        echo Modules::run('template/admin', $data);
	}

	public function create() {

        // Check security
        $this->site_security->_make_sure_is_admin();

        $update_id = $this->uri->segment(3);

        if (isset($update_id)) {
            $row = $this->get_where_row('id', $update_id);
            if (!$row) {
                show_404();
            }
        }

        $submit = $this->input->post('submit', TRUE);

        if ($submit == "Cancel") {
            redirect('user/manage');
        }

        if ($submit == "Submit") {
            // Process the form
            $data = $this->fetch_data_from_post();
            $password = trim($this->input->post('password', TRUE));

            $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[2]|max_length[50]');

            if (!is_numeric($update_id)) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[35]');
                $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|matches[password]');
                $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[20]|is_unique[user.username]');
            } else {
                if (empty($password)) {
                    unset($data['password']);
                } else {
                    $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[35]');
                    $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|matches[password]');
                }
            }

            // Get the user by update id and check for same email
            $user_to_update = $this->user->get_where_row('id', $update_id);
            $posted_email = $this->input->post('email', TRUE);
            if (($user_to_update) && $user_to_update->email == $posted_email) {
                $this->form_validation->set_rules('email', 'Email', 'required|min_length[8]|max_length[50]');
            } else {
                $this->form_validation->set_rules('email', 'Email', 'required|min_length[8]|max_length[50]|is_unique[user.email]');
            }


            if ($this->form_validation->run() == TRUE) {
                // Get the variables

                if (!empty($password)) {
                    $data['hash_pass'] = custom_hash("sha256", $this->input->post("password"), HASH_KEY);
                }

                $data['register_date'] = curent_date_for_mysql();

                if (is_numeric($update_id)) {
                    // Unset data for update that canot be changed
                    unset($data['username']);
                    $data['last_seen'] = time();

                    if (empty($password)) {
                        unset($data['hash_pass']);
                    }



                    // Update the user details
                    $this->model->_update($update_id, $data);
                    $message = "The user details were successfully updated.";
                    $this->site_security->_alert('Info! ', 'alert alert-success', $message);
                    redirect('user/create/' . $update_id);
                } else {
                    // Insert a new Item
                    $this->model->_insert($data);
                    $update_id = $this->model->get_max(); // get the ID of the new item

                    $message = "The user was successfully added.";
                    $this->site_security->_alert('Info! ', 'alert alert-success', $message);
                    redirect('user/create/' . $update_id);
                }
            }
        }


        if ((is_numeric($update_id)) && ($submit != "Submit")) {
            $data = $this->fetch_data_from_db($update_id);
        } else {
            $data = $this->fetch_data_from_post();
        }

        if (!is_numeric($update_id)) {
            $data['headline'] = "Add New User";
        } else {
            $data['headline'] = "Update User Details";
        }

        $data['update_id'] = $update_id;
        $data['page_title'] = "Administration > Manage Users > Create > " .$update_id;
        $data['page_description'] = "";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "create";

        echo Modules::run('template/admin', $data);
    }

	public function deleteconf() {

        // in future, check for security
        $this->site_security->_make_sure_is_admin();

        $data['update_id'] = trim($this->uri->segment(3));

        if (!is_numeric($data['update_id'])) {
            redirect('admin');
        }

        $data['query'] = $this->get_where_row('id', $data['update_id']);

        $data['page_title'] = "Administration > Delete User > ".$data['query']->username;
        $data['page_description'] = "";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "deleteconf";

        echo Modules::run('template/admin', $data);
    }

    public function delete($id = FALSE) {
        if ($id != FALSE) {
            $this->site_security->_make_sure_is_admin();
            $id = trim($id);
            $row = $this->get_where_row('id', $id);

            if ($row) {
                // Genre found in database, attempt to delete
                if ($row->username == "admin") {
                    $message = "You can't delete the administrator of the website.";
                    $this->site_security->_alert('Danger! ', 'alert alert-danger', $message);
                    redirect("user/manage");
                } else {
                    $this->_delete($id);

                    $message = "The user was successfully deleted.";
                    $this->site_security->_alert('Info! ', 'alert alert-success', $message);
                    redirect("user/manage");
                }
            }
        } else {
            show_404();
        }
    }


	// Standard Functions for all controllers.

	function check_uniq_row($row, $value) {
        $this->site_security->_make_sure_is_admin();

        $value = trim($value);
        $query = $this->get_where_row($row, $value);

        $num_rows = $query->num_rows();

        if ($num_rows > 0) {
            $this->form_validation->set_message($row . '_check', 'The ' . $row . ': ' . $value . ' is not aviable.');
            return FALSE;
        } else {
            return TRUE;
        }
	}
	
	function fetch_data_from_post() {
        // Get the post variables
        $data['username'] = $this->input->post('username', TRUE);
        $data['hash_pass'] = $this->input->post('password', TRUE);
        $data['email'] = $this->input->post('email', TRUE);
        $data['first_name'] = $this->input->post('first_name', TRUE);
        $data['last_name'] = $this->input->post('last_name', TRUE);
        $data['role'] = $this->input->post('role', TRUE);
        $data['last_seen'] = $this->input->post('last_seen', TRUE);
        $data['token'] = $this->input->post('token', TRUE);
        $data['status'] = $this->input->post('status', TRUE);
        $data['register_date'] = $this->input->post('register_date', TRUE);
        return $data;
    }

    function fetch_data_from_db($update_id) {
        // Get the row from database
        $row = $this->model->get_where_row('id', $update_id);
        /*
         * @param $row = object
         */
        $data['id'] = $row->id;
        $data['username'] = $row->username;
        $data['password'] = $row->hash_pass;
        $data['email'] = $row->email;
        $data['first_name'] = $row->first_name;
        $data['last_name'] = $row->last_name;
        $data['role'] = $row->role;
        $data['last_seen'] = $row->last_seen;
        $data['token'] = $row->token;
        $data['status'] = $row->status;
        $data['register_date'] = $row->register_date;

        if (!isset($data)) {
            $data = "";
        }

        return $data;
    }

    function get($order_by = FALSE) {
        if ($order_by != FALSE) {
            $query = $this->model->get($order_by);
        } else {
            $query = $this->model->get();
        }

        return $query;
    }

    function search($row, $query, $order_by, $limit, $offset) {
        $query = $this->model->search($row, $query, $order_by, $limit, $offset);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $query = $this->model->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function get_where_id($id) {
        $query = $this->model->get_where_id($id);
        return $query;
    }
    
    function get_where($col, $value) {
        $query = $this->model->get_where($col, $value);
        return $query;
    }

    function get_where_row($col, $value) {
        $query = $this->model->get_where_row($col, $value);
        return $query;
    }

    function get_where_list($col, $value) {
        $query = $this->model->get_where_list($col, $value);
        return $query;
    }

    function _insert($data) {
        $this->model->_insert($data);
    }

    function _update($id, $data) {
        $this->model->_update($id, $data);
    }

    function _delete($id) {
        $this->model->_delete($id);
    }
    
    function count_all() {
        $count = $this->model->count_all();
        return $count;
    }

    function count_where($column, $value) {
        $count = $this->model->count_where($column, $value);
        return $count;
    }

    function get_max() {
        $max_id = $this->model->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $query = $this->model->_custom_query($mysql_query);
        return $query;
    }

    

}
