<?php

class Organization_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_joined_org($user_detail_id)
    {
        $query = $this->db->query("SELECT tbl_organization.organization_id, tbl_organization.organization_name 
FROM tbl_organization, tbl_organization_user
WHERE tbl_organization_user.user_detail_id = '" . $user_detail_id . "' and tbl_organization.organization_id = tbl_organization_user.organization_id");
        return $query->result_array();
    }

    public function get_owned_org($user_detail_id)
    {
        $query = $this->db->get_where('tbl_organization', array('organization_owner' => $user_detail_id));
        return $query->result_array();
    }
}
