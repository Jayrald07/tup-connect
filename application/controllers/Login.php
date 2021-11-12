<?php

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("form", "url"));
        $this->load->model("login_model");
    }

    public function authenticate()
    {
        if (count($this->login_model->authenticate())) redirect("lobby/");
    }

    public function index()
    {
        $this->load->view("login");
    }
}


?>