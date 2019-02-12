<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_settings extends MX_Controller {

    function __construct() {
        parent::__construct();
    }

    function _get_website_name() {
        $string = "codeigniter_3.1.10_hmvc";
        return $string;
    }

    function _get_currency_symbol() {
        $string = "$";
        return $string;
    }

    function _get_currency_name() {
        $string = "USD";
        return $string;
    }
}