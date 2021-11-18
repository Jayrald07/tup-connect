<?php
class Post
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->model("post_model");
        $this->CI->load->helper(array('form', 'url', 'string'));
        $this->CI->load->library(array("form_validation", 'upload'));
    }

    public function get_posts($type)
    {
        return $this->CI->post_model->get_posts($type);
    }

    public function create_form($allowed_inputs)
    {
        $data = array();
        if ($allowed_inputs["group"]) $data['groups'] = $this->CI->post_model->get_groups();
        if ($allowed_inputs["campus"]) $data['campuses'] = $this->CI->post_model->get_campuses();
        if ($allowed_inputs["college"]) $data['colleges'] = $this->CI->post_model->get_colleges();
        if ($allowed_inputs["category"]) $data['categories'] = $this->CI->post_model->get_categories();

        $data['allowed'] = $allowed_inputs;

        $this->CI->load->view('create_post', $data);
    }


    public function store_image($filename)
    {
    }

    public function remove_post($post_id)
    {
        return $this->CI->post_model->remove_post($post_id);
    }

    public function report($data)
    {
        $this->CI->post_model->set_new_report($data["certain"]);
        $this->CI->post_model->set_new_post_report($data["certain1"]);
    }
    
    public function user_report($data)
    {
        $this->CI->post_model->set_new_report($data["certain"]);
        $this->CI->post_model->set_new_user_report($data["certain1"]);
    }

    public function submit($data)
    {

        $first = $this->CI->post_model->set_new_type($data["certain"], $data["type"]);
        $second = $this->CI->post_model->set_new_post(array(
            "post_id" => $data["post_id"],
            "post_text" => $data["post_text"],
            "post_up_vote" => $data["post_up_vote"],
            "post_down_vote" => $data["post_down_vote"],
            "date_time_stamp" => $data["date_time_stamp"],
            "status" => $data["status"],
        ));

        $third = FALSE;

        if ($data['type'] == 'lobby') {
            $third = $this->CI->post_model->set_new_lobby_post(array(
                "lobby_post_id" => $data["lobby_post_id"],
                "lobby_id" => $data["lobby_id"],
                "category_id" => $data["category_id"] || 0,
                "post_id" => $data["post_id"],
            ));
        }

        if ($first && $second) {
            if ($data["type"] == 'lobby') {
                if ($third) return true;
                else return false;
            } else return true;
        } else return false;
    }
}
