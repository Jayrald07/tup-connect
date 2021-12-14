<?php
class Post
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->model("post_model");
        $this->CI->load->helper(array('form', 'url', 'string'));
        $this->CI->load->library(array("form_validation", 'upload', 'session'));
    }

    public function get_posts($type)
    {
        return $this->CI->post_model->get_posts($type);
    }


    public function report($data)
    {
        return $this->CI->post_model->set_new_report($data["certain"]) &&  $this->CI->post_model->set_new_post_report($data["certain1"]);
    }

    public function user_report($data)
    {
        return $this->CI->post_model->set_new_report($data["certain"]) && $this->CI->post_model->set_new_user_report($data["certain1"]);
    }


    public function submit($data)
    {

        switch ($data["type"]) {
            case 'lobby':
                return $this->CI->post_model->submit($data["type"], $data);
                break;
        }
    }

    public function insert_comment($data)
    {
        return $this->CI->post_model->insert_comment($data);
    }


    public function get_comments($post_id)
    {
        return $this->CI->post_model->get_comments($post_id);
    }
}
