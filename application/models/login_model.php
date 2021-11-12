<?php

class login_model extends CI_Model

{
    public function __construct()
    {
        parent::__construct();
    }

    public function authenticate()
    {
        $query = $this->db->query("SELECT user_detail_id from tbl_user where (user_name ='".$this->input->post("username")."' or user_email = '".$this->input->post("username")."') and user_password = '".$this->input->post("password")."'");

        return $query->result_array();
    }
}
?>