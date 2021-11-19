<?php

class Comment_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function set_new_comment($data)
    {
        return $this->db->insert("tbl_comment", $data);
    }

    public function get_comment()
    {
        $query = $this->db->query("
                select tbl_post.post_id, tbl_comment.*
                from tbl_post, tbl_comment
                where tbl_post.post_id = tbl_comment.post_id and tbl_comment.status = 'submitted'
                order by tbl_comment.date_time_stamp desc");
                return $query->result_array();
    }
}
