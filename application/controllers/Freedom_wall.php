<?php
class Freedom_wall extends CI_Controller
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
        $data["type"] = "fw";
        $data["posts"] = $this->post->get_posts('fw');

        $this->load->view("view_post", $data);
    }

    public function create()
    {

        $this->post->create_form(array(
            "group" => false,
            "campus" => false,
            "college" => false,
            "category" => false,
            "type" => "fw"

        ));
    }

    public function submit()
    {
        $date = new DateTime('now');
        $post_id = random_string('alnum', 15);

        $data = array(
            "allowed" => "*",
            "type" => 'fw',
            "certain" => array(
                "fw_id" => random_string('alnum', 15),
                "user_detail_id" => $this->session->userdata('user_id'),
                "post_id" => $post_id,
            ),
            "post_id" => $post_id,
            "post_text" => $this->input->post('content'),
            "post_up_vote" => 0,
            "post_down_vote" => 0,
            "date_time_stamp" => $date->format("Y-m-d H:i:s"),
            "status" => "posted",
        );

        if ($this->post->submit($data)) redirect("./fw");
        else redirect("./fw/create");
    }
}
