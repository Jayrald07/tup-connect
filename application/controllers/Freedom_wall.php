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

        if ($this->post->report($data)) redirect(base_url("index.php/") . "fw/view_post");
        else redirect(base_url("index.php/") . "fw");
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

        if ($this->post->user_report($data)) redirect(base_url("index.php/") . "fw/view_post");
        else redirect(base_url("index.php/") . "fw");
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

        if ($this->post->submit($data)) redirect(base_url("index.php/") . "fw");
        else redirect(base_url("index.php/") . "fw/create");
    }
}
