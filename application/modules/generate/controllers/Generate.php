<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends MX_Controller {


    function __construct() {
        parent::__construct();
        $this->load->module('site_security');
    }

    public function index()
    {
        
    }
    
    public function from_post($table_name) {
        $fields = $this->db->list_fields($table_name);

        foreach ($fields as $field) {
            echo '$data[\''.$field.'\'] = $this->input->post(\''.$field.'\', TRUE);'."<br>";
        }
    }
    
    public function from_db($table_name) {
        $fields = $this->db->list_fields($table_name);

        foreach ($fields as $field) {
            echo '$data[\''.$field.'\'] = $row->'.$field.";<br>";
        }
    }




    

}
