<?php

class Account extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("form","url","string"));
        $this->load->model("account_model");
    }

    public function index() {
        $data = array(
            "type" => "profile",
            "detail" => $this->account_model->get_user_info($this->session->userdata("user_detail_id"))
        );
        $this->load->view("account",$data);
    }

    public function settings() {
        $data = array(
            "type" => "settings",
            "detail" => $this->account_model->get_info($this->session->userdata("user_detail_id")),
            "genders" => $this->account_model->get_genders()
        );

        $this->load->view("account",$data);
    }

    public function activities() {
        $data = array(
            "type" => "activities",
            "activities" => $this->account_model->get_user_activities($this->session->userdata("user_detail_id"))
        );
        $this->load->view("account",$data);
    }

    public function update() {
        $firstname = $this->input->post("account_firstname");
        $middlename = $this->input->post("account_middlename");
        $lastname = $this->input->post("account_lastname");
        $birthday = $this->input->post("account_birthday");
        $gender = $this->input->post("account_gender");
        $username = $this->input->post("account_username");
        $password = $this->input->post("account_password");
        $image = $_FILES["account_image"];

        $auth = array(
            "user_name" => $username
        );

        if (trim($password)) $auth["user_password"] = $password;

        $data = array(
            "data" => array(
                "first_name" => $firstname,
                "middle_name" => $middlename,
                "last_name" => $lastname,
                "gender_id" => $gender,
                "birthday" => $birthday
            ),
            "auth" => $auth,
            "user_detail_id" => $this->session->userdata("user_detail_id")
        );

        if ($this->account_model->update_profile($data)) {
            if ($image["size"]) {
                $exploded = explode(".", $image["name"]);
                $extension = $exploded[count($exploded) - 1];
                $post_image = random_string("alnum", 15) . '.' . $extension;

                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';

                $config["file_name"]             = explode(".", $post_image)[0];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('account_image')) echo $this->upload->display_errors();
                else {
                    $this->account_model->update_pic(array(
                        "user_detail_id" => $this->session->userdata("user_detail_id"),
                        "image_path" => $post_image
                    )); 
                }
                
            }
            redirect(base_url("index.php/settings"));
        } else redirect(base_url("index.php/settings"));

    }

}