<?php

class login_model extends CI_Model

{
	public function __construct()
	{
		parent::__construct();
	}

	public function authenticate()
	{
		$query = $this->db->query("SELECT user_detail_id from tbl_user where (user_name ='" . $this->input->post("username") . "' or user_email = '" . $this->input->post("username") . "') and user_password = '" . $this->input->post("password") . "'");

		return $query->result_array();
	}


	function checkUser($email, $password)
	{
		$query = $this->db->query("SELECT * from tbl_pass_manage where email='$email' AND password='$password'");
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function checkCurrentPassword($currentPassword)
	{
		$userid = $this->session->userdata('LoginSession')['id'];
		$query = $this->db->query("SELECT * from tbl_pass_manage WHERE id='$userid' AND password='$currentPassword' ");
		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function updatePassword($password)
	{
		$userid = $this->session->userdata('LoginSession')['id'];
		$query = $this->db->query("UPDATE tbl_pass_manage set password='$password' WHERE id='$userid' ");
	}

	public function validateEmail($email)
	{
		$query = $this->db->query("SELECT * FROM tbl_pass_manage WHERE email='$email'");
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function updatePasswordhash($data, $email)
	{
		$this->db->where('email', $email);
		$this->db->update('tbl_pass_manage', $data);
	}

	function getHashDetails($hash)
	{
		$query = $this->db->query("SELECT * from tbl_pass_manage WHERE hash_key='$hash'");
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function validateCurrentPassword($currentPassword, $hash)
	{
		$query = $this->db->query("SELECT * from tbl_pass_manage WHERE password = '$currentPassword' AND hash_key='$hash'");
		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function updateNewPassword($data, $hash)
	{
		$this->db->where('hash_key', $hash);
		$this->db->update('tbl_pass_manage', $data);
	}
}
