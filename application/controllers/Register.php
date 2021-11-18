<?php

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->model('register_model');
    }

    public function index()
    {
        $this->load->view('registration');
    }
}

?>