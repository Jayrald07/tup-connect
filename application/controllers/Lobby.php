<?php
class Lobby extends CI_Controller
{

    private $mock_session_data = array('user_id' => 'u123');

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('post', 'session'));
        $this->load->model("post_model");
    }

    public function index()
    {
        $this->session->set_userdata($this->mock_session_data);

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
        ))) redirect("./lobby");
    }

    public function remove($post_id)
    {
        if ($this->post->remove_post($post_id)) redirect("./lobby");
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
                "user_detail_id" => $this->session->userdata('user_id'),
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

        if ($this->post->submit($data)) redirect("./lobby");
        else redirect("./lobby/create");
    }
}
