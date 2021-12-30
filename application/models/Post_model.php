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
WHERE tbl_group_user.user_detail_id = '" . $user_detail_id . "' and tbl_group.group_id = tbl_group_user.group_id");
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
                $query = $this->db->query("SELECT tbl_post.* , tbl_user_detail.first_name,tbl_user_detail.last_name,tbl_user_detail.middle_name, tbl_user_detail.user_detail_id
FROM tbl_lobby_post, tbl_lobby, tbl_post, tbl_user_detail
WHERE tbl_lobby.group_id = '" . $id . "' and tbl_lobby_post.lobby_id = tbl_lobby.lobby_id and tbl_post.post_id = tbl_lobby_post.post_id and tbl_post.status = 'posted' and tbl_user_detail.user_detail_id = tbl_lobby.user_detail_id ORDER BY tbl_post.date_time_stamp desc");
                break;
            case 'org':
                $query = $this->db->query("SELECT tbl_organization_post.organization_post_id, tbl_organization_post.user_detail_id,tbl_organization_post.organization_id, tbl_post.*, tbl_user_detail.user_detail_id,tbl_user_detail.first_name, tbl_user_detail.middle_name, tbl_user_detail.last_name
FROM tbl_organization_post, tbl_post, tbl_user_detail
where tbl_organization_post.organization_id = '" . $id . "' and tbl_post.post_id = tbl_organization_post.post_id and tbl_user_detail.user_detail_id = tbl_organization_post.user_detail_id and tbl_post.status = 'posted' order  by tbl_post.date_time_stamp desc");
                break;
            case 'fw':
                $query = $this->db->query("SELECT tbl_freedom_wall.fw_id, tbl_post.*,tbl_user_detail.user_detail_id
FROM tbl_freedom_wall, tbl_post, tbl_user_detail
WHERE tbl_user_detail.user_detail_id = tbl_freedom_wall.user_detail_id and tbl_post.post_id = tbl_freedom_wall.post_id and tbl_post.status = 'posted' order by tbl_post.date_time_stamp desc");
                break;
            case 'forum':
                $query = $this->db->query("SELECT tbl_forum.forum_id, tbl_forum.category_id, tbl_forum.user_detail_id, tbl_post.*, tbl_user_detail.first_name, tbl_user_detail.middle_name, tbl_user_detail.last_name
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
        return $this->db->query("SELECT tbl_comment.*, tbl_user_detail.first_name, tbl_user_detail.last_name FROM tbl_comment, tbl_user_detail WHERE tbl_comment.post_id = '" . $post_id . "' and tbl_comment.status = 'commented' and tbl_user_detail.user_detail_id = tbl_comment.user_detail_id")->result_array();
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
                    "post_id" => $data["post_id"]
                ));

                break;
            case 'org':
                $this->db->insert("tbl_organization_post", array(
                    "organization_post_id" => $data["organization_post_id"],
                    "user_detail_id" => $data["user_detail_id"],
                    "organization_id" => $data["organization_id"],
                    "post_id" => $data["post_id"]
                ));
                break;
            case 'fw':
                $this->db->insert("tbl_freedom_wall", array(
                    "fw_id" => $data["fw_id"],
                    "user_detail_id" => $data["user_detail_id"],
                    "post_id" => $data["post_id"]
                ));
                break;
            case 'forum':
                $this->db->insert("tbl_forum", array(
                    "forum_id" => $data["forum_id"],
                    "category_id" => $data["category_id"],
                    "post_id" => $data["post_id"],
                    "user_detail_id" => $data["user_detail_id"]
                ));
                break;
        }

        $this->insert_image(
            array(
                "post_image_path" => $data["post_image_path"],
                "post_id" => $data["post_id"]
            )
        );
        return $this->db->insert("tbl_post", array(
            "post_id" => $data["post_id"],
            "post_text" => $data["post_text"],
            "post_up_vote" => $data["post_up_vote"],
            "post_down_vote" => $data["post_down_vote"],
            "date_time_stamp" => $data["date_time_stamp"],
            "status" => $data["status"],
        ));
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
            "group_id" => $id
        ));
        return $this->db->get("tbl_group_user")->result_array();
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
        }

        return $res;

    }
}

