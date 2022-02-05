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
WHERE tbl_organization_user.user_detail_id = '" . $user_detail_id . "' and tbl_organization.organization_id = tbl_organization_user.organization_id and tbl_organization_user.status = 1");
        return $query->result_array();
    }

    public function get_owned_org($user_detail_id)
    {
        $query = $this->db->get_where('tbl_organization', array('organization_owner' => $user_detail_id));
        return $query->result_array();
    }

    public function get_colleges() {
        return $this->db->get("tbl_college")->result_array();
    }

    public function add_org($data) {
        $user = $this->db->get_where("tbl_user_detail",array(
            "user_detail_id" => $data["organization_owner"]
        ))->result_array();
        
        if ($data["organization_type"] === "univ") $data["ref_id"] = $user[0]["campus_id"];
        else $data["ref_id"] = $this->input->post("org-college");

        return $this->db->insert("tbl_organization",$data);
    }

    public function get_org_members($org_id) {
        $this->db->select("count(*) AS members");
        return $this->db->get("tbl_organization_user")->result_array();
    }

    public function user_org_status($uid,$org_id) {
        return $this->db->get_where("tbl_organization_user",array(
            "user_detail_id" => $uid,
            "organization_id" => $org_id
        ))->result_array();
    }

    public function find_org($data) {
        $categ = 'select * from tbl_organization where organization_name like "%'. $data["organization_name"] .'%" ';

        if ($data["interests"] && count($data["interests"])) {
            for($i = 0;$i < count($data["interests"]);$i++) {
                if ($i === 0) $categ .= "and (category_id = " . $data["interests"][$i];
                $categ .= " or category_id = " . $data["interests"][$i];
            }
            $categ .= ")";
        }
        
        
        if ($data["use_org_type"]) {
            $categ .= " and organization_type = '" . $data["org_type"] . "' ";
            $campus = NULL;
            if ($data["org_type"] === "univ") {
                $this->db->select("campus_id");
                $this->db->where("user_detail_id",$this->session->userdata("user_detail_id"));
                $campus = $this->db->get("tbl_user_detail")->result_array();
                $categ .= "and ref_id = " . $campus[0]["campus_id"];
            } else $categ .= "and ref_id = " . $data["college_id"];
        }
        
        $categ .= " and status = 1";

        $res = $this->db->query($categ)->result_array();
        for($i = 0;$i < count($res);$i++) {
            $res[$i]["members"] = $this->get_org_members($res[$i]["organization_id"])[0]["members"];
            $res[$i]["is_owner"] = $res[$i]["organization_owner"] === $this->session->userdata("user_detail_id") ? TRUE : FALSE;
            $val = $this->user_org_status($this->session->userdata("user_detail_id"),$res[$i]["organization_id"]);
            $res[$i]["status"] = -1;
            if (count($val)) $res[$i]["status"] = $val[0]["status"];
        }
        return $res;
    }

    public function join_org($data) {
        $res = $this->db->get_where("tbl_organization_user",array(
            "user_detail_id" => $this->session->userdata("user_detail_id"),
            "organization_id" => $data["organization_id"],
        ))->result_array();

        if (count($res)) {
            $this->db->set("status",0);
            $this->db->where(array(
            "user_detail_id" => $this->session->userdata("user_detail_id"),
            "organization_id" => $data["organization_id"],
            ));
            return $this->db->update("tbl_orgnization_user");
        } else {
            return $this->db->insert("tbl_organization_user",array(
                "user_detail_id" => $this->session->userdata("user_detail_id"),
                "role_id" => 0,
                "organization_id" => $data["organization_id"],
                "status" => 0
            ));
        }
    }

    public function cancel_org_request($data) {
        return $this->db->delete("tbl_organization_user",$data);
    }

    public function get_members($id) {
        $mems =  $this->db->get_where("tbl_organization_user",array(
            "organization_id" => $id,
            "status" => 1
        ))->result_array();

        $res = [];

        for($i = 0;$i < count($mems);$i++) {
            $val = $this->db->get_where("tbl_user_detail",array(
                "user_detail_id" => $mems[$i]["user_detail_id"]
            ))->result_array();
            $res[$i]["user_detail_id"] = $val[0]["user_detail_id"];
            $res[$i]["firstname"] = $val[0]["first_name"];
            $res[$i]["middlename"] = $val[0]["middle_name"];
            $res[$i]["lastname"] = $val[0]["last_name"];
            $res[$i]["image_path"] = $val[0]["image_path"];
        }

        return $res;

    }

    public function get_user_role($org_id,$role) {
        $this->db->select("count(*) as count");
        $this->db->where(array(
            "organization_id" => $org_id,
            "role_id" => $role
        ));
        return $this->db->get("tbl_organization_user")->result_array();
    }

    public function get_org($org_id) {
        return $this->db->get_where("tbl_organization",array(
            "organization_id" => $org_id
        ))->result_array();
    }

    public function get_org_user($data) {
        $res = $this->db->get_where("tbl_organization_user",$data)->result_array();
        for($i = 0;$i < count($res);$i++) {
            $val = $this->db->get_where("tbl_user_detail",array(
                "user_detail_id" => $res[$i]["user_detail_id"]
            ))->result_array();
            $res[$i]["user_detail_id"] = $val[0]["user_detail_id"];
            $res[$i]["firstname"] = $val[0]["first_name"];
            $res[$i]["middlename"] = $val[0]["middle_name"];
            $res[$i]["lastname"] = $val[0]["last_name"];
            $res[$i]["image_path"] = $val[0]["image_path"];
        }
        return $res;
    }

    public function get_reported_org_post($org_id) {
        $post_details = [];
            $p = $this->db->get_where("tbl_organization_post",array("organization_id" => $org_id))->result_array();

            foreach($p as $pt) {
                $data = array(
                    "post_id" => $pt["post_id"],
                    "user_detail_id" => $pt["user_detail_id"]
                );
                $post_details[] = $data;
            }


        $res = [];

        for($i = 0;$i < count($post_details);$i++) {
            $cond = $this->db->get_where("tbl_post",array("post_id" => $post_details[$i]["post_id"],"report_status" => 1))->result_array();
            $data = array(
                "user" => $this->db->get_where("tbl_user_detail",array("user_detail_id" => $post_details[$i]["user_detail_id"]))->result_array(),
                "post" => $cond,
            );
            if (count($cond)) {
                $report = $this->db->get_where("tbl_post_report",array(
                    "post_id" => $cond[0]["post_id"]
                ))->result_array();
                $desclist = [];
                foreach($report as $r) {
                    $desc = $this->db->get_where("tbl_report",array(
                        "report_id" => $r["report_id"],
                        "status" => 1
                    ))->result_array();
                    if (count($desc)) $desclist[] = $desc[0];
                }
                $image = $this->db->get_where("tbl_post_image",array(
                    "post_id" => $cond[0]["post_id"]
                ))->result_array();

                $data["report"] = $desclist;
                $data["post_image"] = $image;
                $res[] = $data;
            }
        }   

        return $res;
        
    }

    public function get_roles($id) {
        return $this->db->get_where("tbl_role",array(
            "id_ref" => $id
        ))->result_array();
    }

    public function get_role_permissions($org_id) {
        $roles = $this->get_roles($org_id);
        $val = [];
        if (count($roles)) {
            foreach($roles as $role) {
                $data["role_id"] = $role["role_id"];
                $data["role_name"] = $role["role_name"];
                $val[] = $data;
            }
            
            $this->db->select("member_request,reported_content,manage_roles,manage_permission");
            $this->db->where(array(
                "role_id" => $val[0]["role_id"],
                "id_ref" => $org_id
            ));

            $val[0]["permissions"] = $this->db->get("tbl_role")->result_array();
        }
        return $val;
    }

    public function remove_group_user($data) {
        $this->db->set(array(
            "status" => -1
        ));
        $this->db->where($data);
        return $this->db->update("tbl_organization_user");
    }

    public function org_user_update_status($data,$status) {
        $this->db->set("status",$status);
        $this->db->where($data);
        return $this->db->update("tbl_organization_user");
    }

    public function add_role($org_id,$role) {
        if ($this->db->insert("tbl_role",array(
            "role_name" => $role,
            "id_ref" => $org_id
        ))) {
            return $this->db->get_where("tbl_role",array(
            "role_name" => $role,
            "id_ref" => $org_id
            ))->result_array();
        }
    }

    public function get_org_user_hasno_roles($org_id) {
        $user = $this->db->get_where("tbl_organization_user",array(
            "organization_id" => $org_id,
            "role_id" => 0,
            "status" => 1
        ))->result_array();

        $res = [];

        foreach($user as $u) {
            $val = $this->db->get_where("tbl_user_detail",array(
                "user_detail_id" => $u["user_detail_id"]
            ))->result_array();
            $res[] = $val[0];
        }

        return $res;
    }

    public function update_org_user_role($data) {
        $this->db->set(array(
            "role_id" => $data["role_id"]
        ));
        $this->db->where(array(
            "user_detail_id" => $data["user_detail_id"],
            "organization_id" => $data["organization_id"]
        ));
        if ($this->db->update("tbl_organization_user")) {
            return count($this->db->get_where("tbl_organization_user",array(
                "organization_id" => $data["organization_id"],
                "role_id" => $data["role_id"]
            ))->result_array());
        }
    }

    public function get_org_user_roles($role_id,$org_id) {
        $user = $this->db->get_where("tbl_organization_user",array(
            "role_id" => $role_id,
            "organization_id" => $org_id,
            "status" => 1
        ))->result_array();

        $res = [];

        foreach($user as $u) {
            $val = $this->db->get_where("tbl_user_detail",array(
                "user_detail_id" => $u["user_detail_id"]
            ))->result_array();
            $res[] = $val[0];
        }

        return $res;
    }

    public function is_org_owner($id) {
        $this->db->select("count(*) as found");
        $this->db->where("organization_owner",$id);
        $count = $this->db->get("tbl_organization")->result_array()[0]["found"];
        if ($count > 0) return TRUE;
        else return FALSE;
    }

    public function is_verified($id) {
        $this->db->select("status");
        $this->db->where(array(
            "organization_id" => $id,
        ));
        $status = $this->db->get("tbl_organization")->result_array()[0]["status"];
        if ($status == 0) return "not-verified";
        else if ($status == 1) return "verified";
        else if ($status == 2) return "not-qualified";
        else return "revoked";
    }

    public function get_org_by_status($status) {
        $this->db->select("campus_id");
        $this->db->where("user_detail_id",$this->session->userdata("user_detail_id"));
        $campus_id = $this->db->get("tbl_user_detail")->result_array()[0]["campus_id"];


        return $this->db->query("SELECT tbl_organization.*, tbl_user_detail.*, tbl_category.* FROM tbl_organization, tbl_user_detail, tbl_category WHERE tbl_organization.status = $status and tbl_user_detail.user_detail_id = tbl_organization.organization_owner and tbl_category.category_id = tbl_organization.category_id and tbl_user_detail.campus_id = $campus_id")->result_array();
    }

    public function delete_org($id) {
        return $this->db->delete("tbl_organization",array(
            "organization_id" => $id
        ));
    }

    public function update_org_status($id,$status) {
        $this->db->set(array(
            "status" => $status
        ));
        $this->db->where("organization_id",$id);
        return $this->db->update("tbl_organization");
    }

    public function get_user_permissions($id) {
        $res = $this->db->query("SELECT tbl_role.* FROM tbl_role, tbl_organization_user WHERE tbl_organization_user.user_detail_id = '$id' AND tbl_role.role_id = tbl_organization_user.role_id")->result_array();

        return $res;

    }

}
