<?php
class Forum extends CI_Controller
{

    private $mock_session_data = array('user_id' => 'u123');

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('post', 'session'));
    }

    public function index()
    {
        $this->session->set_userdata($this->mock_session_data);
        $data["type"] = "forum";
        $data["posts"] = $this->post->get_posts('forum');

        $this->load->view("view_post", $data);
    }

    public function edit($post_id)
    {
        $data["post"] = $this->post_model->get_post_front($post_id);
        $data["type"] = "forum";
        $this->load->view("edit_post", $data);
    }

    public function save()
    {
        if ($this->post_model->save(array(
            "content" => $this->input->post("content"),
            "post_id" => $this->input->post("post_id")
        ))) redirect("./forum");
    }

    public function report($post_id)
    {
        $data["post"] = $this->post_model->get_post_front($post_id);
        $report_id = random_string('alnum', 15);
        $post_report_id = random_string('alnum', 15);

        $data = array(
            "certain" => array(
                "report_id" => $report_id,
                "report_description" => $this->input->post('report_description'),
            ),
            "report_id" => $report_id,
            "report_description" => $this->input->post('report_description'),
            
            "certain1" => array(
                "post_report_id" => $post_report_id,
                "post_id" => $post_id,
                "report_id" => $report_id,
            ),
        );  

        if ($this->post->report($data)) redirect("./fw/view_post");
        else redirect("./fw");
    }

    public function user_report(){
        $report_id = random_string('alnum', 15);

        $data = array(
            "certain" => array(
                "report_id" => $report_id,
                "report_description" => $this->input->post('report_description'),
            ),
            "report_id" => $report_id,
            "report_description" => $this->input->post('report_description'),
        );

        if ($this->post->user_report($data)) redirect("./fw/view_post");
        else redirect("./fw");
    }

    public function create()
    {

        $this->post->create_form(array(
            "group" => false,
            "campus" => false,
            "college" => false,
            "category" => true,
            "type" => "forum"
        ));
    }

    public function submit()
    {
        $date = new DateTime('now');
        $post_id = random_string('alnum', 15);

        $data = array(
            "allowed" => "*",
            "type" => 'forum',
            "certain" => array(
                "forum_id" => random_string('alnum', 15),
                "user_detail_id" => $this->session->userdata('user_id'),
                "category_id" => $this->input->post("category"),
                "post_id" => $post_id,
            ),
            "post_id" => $post_id,
            "post_text" => $this->input->post('content'),
            "post_up_vote" => 0,
            "post_down_vote" => 0,
            "date_time_stamp" => $date->format("Y-m-d H:i:s"),
            "status" => "posted",
        );

        if ($this->post->submit($data)) redirect("./forum");
        else redirect("./forum/create");
    }
}
