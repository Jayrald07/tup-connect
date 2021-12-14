<?php

class Post_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function vote()
    {
        $this->load->library("session");
        $this->load->model("post_model");
        $val = $this->input->post();
        $val["user_detail_id"] = $this->session->userdata("user_detail_id");

        echo json_encode($this->post_model->vote($val));
    }

    public function report()
    {
        $this->load->library(array(
            "session",
            "post"
        ));

        $this->load->helper("string");

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
                "post_id" => $this->input->post('post_id'),
                "user_detail_id" => $this->session->userdata("user_detail_id"),
                "report_id" => $report_id,
            ),
        );

        if ($this->post->report($data)) echo "success";
        else echo "error";
    }

    public function user_report()
    {
        $this->load->library(array(
            "session",
            "post"
        ));

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
                "user_detail_id" => $this->session->userdata('user_detail_id'),
                "reported_user_id" => $this->input->post('user_detail_id'),
                "report_id" => $report_id,
            ),
        );

        if ($this->post->user_report($data)) echo "success";
        else echo "error";
    }

    public function delete_post() {
        $this->load->model("post_model");

        if ($this->post_model->delete_post($this->input->post("post_id"))) echo "success";
        else "error";
    }

    public function is_allowed_deletion() {
        $this->load->library("session");
        $user_detail_id = $this->session->userdata("user_detail_id");
        echo $this->input->post("user_detail_id") == $user_detail_id;
    }

    public function get_post() {
        $this->load->model("post_model");
        echo json_encode($this->post_model->get_post($this->input->post("post_id")));
    }

}
