<?php
class Lobby extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('post', 'session'));
        $this->load->model("post_model");
    }

    public function index()
    {
        $data["type"] = "lobby";
        $data["posts"] = $this->post->get_posts('lobby');
        $this->load->view("view_post", $data);
    }

    public function create()
    {

        $this->post->create_form(array(
            "group" => true,
            "campus" => true,
            "college" => true,
            "category" => false,
            "type" => "lobby"
        ));
    }

    public function edit($post_id)
    {
        $data["post"] = $this->post_model->get_post_front($post_id);
        $data["type"] = "lobby";
        $this->load->view("edit_post", $data);
    }

    public function save()
    {
        if ($this->post_model->save(array(
            "content" => $this->input->post("content"),
            "post_id" => $this->input->post("post_id")

        ))) redirect(base_url("index.php/") . "lobby");
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

        if ($this->post->report($data)) redirect(base_url("index.php/") . "lobby/view_post");
        else redirect(base_url("index.php/") . "lobby");
    }

    public function user_report($user_detail_id)
    {
        $report_id = random_string('alnum', 15);
        $user_report_id = random_string('alnum', 15);

        $data = array(
            "certain" => array(
                "report_id" => $report_id,
                "report_description" => $this->input->post('report_description'),
            ),
            "report_id" => $report_id,
            "report_description" => $this->input->post('report_description'),

            "certain1" => array(
                "user_report_id" => $user_report_id,
                "user_detail_id" => $this->session->userdata('user_id'),
                "reported_user_id" => $user_detail_id,
                "report_id" => $report_id,
            ),
        );

        if ($this->post->user_report($data)) redirect(base_url("index.php/") . "lobby/view_post");
        else redirect(base_url("index.php/") . "lobby");
    }

    public function remove($post_id)
    {
        if ($this->post->remove_post($post_id)) redirect(base_url("index.php/") . "lobby");
    }

    public function submit()
    {
        $date = new DateTime('now');
        $lobby_id = random_string('alnum', 15);

        $data = array(
            "allowed" => "*",
            "type" => 'lobby',
            "lobby_id" => $lobby_id,
            "certain" => array(
                "lobby_id" => $lobby_id,
                "group_id" => $this->input->post('group'),
                "user_detail_id" => $this->session->userdata('user_detail_id'),
                "campus_id" => $this->input->post("campus"),
                "college_id" => $this->input->post("college"),
            ),
            "post_id" => random_string('alnum', 15),
            "post_text" => $this->input->post('content'),
            "post_up_vote" => 0,
            "post_down_vote" => 0,
            "date_time_stamp" => $date->format("Y-m-d H:i:s"),
            "status" => "posted",
            "lobby_post_id" => random_string('alnum', 15),
            "category_id" => $this->input->post("category")
        );

        if ($this->post->submit($data)) redirect(base_url("index.php/") . "lobby");
        else redirect(base_url("index.php/") . "lobby/create");
    }
}
