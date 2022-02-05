<?php

class login_model extends CI_Model

{
	public function __construct()
	{
		parent::__construct();
	}

	public function authenticate()
	{
		$query = $this->db->query("SELECT tbl_user.user_detail_id, tbl_user.user_password, tbl_user_detail.image_path, tbl_user.is_admin from tbl_user, tbl_user_detail where (tbl_user.user_name ='" . $this->input->post("username") . "' or tbl_user.user_email = '" . $this->input->post("username") . "') and tbl_user_detail.user_detail_id = tbl_user.user_detail_id");

		return $query->result_array();
	}


	function checkUser($email, $password)
	{
		$query = $this->db->query("SELECT * from tbl_user where user_email='$email' AND user_password='$password'");
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function checkCurrentPassword($currentPassword)
	{
		$userid = $this->session->userdata('LoginSession')['id'];
		$query = $this->db->query("SELECT * from tbl_user WHERE user_id='$userid' AND user_password='$currentPassword' ");
		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function updatePassword($password)
	{
		$userid = $this->session->userdata('LoginSession')['id'];
		$query = $this->db->query("UPDATE tbl_user set user_password='$password' WHERE user_id='$userid' ");
	}

	public function validateEmail($email)
	{
		$query = $this->db->query("SELECT * FROM tbl_user WHERE user_email='$email'");
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function updatePasswordhash($data, $email)
	{
		$this->db->where('user_email', $email);
		$this->db->update('tbl_user', $data);
	}

	function getHashDetails($hash)
	{
		$query = $this->db->query("SELECT * from tbl_user WHERE hash_key='$hash'");
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function validateCurrentPassword($currentPassword, $hash)
	{
		$query = $this->db->query("SELECT * from tbl_user WHERE user_password = '$currentPassword' AND hash_key='$hash'");
		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function updateNewPassword($data, $hash)
	{
		$this->db->where('hash_key', $hash);
		$this->db->update('tbl_user', $data);
	}
}
