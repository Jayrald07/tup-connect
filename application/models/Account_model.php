<?php 

class Account_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function get_info($user_detail_id) {
        return $this->db->query("SELECT tbl_user_detail.first_name, tbl_user_detail.middle_name, tbl_user_detail.last_name, tbl_user_detail.birthday, tbl_gender.gender_id, tbl_user.user_name, tbl_user_detail.image_path
from tbl_user_detail, tbl_user, tbl_gender
where tbl_user.user_detail_id = '$user_detail_id' and tbl_user_detail.user_detail_id = tbl_user.user_detail_id and tbl_gender.gender_id = tbl_user_detail.gender_id")->result_array()[0];
    }
    
    public function get_genders()
    {
        $query = $this->db->get("tbl_gender");
        return $query->result_array();
    }

    public function update_profile($data) {
        $this->db->set($data["data"]);
        $this->db->where("user_detail_id",$data["user_detail_id"]);
        if ($this->db->update("tbl_user_detail")) {
            $this->db->set($data["auth"]);
            $this->db->where("user_detail_id",$data["user_detail_id"]);
            return $this->db->update("tbl_user");
        } else return false;
    }

    public function update_pic($data) {
        $this->db->set("image_path",$data["image_path"]);
        $this->db->where("user_detail_id",$data["user_detail_id"]);

        return $this->db->update("tbl_user_detail");
    }

    public function get_user_info($user_detail_id) {
        return $this->db->query("SELECT tbl_user_detail.first_name, tbl_user_detail.middle_name, tbl_user_detail.last_name, tbl_campus.campus_code, tbl_college.college_code, tbl_course.course_code, tbl_user_detail.year_level, tbl_user_detail.image_path
from tbl_user_detail, tbl_course, tbl_campus, tbl_college
where tbl_user_detail.user_detail_id = '$user_detail_id' and tbl_course.course_id = tbl_user_detail.course_id and tbl_college.college_id = tbl_user_detail.college_id and tbl_campus.campus_id = tbl_user_detail.campus_id")->result_array()[0];
    }

    public function get_user_activities($id) {
        $this->db->from("tbl_user_post");
        $this->db->where(array(
            "user_detail_id" => $id
        ));
        $this->db->order_by("date_time_stamp","DESC");
        $activities = $this->db->get()->result_array();

        $posts = [];

        foreach($activities as $activity) {
            $post = $this->db->get_where("tbl_post",array("post_id" => $activity["post_id"],"status"=>"posted"))->result_array();
            if (count($post)) {
                $post = $post[0];
                $post["type"] = $activity["type"];
                $post["images"] = $this->db->get_where("tbl_post_image",array("post_id" => $activity["post_id"],"status"=>"posted"))->result_array();
                $post["reference_id"] = $activity["reference_id"]; 
    
                $posts[] = $post;
            }
        }

        return $posts;

    }

}