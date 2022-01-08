<?php
class Registration_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function verify_identity($user_detail_id)
    {
        $query = $this->db->query("SELECT status FROM tbl_user_verification WHERE user_detail_id = '" . $user_detail_id . "'");
        return $query->result_array();
    }

    public function insert_interest($user_detail_id, $interests)
    {
        foreach ($interests as $interest) {
            if (!$this->db->insert("tbl_user_interest", array(
                "user_detail_id" => $user_detail_id,
                "category_id" => $interest
            ))) return false;
        }
        return true;
    }

    public function verify_code($code, $user_detail_id)
    {
        return $this->db->query("SELECT user_verification_id FROM tbl_user_verification WHERE code = '" . $code . "' AND user_detail_id = '" . $user_detail_id . "'")->result_array();
    }

    public function update_code($user_verification_id)
    {
        $this->db->set("status", "verified");
        $this->db->where("user_verification_id", $user_verification_id);
        return $this->db->update("tbl_user_verification");
    }

    public function insert($data)
    {
        $user = array(
            "user_id" => $data['user_id'],
            "user_email" => $data['tupemail'],
            "user_name" => $data['username'],
            "user_password" => $data['password'],
            "user_detail_id" => $data['user_detail_id'],
            "status" => "verifying"
        );

        $user_detail = array(
            'user_detail_id' => $data['user_detail_id'],
            'first_name' => $data['givenname'],
            'last_name' => $data['lastname'],
            'middle_name' => $data['middlename'],
            'birthday' => $data['birthday'],
            'year_level' => $data['year_level'],
            'gender_id' => $data['gender'],
            'college_id' => 0,
            'course_id' => 0,
            'campus_id' => 0,
            'user_cor_id' => 'AAA',
            'image_path' => 'user-1.png',
        );

        $user_verification = array(
            'user_detail_id' => $data['user_detail_id'],
            'code' => $data['email_code'],
            'status' => "pending"
        );

        if ($this->db->insert('tbl_user', $user))
            if ($this->db->insert("tbl_user_detail", $user_detail))
                if ($this->db->insert("tbl_user_verification", $user_verification)) return true;
                else return false;
            else return false;
        else return false;
    }

    public function final_insert($data)
    {
        $this->db->set(array(
            "campus_id" => $data["campus_id"],
            "college_id" => $data["college_id"],
            "course_id" => $data["course_id"],
        ));
        $this->db->where("user_detail_id", $data["user_detail_id"]);

        if ($this->db->update("tbl_user_detail")) {
            for ($i = 0; $i < count($data["interests"]); $i++) {
                $this->db->insert("tbl_user_interest", array(
                    "user_detail_id" => $data["user_detail_id"],
                    "category_id" => $data["interests"][$i]
                ));
            }

            $this->db->set("status", "registered");
            $this->db->where("user_detail_id", $data["user_detail_id"]);
            if ($this->db->update("tbl_user")) return true;
            else return false;
        } else false;
    }

    public function get_campus_details()
    {
        $query = $this->db->get("tbl_campus");
        return $query->result_array();
    }

    public function get_college_details()
    {
        $query = $this->db->get("tbl_college");
        return $query->result_array();
    }

    public function get_course_details()
    {
        $query = $this->db->get("tbl_course");
        return $query->result_array();
    }

    public function get_category_details()
    {
        $query = $this->db->get("tbl_category");
        return $query->result_array();
    }

    public function get_gender_details()
    {
        $query = $this->db->get("tbl_gender");
        return $query->result_array();
    }
}
