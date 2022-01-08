<?php

class Post_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_table_per_type($type)
    {
        if ($type == 'lobby') return 'tbl_lobby';
        if ($type == 'fw') return 'tbl_freedom_wall';
        if ($type == 'forum') return 'tbl_forum';
    }

    public function set_new_type($data, $type)
    {
        return $this->db->insert($this->get_table_per_type($type), $data);
    }

    public function set_new_post($data)
    {
        return $this->db->insert("tbl_post", $data);
    }

    public function set_new_lobby_post($data)
    {
        return $this->db->insert("tbl_lobby_post", $data);
    }

    public function set_new_post_image($post_image_id, $post_id)
    {
        $data = array(
            "post_image_id" => $post_image_id,
            "post_id" => $post_id,
            "post_image_path" => $post_image_id
        );
        return $this->db->insert("tbl_post_image", $data);
    }

    public function set_new_report($data)
    {
        return $this->db->insert("tbl_report", $data);
    }

    public function set_new_post_report($data)
    {
        $this->db->set("report_status",1);
        $this->db->where("post_id",$data["post_id"]);
        $this->db->update("tbl_post");
        return $this->db->insert("tbl_post_report", $data);
    }

    public function set_new_user_report($data)
    {
        return $this->db->insert("tbl_user_report", $data);
    }

    public function get_user_id_fw()
    {
        $this->load->database("tbl_freedom_wall");
        $data = $this->db->get('user_detail_id');
        return $data->result();
    }

    public function get_owned_groups($user_detail_id)
    {
        $query = $this->db->get_where('tbl_group', array('group_owner' => $user_detail_id));
        return $query->result_array();
    }

    public function get_joined_groups($user_detail_id)
    {
        $query = $this->db->query("SELECT tbl_group.group_id, tbl_group.group_name 
FROM tbl_group, tbl_group_user
WHERE tbl_group_user.user_detail_id = '" . $user_detail_id . "' and tbl_group.group_id = tbl_group_user.group_id and tbl_group_user.status = 1");
        return $query->result_array();
    }

    public function get_campuses()
    {
        $query = $this->db->get("tbl_campus");
        return $query->result_array();
    }

    public function get_colleges()
    {
        $query = $this->db->get("tbl_college");
        return $query->result_array();
    }

    public function get_categories()
    {
        $query = $this->db->get("tbl_category");
        return $query->result_array();
    }

    public function get_post_front($post_id)
    {
        $this->db->select("post_id, post_text");
        $this->db->where("post_id", $post_id);
        $query = $this->db->get("tbl_post");
        return $query->result_array();
    }

    public function get_posts($type, $id)
    {
        $posts = [];
        $query = "";
        switch ($type) {
            case 'groups':
                $query = $this->db->query("SELECT tbl_post.* , tbl_user_detail.first_name,tbl_user_detail.last_name,tbl_user_detail.middle_name, tbl_user_detail.user_detail_id,tbl_user_detail.image_path
FROM tbl_lobby_post, tbl_lobby, tbl_post, tbl_user_detail
WHERE tbl_lobby.group_id = '" . $id . "' and tbl_lobby_post.lobby_id = tbl_lobby.lobby_id and tbl_post.post_id = tbl_lobby_post.post_id and tbl_post.status = 'posted' and (tbl_post.report_status = 0 or tbl_post.report_status = 1) and tbl_user_detail.user_detail_id = tbl_lobby.user_detail_id ORDER BY tbl_post.date_time_stamp desc");
                break;
            case 'org':
                $query = $this->db->query("SELECT tbl_organization_post.organization_post_id, tbl_organization_post.user_detail_id,tbl_organization_post.organization_id, tbl_post.*, tbl_user_detail.user_detail_id,tbl_user_detail.first_name, tbl_user_detail.middle_name, tbl_user_detail.last_name,tbl_user_detail.image_path
FROM tbl_organization_post, tbl_post, tbl_user_detail
where tbl_organization_post.organization_id = '" . $id . "' and tbl_post.post_id = tbl_organization_post.post_id and tbl_user_detail.user_detail_id = tbl_organization_post.user_detail_id and tbl_post.status = 'posted' order  by tbl_post.date_time_stamp desc");
                break;
            case 'fw':
                $query = $this->db->query("SELECT tbl_freedom_wall.fw_id, tbl_post.*,tbl_user_detail.user_detail_id,tbl_user_detail.image_path
FROM tbl_freedom_wall, tbl_post, tbl_user_detail
WHERE tbl_user_detail.user_detail_id = tbl_freedom_wall.user_detail_id and tbl_post.post_id = tbl_freedom_wall.post_id and tbl_post.status = 'posted' order by tbl_post.date_time_stamp desc");
                break;
            case 'forum':
                $query = $this->db->query("SELECT tbl_forum.forum_id, tbl_forum.category_id, tbl_forum.user_detail_id, tbl_post.*, tbl_user_detail.first_name, tbl_user_detail.middle_name, tbl_user_detail.last_name,tbl_user_detail.image_path
FROM tbl_forum, tbl_post, tbl_user_detail
WHERE tbl_post.post_id = tbl_forum.post_id and tbl_post.status = 'posted' and tbl_user_detail.user_detail_id = tbl_forum.user_detail_id and tbl_forum.category_id = " . $id . " order by tbl_post.date_time_stamp desc");
                break;
        }
        $posts = $query->result_array();

        for ($i = 0; $i < count($posts); $i++) {
            $posts[$i]["comments_count"] = count($this->get_comments($posts[$i]["post_id"]));
            $posts[$i]["post_image_path"] = count($this->get_image($posts[$i]["post_id"])) > 0 ? $this->get_image($posts[$i]["post_id"]) : [];
        }
        return $posts;
    }

    public function get_image($post_id)
    {
        return $this->db->get_where("tbl_post_image", array(
            "post_id" => $post_id,
            "status" => "posted"
        ))->result_array();
    }

    public function find_vote($user_detail_id, $post_id)
    {
        return $this->db->get_where("tbl_user_vote", array(
            "user_detail_id" => $user_detail_id,
            "post_id" => $post_id
        ))->result_array();
    }

    public function vote($data)
    {
        $vote = $this->find_vote($data["user_detail_id"], $data["post_id"]);
        if (count($vote)) {
            if ($vote[0]["user_vote"] == 1) {
                if ($data["vote_type"] == "up") {
                    $this->db->query("UPDATE tbl_post SET post_up_vote = post_up_vote - 1 WHERE post_id = '" . $data["post_id"] . "'");
                    $this->db->query("UPDATE tbl_user_vote SET user_vote = -1 WHERE user_vote_id = " . $vote[0]["user_vote_id"]);
                } else {
                    $this->db->query("UPDATE tbl_post SET post_up_vote = post_up_vote - 1, post_down_vote = post_down_vote + 1 WHERE post_id = '" . $data["post_id"] . "'");
                    $this->db->query("UPDATE tbl_user_vote SET user_vote = 0 WHERE user_vote_id = " . $vote[0]["user_vote_id"]);
                }
            } else if ($vote[0]["user_vote"] == 0) {
                if ($data["vote_type"] == "up") {
                    $this->db->query("UPDATE tbl_post SET post_up_vote = post_up_vote + 1, post_down_vote = post_down_vote - 1 WHERE post_id = '" . $data["post_id"] . "'");
                    $this->db->query("UPDATE tbl_user_vote SET user_vote = 1 WHERE user_vote_id = " . $vote[0]["user_vote_id"]);
                } else {
                    $this->db->query("UPDATE tbl_post SET post_down_vote = post_down_vote - 1 WHERE post_id = '" . $data["post_id"] . "'");
                    $this->db->query("UPDATE tbl_user_vote SET user_vote = -1 WHERE user_vote_id = " . $vote[0]["user_vote_id"]);
                }
            } else if ($vote[0]["user_vote"] == -1) {
                if ($data["vote_type"] == "up") {
                    $this->db->query("UPDATE tbl_post SET post_up_vote = post_up_vote + 1 WHERE post_id = '" . $data["post_id"] . "'");
                    $this->db->query("UPDATE tbl_user_vote SET user_vote = 1 WHERE user_vote_id = " . $vote[0]["user_vote_id"]);
                } else {
                    $this->db->query("UPDATE tbl_post SET post_down_vote = post_down_vote + 1 WHERE post_id = '" . $data["post_id"] . "'");
                    $this->db->query("UPDATE tbl_user_vote SET user_vote = 0 WHERE user_vote_id = " . $vote[0]["user_vote_id"]);
                }
            }
        } else {
            if ($data["vote_type"] == "up") {
                $this->db->query("UPDATE tbl_post SET post_up_vote = post_up_vote + 1 WHERE post_id = '" . $data["post_id"] . "'");
                $this->db->insert("tbl_user_vote", array(
                    "post_id" => $data["post_id"],
                    "user_detail_id" => $data["user_detail_id"],
                    "user_vote" => 1
                ));
            } else {
                $this->db->query("UPDATE tbl_post SET post_down_vote = post_down_vote + 1 WHERE post_id = '" . $data["post_id"] . "'");
                $this->db->insert("tbl_user_vote", array(
                    "post_id" => $data["post_id"],
                    "user_detail_id" => $data["user_detail_id"],
                    "user_vote" => 0
                ));
            }
        }

        return $this->get_vote($data["post_id"]);
    }

    public function get_vote($post_id)
    {
        $this->db->select("post_up_vote,post_down_vote");
        $this->db->where(array(
            "post_id" => $post_id
        ));
        return $this->db->get("tbl_post")->result_array();
    }

    public function insert_comment($data)
    {
        return $this->db->insert("tbl_comment", $data);
    }

    public function get_comments($post_id)
    {
        return $this->db->query("SELECT tbl_comment.*, tbl_user_detail.first_name, tbl_user_detail.last_name, tbl_user_detail.image_path FROM tbl_comment, tbl_user_detail WHERE tbl_comment.post_id = '" . $post_id . "' and tbl_comment.status = 'commented' and tbl_user_detail.user_detail_id = tbl_comment.user_detail_id")->result_array();
    }

    public function insert_image($data)
    {
        if (count($data["post_image_path"])) {
            foreach ($data["post_image_path"] as $image) {
                $this->db->insert("tbl_post_image", array(
                    "post_id" => $data["post_id"],
                    "post_image_path" => $image,
                    "status" => "posted"
                ));
            }
            return true;
        }
    }

    public function delete_image($image_id)
    {
        $this->db->set("status", "deleted");
        $this->db->where("post_image_id", $image_id);
        return $this->db->update("tbl_post_image");
    }

    public function update_post($data)
    {
        $this->db->set(array(
            "post_text" => $data["post_text"]
        ));
        $this->db->where(array(
            "post_id" => $data["post_id"]
        ));
        return $this->db->update("tbl_post");
    }

    public function submit($type, $data)
    {
        $i = 0;
        $reference_id = NULL;
        switch ($type) {
            case 'lobby':

                $this->db->insert("tbl_lobby", array(
                    "lobby_id" => $data["lobby_id"],
                    "group_id" => $data["group_id"],
                    "user_detail_id" => $data["user_detail_id"],
                    "campus_id" => $data["campus_id"],
                    "college_id" => $data["college_id"],
                ));

                $this->db->insert("tbl_lobby_post", array(
                    "lobby_id" => $data['lobby_id'],
                    "category_id" => $data["category_id"],
                    "post_id" => $data["post_id"],
                ));

                $i = 1;
                $reference_id = $data["group_id"];

                break;
            case 'org':
                $this->db->insert("tbl_organization_post", array(
                    "organization_post_id" => $data["organization_post_id"],
                    "user_detail_id" => $data["user_detail_id"],
                    "organization_id" => $data["organization_id"],
                    "post_id" => $data["post_id"]
                ));
                $i = 2;
                $reference_id = $data["organization_id"];
                break;
            case 'fw':
                $this->db->insert("tbl_freedom_wall", array(
                    "fw_id" => $data["fw_id"],
                    "user_detail_id" => $data["user_detail_id"],
                    "post_id" => $data["post_id"]
                ));
                $i = 3;
                $reference_id = $data["fw_id"];
                break;
            case 'forum':
                $this->db->insert("tbl_forum", array(
                    "forum_id" => $data["forum_id"],
                    "category_id" => $data["category_id"],
                    "post_id" => $data["post_id"],
                    "user_detail_id" => $data["user_detail_id"]
                ));
                $i = 4;
                $reference_id = $data["category_id"];
                break;
        }

        $this->insert_image(
            array(
                "post_image_path" => $data["post_image_path"],
                "post_id" => $data["post_id"]
            )
        );
        if ($this->db->insert("tbl_post", array(
            "post_id" => $data["post_id"],
            "post_text" => $data["post_text"],
            "post_up_vote" => $data["post_up_vote"],
            "post_down_vote" => $data["post_down_vote"],
            "date_time_stamp" => $data["date_time_stamp"],
            "status" => $data["status"],
            "report_status" => 0,
        ))) {
            return $this->db->insert("tbl_user_post",array(
                "user_detail_id" => $data["user_detail_id"],
                "post_id" => $data["post_id"],
                "reference_id" => $reference_id,
                "date_time_stamp" => $data["date_time_stamp"],
                "type" => $i
            ));
        }
    }


    public function delete_post($post_id)
    {
        $this->db->set("status", "deleted");
        $this->db->where("post_id", $post_id);
        return $this->db->update("tbl_post");
    }

    public function get_post($post_id)
    {
        $post = $this->db->get_where("tbl_post", array(
            "post_id" => $post_id
        ))->result_array();

        $post[0]["post_image_path"] =
            count($this->get_image($post_id)) > 0 ? $this->get_image($post_id) : [];
        return $post;
    }


    public function block_user($data)
    {
        $this->db->insert("tbl_block", array(
            "block_id" => $data["block_id"],
            "block_description" => $data["block_description"]
        ));

        return $this->db->insert("tbl_user_block", array(
            "user_block_id" => $data["user_block_id"],
            "user_detail_id" => $data["user_detail_id"],
            "blocked_user_id" => $data["blocked_user_id"],
            "block_id" => $data["block_id"]
        ));
    }

    public function add_group($data) {
        return $this->db->insert("tbl_group",$data);
    }

    public function get_group_members_count($id) {
        $this->db->select("count(*) as members");
        $this->db->where(array(
            "group_id" => $id,
            "status" => 1
        ));
        return $this->db->get("tbl_group_user")->result_array();
    }

    public function user_group_status($uid,$gid) {
        return $this->db->get_where("tbl_group_user",array(
            "user_detail_id" => $uid,
            "group_id" => $gid
        ))->result_array();
    }

    public function search_group($data) {

        $categ = 'select * from tbl_group where group_name like "%'. $data["group_name"] .'%" ';

        if ($data["categories"] && count($data["categories"])) {
            for($i = 0;$i < count($data["categories"]);$i++) {
                if ($i === 0) $categ .= "and (category_id = " . $data["categories"][$i];
                $categ .= " or category_id = " . $data["categories"][$i];
            }
            $categ .= ")";
        }
        $res = $this->db->query($categ)->result_array();
        for($i = 0;$i < count($res);$i++) {
            $res[$i]["members"] = $this->get_group_members_count($res[$i]["group_id"])[0]["members"];
            $res[$i]["is_owner"] = $res[$i]["group_owner"] === $data["user_detail_id"] ? TRUE : FALSE;
            $val = $this->user_group_status($data["user_detail_id"],$res[$i]["group_id"]);
            $res[$i]["status"] = -1;
            if (count($val)) $res[$i]["status"] = $val[0]["status"];
        }

        return $res;

    }

    public function join_group($data) {

        $res = $this->db->get_where("tbl_group_user",array(
            "user_detail_id" => $data["user_detail_id"],
            "group_id" => $data["group_id"],
        ))->result_array();

        if (count($res)) {
            $this->db->set("status",0);
            $this->db->where(array(
            "user_detail_id" => $data["user_detail_id"],
            "group_id" => $data["group_id"],
            ));
            return $this->db->update("tbl_group_user");
        } else {
            return $this->db->insert("tbl_group_user",array(
                "user_detail_id" => $data["user_detail_id"],
                "role_id" => 0,
                "group_id" => $data["group_id"],
                "status" => 0
            ));
        }

    }

    public function cancel_group_request($data) {
        return $this->db->delete("tbl_group_user",$data);
    }

    public function get_group_members($id) {
        $mems =  $this->db->get_where("tbl_group_user",array(
            "group_id" => $id,
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
        }

        return $res;

    }

    public function remove_group_user($data) {
        $this->db->set(array(
            "status" => -1
        ));
        $this->db->where($data);
        return $this->db->update("tbl_group_user");
    }

    public function get_group($group_id) {
        return $this->db->get_where("tbl_group",array(
            "group_id" => $group_id
        ))->result_array();
    }

    public function get_group_user($data) {
        $res = $this->db->get_where("tbl_group_user",$data)->result_array();
        for($i = 0;$i < count($res);$i++) {
            $val = $this->db->get_where("tbl_user_detail",array(
                "user_detail_id" => $res[$i]["user_detail_id"]
            ))->result_array();
            $res[$i]["user_detail_id"] = $val[0]["user_detail_id"];
            $res[$i]["firstname"] = $val[0]["first_name"];
            $res[$i]["middlename"] = $val[0]["middle_name"];
            $res[$i]["lastname"] = $val[0]["last_name"];
        }
        return $res;
    }

    public function group_user_update_status($data,$status) {
        $this->db->set("status",$status);
        $this->db->where($data);
        return $this->db->update("tbl_group_user");
    }

    public function update_post_reported($data,$status) {
        $this->db->set("report_status",$status);
        $this->db->where("post_id",$data["post_id"]);
        if ($this->db->update("tbl_post")) {
            $val = $this->db->get_where("tbl_post_report",array(
                "post_id" => $data["post_id"]
            ))->result_array();
            $i = 0;
            foreach($val as $v) {
                $this->db->set("status",$status);
                $this->db->where("report_id",$v["report_id"]);
                if ($this->db->update("tbl_report")) $i++;
            }
            if ($i === count($val)) return true;
            else return false;
        }
    }

    public function get_user_role($group_id,$role) {
        $this->db->select("count(*) as count");
        $this->db->where(array(
            "group_id" => $group_id,
            "role_id" => $role
        ));
        return $this->db->get("tbl_group_user")->result_array();
    }

    public function get_reported_group_post($group_id) {
        $val = $this->db->get_where("tbl_lobby",array("group_id"=>$group_id))->result_array();
        $post_details = [];
        foreach($val as $v) {
            $p = $this->db->get_where("tbl_lobby_post",array("lobby_id" => $v["lobby_id"]))->result_array();

            foreach($p as $pt) {
                $data = array(
                    "post_id" => $pt["post_id"],
                    "user_detail_id" => $v["user_detail_id"]
                );
                $post_details[] = $data;
            }

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

    public function add_role($group_id,$role) {
        if ($this->db->insert("tbl_role",array(
            "role_name" => $role,
            "id_ref" => $group_id
        ))) {
            return $this->db->get_where("tbl_role",array(
            "role_name" => $role,
            "id_ref" => $group_id
            ))->result_array();
        }
    }

    public function delete_role($id) {
        return $this->db->delete("tbl_role",array(
            "role_id" => $id
        ));
    }

    public function get_group_user_roles($role_id,$group_id) {
        $user = $this->db->get_where("tbl_group_user",array(
            "role_id" => $role_id,
            "group_id" => $group_id,
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

    public function get_group_user_hasno_roles($group_id) {
        $user = $this->db->get_where("tbl_group_user",array(
            "group_id" => $group_id,
            "role_id" => -1,
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

    public function update_group_user_role($data) {
        $this->db->set(array(
            "role_id" => $data["role_id"]
        ));
        $this->db->where(array(
            "user_detail_id" => $data["user_detail_id"],
            "group_id" => $data["group_id"]
        ));
        if ($this->db->update("tbl_group_user")) {
            return count($this->db->get_where("tbl_group_user",array(
                "group_id" => $data["group_id"],
                "role_id" => $data["role_id"]
            ))->result_array());
        }
    }

    public function get_role_permissions($group_id) {
        $roles = $this->get_roles($group_id);
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
                "id_ref" => $group_id
            ));

            $val[0]["permissions"] = $this->db->get("tbl_role")->result_array();
        }
        return $val;
    }

    public function get_permission($role_id) {
        $this->db->select("member_request,reported_content,manage_roles,manage_permission");
            $this->db->where(array(
                "role_id" => $role_id
            ));
        return $this->db->get("tbl_role")->result_array();
    }

    public function toggle_permission($role_id,$value,$perm) {
        $this->db->set($perm,$value);
        $this->db->where("role_id",$role_id);
        return $this->db->update("tbl_role");
    }

    public function clear_permission($role_id) {
        $this->db->set(array(
            "member_request" => 0,
            "reported_content" => 0,
            "manage_roles" => 0,
            "manage_permission" => 0,
        ));
        $this->db->where("role_id",$role_id);
        return $this->db->update("tbl_role");
    }

    public function get_category_post_count($arr) {
        $data = $arr;
        $res = [];
        foreach($data as $dat) {
            $this->db->select("count(*) as count");
            $this->db->from("tbl_forum");
            $this->db->where("category_id",$dat["category_id"]);
            $val = $this->db->get()->result_array()[0];
            $val["category_id"] = $dat["category_id"];
            $val["category_name"] = $dat["category_name"];
            $res[] = $val;
        }

        return $res;

    }


}



