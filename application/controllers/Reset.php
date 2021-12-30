<?php 
class Reset extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
        $this->load->helper(array("form", "url"));
		$this->load->library('form_validation');
        $this->load->library('session');
	}

	function password()
	{
		if($this->input->get('hash'))
		{
			$hash = $this->input->get('hash');
			$this->data['hash']=$hash;
			$getHashDetails = $this->login_model->getHashDetails($hash);
			if($getHashDetails!=false)
			{
				$hash_expiry = $getHashDetails->hash_expiry;
				$currentDate = date('Y-m-d H:i');
				if($currentDate < $hash_expiry)
				{
					if($_SERVER['REQUEST_METHOD']=='POST')
					{
						$this->form_validation->set_rules('currentPassword','Current Password','required');
						$this->form_validation->set_rules('password','New Password','required');
						$this->form_validation->set_rules('cpassword','Confirm New Password','required|matches[password]');
						if($this->form_validation->run()==TRUE)
						{
							$currentPassword = $this->input->post('currentPassword');
							$newPassword = $this->input->post('password');

							$validateCurrentPassword = $this->login_model->validateCurrentPassword($currentPassword,$hash);
							if($validateCurrentPassword!=false)
							{
								 $newPassword = $newPassword;
								 $data = array(
								 	'user_password'=>$newPassword,
								 	'hash_key'=>null,
								 	'hash_expiry'=>null
								);
								 $this->login_model->updateNewPassword($data,$hash);
								 $this->session->set_flashdata('success','Successfully changed Password');
								 redirect(base_url('index.php/login'));
								 echo'panis';
							}
							else
							{
								$this->session->set_flashdata('error','Current Password is wrong');
								$this->load->view('reset_password',$this->data);	
								echo 'hotdog';
							}

						}
						else
						{
							$this->load->view('reset_password',$this->data);	
							echo'ewan';
						}
					}
					else
					{
						$this->load->view('reset_password',$this->data);
						echo 'aaaa';
					}
				}
				else
				{
					$this->session->set_flashdata('error','link is expired');
					redirect(base_url('index.php/login/forgotPassword'));
					echo'ewan q sau';
				}
			}
			else
			{
				echo 'invalid link';exit;
			}
		}
		else
		{
			redirect(base_url('index.php/login/forgotPassword'));
			echo'pls gumana ka na';
		}
	}
}