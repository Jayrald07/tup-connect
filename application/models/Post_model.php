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

    public function save($data)
    {
        $this->db->set("post_text", $data["content"]);
        $this->db->where("post_id", $data["post_id"]);
        return $this->db->update("tbl_post");
    }

    public function remove_post($post_id)
    {
        $this->db->set("status", "removed");
        $this->db->where("post_id", $post_id);
        return $this->db->update("tbl_post");
    }

    public function get_post_front($post_id)
    {
        $this->db->select("post_id, post_text");
        $this->db->where("post_id", $post_id);
        $query = $this->db->get("tbl_post");
        return $query->result_array();
    }

    // public function get_comments($post_id)

    public function get_posts($type, $id)
    {
        switch ($type) {
            case 'groups':
                $query = $this->db->query("SELECT tbl_post.* , tbl_user_detail.first_name,tbl_user_detail.last_name,tbl_user_detail.middle_name
FROM tbl_lobby_post, tbl_lobby, tbl_post, tbl_user_detail
WHERE tbl_lobby.group_id = '" . $id . "' and tbl_lobby_post.lobby_id = tbl_lobby.lobby_id and tbl_post.post_id = tbl_lobby_post.post_id and tbl_post.status = 'posted' and tbl_user_detail.user_detail_id = tbl_lobby.user_detail_id ORDER BY tbl_post.date_time_stamp desc");
                return $query->result_array();
        }
    }

    // public function get_posts($type)
    // {
    //     switch ($type) {
    //         case 'lobby':
    //             $query = $this->db->query("
    //             select tbl_lobby.user_detail_id, tbl_lobby_post.category_id, tbl_post.*
    //             from tbl_lobby, tbl_lobby_post, tbl_post
    //             where 
    //                 tbl_lobby.lobby_id = tbl_lobby_post.lobby_id and tbl_lobby_post.post_id = tbl_post.post_id and tbl_post.status = 'posted'
    //                 ORDER BY tbl_post.date_time_stamp desc");
    //             return $query->result_array();
    //             break;
    //         case 'fw':
    //             $query = $this->db->query("
    //             select tbl_freedom_wall.user_detail_id, tbl_freedom_wall.fw_id, tbl_post.*
    //             from tbl_freedom_wall, tbl_post
    //             where tbl_freedom_wall.post_id = tbl_post.post_id and tbl_post.status = 'posted'
    //             order by tbl_post.date_time_stamp desc");
    //             return $query->result_array();
    //             break;

    //         case 'forum':
    //             $query = $this->db->query("
    //             select tbl_forum.user_detail_id, tbl_forum.forum_id, tbl_forum.category_id, tbl_post.*
    //             from tbl_forum, tbl_post
    //             where tbl_forum.post_id = tbl_post.post_id and tbl_post.status = 'posted'
    //             order by tbl_post.date_time_stamp desc");
    //             return $query->result_array();
    //             break;
    //     }
    // }
}
