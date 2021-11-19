<?php

class Comment
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->model("comment_model");
        $this->CI->load->helper(array('form', 'url', 'string'));
        $this->CI->load->library(array("form_validation", 'upload'));
    }

    public function submit_comment($data)
    {
        $this->CI->comment_model->set_new_comment($data["certain"]);
    }
}