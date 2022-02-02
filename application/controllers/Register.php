<?php

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("url", "form", 'string'));
        $this->load->library(array('form_validation', 'email'));
        $this->load->model('registration_model');
    }

    public function index()
    {

        if (!empty(trim($this->session->userdata("user_detail_id")))) redirect("groups");

        $this->_verify("register");
    }

    private function sendVerifiication($email_code)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => $_ENV['SMTP_HOST'],
            'smtp_port' => 465,
            'smtp_user' => $_ENV['SMTP_USER'],
            'smtp_pass' => $_ENV['SMTP_PASSWORD'],
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        $this->email->to($this->input->post("tupemail"));
        $this->email->from($_ENV['SMTP_FROM'], 'TUP Connect');
        $this->email->subject('Email Verfication');
        $this->email->message("
        <div style=\"width:100%;text-align:center;font-family: Montserrat;\">
                <img src='https://drive.google.com/uc?export=download&id=17L0dShcQDaER8D05xyQ62QHaMG1k43kD'/>
                <h1 style=\"font-family: Montserrat;font-size: 24pt;\">Verify Your Identity</h1>
                <p style=\"font-size:12pt\">Please enter this confirmation code below to confirm your identity.</p>
                <span style=\"padding: 22px 50px;background-color: #f3f3f3;display: inline-block;margin: 30px;font-size: 27pt;font-weight: bold;\">$email_code</span>
                <p>If you did not create an account in TUP Connect, kindly ignore this email.</p>
                <div style=\"margin-top:60px\">
                    <img src=\"https://drive.google.com/uc?export=download&id=1OFSzQRe-1Uo2FnUJK6RU7x5lwrbSmItV\" />
                    <p>
                        (c) 2021 TUP Connect | All rights reserved 
                    </p>
                </div>
            </div>
        ");

        if ($this->email->send()) return true;
        else return false;
    }

    public function validation()
    {
        $data = $this->input->post();
        $data['email_code'] = random_string('numeric', 6);
        $data['user_id'] = random_string('alnum', 15);
        $data['user_detail_id'] = random_string('alnum', 15);
        if ($this->registration_model->insert($data)) {
            $this->session->set_userdata(array(
                "user_detail_id" => $data['user_detail_id']
            ));

            if ($this->sendVerifiication($data['email_code'])) redirect("./verify");
            else echo "Lah!";
        } else echo "Error!";
    }

    public function _verify($type)
    {

        if ($this->session->userdata("user_detail_id")) {
            $res = $this->registration_model->verify_identity($this->session->userdata("user_detail_id"));
            if (count($res)) {
                switch ($res[0]['status']) {
                    case 'pending':
                        $this->load->view("verify", $this->session->userdata());
                        break;
                    case 'verified':
                        if ($type === "register") {
                            $campus = $this->registration_model->get_campus_details();
                            $college = $this->registration_model->get_college_details();
                            $course = $this->registration_model->get_course_details();
                            $category = $this->registration_model->get_category_details();
                            $this->load->view("registration", array(
                                "action" => "/register/finalize",
                                "type" => "last",
                                "campuses" => $campus,
                                "colleges" => $college,
                                "courses" => $course,
                                "categories" => $category
                            ));
                        } else redirect("./register");
                        break;
                }
            } else {
                $gender = $this->registration_model->get_gender_details();
                $this->load->view("registration", array(
                    "action" => "/register/validation",
                    "type" => "first",
                    "genders" => $gender
                ));
            };
        } else {
            if ($type === "register") {
                $gender = $this->registration_model->get_gender_details();

                $this->load->view("registration", array(
                    "action" => "/register/validation",
                    "type" => "first",
                    "genders" => $gender
                ));
            } else  redirect("./register");
        };
    }

    public function verify()
    {
        $this->_verify("verify");
    }

    public function verify_email()
    {
        $code = "";
        $codes = $this->input->post("code");
        foreach ($codes as $c) {
            $code .= $c;
        }

        $res = $this->registration_model->verify_code($code, $this->session->userdata("user_detail_id"));
        if (!count($res)) {
            $this->session->set_userdata(
                array(
                    "error" => true,
                    "error_title" => "Invalid Code",
                    "error_description" => "Please Try Again"
                )
            );
            redirect("./verify");
        } else {
            if ($this->registration_model->update_code($res[0]['user_verification_id'])) {
                $this->session->unset_userdata(array("error", "error_title", "error_description"));
                $this->_verify("register");
            } else echo "may error gagi";
        }
    }


    public function finalize()
    {
        $data = array(
            "user_detail_id" => $this->session->userdata("user_detail_id"),
            "campus_id" => $this->input->post("college"),
            "college_id" => $this->input->post("college"),
            "course_id" => $this->input->post("course"),
            "interests" => $this->input->post("user-interests"),
        );

        if ($this->registration_model->final_insert($data)) redirect("lobby");
    }
}
