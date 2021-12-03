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
        if (count($this->login_model->authenticate())) redirect("lobby/");
    }

    public function index()
    {
        $this->load->view('login');
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
                    $user_id = $row->id;

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

                    if ($sentStatus == true) {
                        $this->login_model->updatePasswordhash($data, $email);
                        redirect(base_url('index.php/login/forgotPassword'));
                        echo 'hehe';
                    } else {
                        $this->session->set_flashdata('error', 'Email sending error');
                        $this->load->view('forgotPass');
                        echo 'hotdog';
                    }
                } else {
                    $this->session->set_flashdata('error', 'invalid email id');
                    $this->load->view('forgotPass');
                    echo 'wew';
                }
            } else {
                $this->load->view('forgotPass');
                echo 'ha';
            }
        } else {
            $this->load->view('forgotPass');
            echo 'heh';
        }
    }

    public function sendEmail($email, $subject, $message)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => $_ENV['SMTP_HOST'],
            'smtp_port' => 587,
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
        $this->email->subject('Password Reset Link');
        $this->email->message($message);

        if ($this->email->send()) return true;
        else return false;
    }
}
