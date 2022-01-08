<?php

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("form", "url"));
        $this->load->library(array('form_validation', 'email'));
        $this->load->library('session');
        $this->load->model('login_model');
    }

    public function authenticate()
    {
        $data = $this->login_model->authenticate();
        if (count($data)) {
            $this->session->unset_userdata(array("error_login", "error_title", "error_description"));
            $this->session->set_userdata("user_detail_id", $data[0]["user_detail_id"]);
            redirect("groups");
        } else {
            $this->session->set_userdata(array(
                "error_login" => true,
                "error_title" => "Invalid Credentials",
                "error_description" => "Incorrect Username/Password"
            ));
            redirect("login");
        }
    }

    public function signout()
    {
        $this->session->sess_destroy();
        redirect("login");
    }

    public function index()
    {
        if (!empty(trim($this->session->userdata("user_detail_id")))) redirect("groups");

        $this->load->view('login', $this->session->userdata());
    }

    public function forgotPassword()
    {
        $this->load->model("login_model");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required');
            if ($this->form_validation->run() == TRUE) {
                $email = $this->input->post('email');
                $validateEmail = $this->login_model->validateEmail($email);
                if ($validateEmail != false) {
                    $row = $validateEmail;
                    $user_id = $row->user_id;

                    $string = time() . $user_id . $email;
                    $hash_string = hash('sha256', $string);
                    $currentDate = date('Y-m-d H:i');
                    $hash_expiry = date('Y-m-d H:I', strtotime($currentDate . '+1 days'));
                    $data = array(
                        'hash_key' => $hash_string,
                        'hash_expiry' => $hash_expiry,
                    );


                    $resetLink = base_url() . 'index.php/reset/password?hash=' . $hash_string;
                    $message = '<p>Click your verification link here:</p>' . $resetLink;
                    $subject = "Password Reset Link";
                    $sentStatus = $this->sendEmail($email, $subject, $message);

                    if ($sentStatus) {
                        $this->login_model->updatePasswordhash($data, $email);
                        $this->load->view('forgotPass',array(
                            "proceed_change" => TRUE
                        ));
                        // echo 'hehe';
                    } else {
                        $this->session->set_flashdata('error', 'Email sending error');
                        $this->load->view('forgotPass');
                        // echo 'hotdog';
                    }
                } else {
                    // $this->session->set_userdata();
                    $this->load->view('forgotPass',array(
                        "error_login" => TRUE,
                        "error_title" => "Invalid Email Address",
                        "error_description" => "Please check your email address"
                    ));
                    echo 'wew';
                }
            } else {
                $this->load->view('forgotPass');
                // echo 'ha';
            }
        } else {
            $this->load->view('forgotPass');
            // echo 'heh';
        }
    }

    public function sendEmail($email, $subject, $message)
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

        $this->email->to($email);
        $this->email->from($_ENV['SMTP_FROM'], 'TUP Connect');
        $this->email->subject($subject);
        $this->email->message($message);

        return $this->email->send();
    }

}
