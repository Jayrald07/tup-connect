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
                "status" => 1
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

    public function block_user()
    {

        $this->load->library("session");
        $this->load->helper("string");
        $this->load->model("post_model");

        $data = array(
            "user_block_id" => random_string("alnum", 15),
            "user_detail_id" => $this->session->userdata("user_detail_id"),
            "blocked_user_id" => $this->input->post("user_detail_id"),
            "block_id" => random_string("alnum", 15),
            "block_description" => $this->input->post("block_description")
        );

        if ($this->post_model->block_user($data)) echo "success";
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

    public function delete_post()
    {
        $this->load->model("post_model");

        if ($this->post_model->delete_post($this->input->post("post_id"))) echo "success";
        else "error";
    }

    public function is_allowed_deletion()
    {
        $this->load->library("session");
        $user_detail_id = $this->session->userdata("user_detail_id");
        echo $this->input->post("user_detail_id") == $user_detail_id;
    }

    public function get_post()
    {
        $this->load->model("post_model");
        echo json_encode($this->post_model->get_post($this->input->post("post_id")));
    }

    public function update_post()
    {
        $this->load->model("post_model");
        $this->load->helper("string");
        $data = array(
            "post_id" => $this->input->post("post_id"),
            "post_text" => $this->input->post("post_text"),
            "post_image_ids_delete" => explode(",", $this->input->post("post_image_ids_delete")),
            "post_image_add" => isset($_FILES["post_image_add"]) ? $_FILES["post_image_add"] : []
        );

        $this->post_model->update_post(array(
            "post_text" => $data["post_text"],
            "post_id" => $data["post_id"]
        ));

        foreach ($data["post_image_ids_delete"] as $image_id) $this->post_model->delete_image($image_id);

        if (count($data["post_image_add"])) {
            $i = 0;
            $post_images = [];
            $done = 0;

            if (!empty($_FILES["post_image_add"]["name"][0])) {
                foreach ($_FILES["post_image_add"]["name"] as $key) {
                    $exploded = explode(".", $key);
                    $extension = $exploded[count($exploded) - 1];
                    $post_images[$i] = random_string("alnum", 15) . '.' . $extension;
                    $i++;
                }
            }

            $is_inserted = $this->post_model->insert_image(array(
                "post_id" => $data["post_id"],
                "post_image_path" => $post_images
            ));

            if ($is_inserted) {
                for ($i = 0; $i < count($post_images); $i++) {
                    $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'gif|jpg|png';

                    $config["file_name"]             = explode(".", $post_images[$i])[0];

                    $_FILES["p-image"]["name"] = $_FILES["post_image_add"]["name"][$i];
                    $_FILES["p-image"]["type"] = $_FILES["post_image_add"]["type"][$i];
                    $_FILES["p-image"]["tmp_name"] = $_FILES["post_image_add"]["tmp_name"][$i];
                    $_FILES["p-image"]["error"] = $_FILES["post_image_add"]["error"][$i];
                    $_FILES["p-image"]["size"] = $_FILES["post_image_add"]["size"][$i];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('p-image')) echo $this->upload->display_errors();
                    $done++;
                }

                echo "success";
            } else echo "error";
        } else echo "success";
    }
}
