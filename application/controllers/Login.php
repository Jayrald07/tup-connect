<?php

require("application/third_party/PHPMailer/PHPMailer.php");
require("application/third_party/PHPMailer/SMTP.php");

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("form", "url"));
        $this->load->library('form_validation');
        $this->load->library('session');
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
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $this->form_validation->set_rules('email','Email','required');
            if($this->form_validation->run()==TRUE)
            {
                $email = $this->input->post('email');
                $validateEmail = $this->login_model->validateEmail($email);
                if($validateEmail!=false)
                {
                    $row= $validateEmail;
                    $user_id = $row->id;
                    
                    $string = time().$user_id.$email;
                    $hash_string = hash('sha256',$string);
                    $currentDate = date('Y-m-d H:i');
                    $hash_expiry = date('Y-m-d H:I', strtotime($currentDate. '+1 days'));
                    $data = array(
                        'hash_key' =>$hash_string, 
                        'hash_expiry'=>$hash_expiry,
                    );


                    $resetLink = base_url().'index.php/reset/password?hash='.$hash_string;
                    $message = '<p>Click your verification link here:</p>'.$resetLink;
                    $subject = "Password Reset Link";
                    $sentStatus = $this->sendEmail($email,$subject,$message);
                    
                    if($sentStatus==true)
                    {
                        $this->login_model->updatePasswordhash($data,$email);
                        redirect(base_url('index.php/login/forgotPassword'));
                        echo'hehe';
                    }
                    else{
                        $this->session->set_flashdata('error','Email sending error');
                        $this->load->view('forgotPass');
                        echo'hotdog';
                    }
                }
                else{
                    $this->session->set_flashdata('error','invalid email id');
                    $this->load->view('forgotPass');
                    echo 'wew';
                }
            }
            else
            {
                $this->load->view('forgotPass');
                echo 'ha';
            }
        }
        else
        {
            $this->load->view('forgotPass');
            echo 'heh';
        }

    }

	public function sendEmail($email,$subject,$message)
    {
        $mailTo = $email;
        $body = $message;
        
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->SMTPDebug = 3;

        $mail->isSMTP();

        $mail->Host = "smtp-relay.sendinblue.com";

        $mail->SMTPAuth = true;
        
        $mail->Username = "hyakki03@gmail.com";
        $mail->Password = "fWKzMChYJ8nNsDv5";

        $mail->SMTPSecure = "tls";

        $mail->Port = "587";

        $mail->From = "admin@hyakki.com";
        $mail->FromName = "Hotdog";

        $mail->addAddress($mailTo, "Test");

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = "ratatatatat";

        if(!$mail->send()){
            return false;
        }
        else{
            return true;
        }
    }
}


?>