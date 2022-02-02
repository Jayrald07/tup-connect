<?php

class Organization extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('post', 'session'));
        $this->load->model("organization_model");
    }

    public function get_orgs()
    {
        $data["org_joined"] = $this->organization_model->get_joined_org($this->session->userdata("user_detail_id"));
        $data["org_owned"] = $this->organization_model->get_owned_org($this->session->userdata("user_detail_id"));

        return $data;
    }

    public function index()
    {
        if (empty(trim($this->session->userdata("user_detail_id")))) redirect("login");

        $data = $this->get_orgs();

        $data["type"] = "org";
        $data["posts"] = [];
        $data['org_id'] = NULL;
        $data["startup"] = TRUE;
        $data["user_photo"] = $this->session->userdata("user_photo");



        $this->load->view("view_post", $data);
    }


    public function org($org_id)
    {

        if (empty(trim($this->session->userdata("user_detail_id")))) redirect("login");

        $this->session->set_userdata(array(
            "type" => "org",
            "id" => $org_id
        ));
        $data = $this->get_orgs();
        $data["type"] = "org";
        $data['org_id'] = $org_id;
        $data["pin_post"] = $this->input->get("pin");
        $data["posts"] = $this->post_model->get_posts("org", $org_id);
        $data["user_photo"] = $this->session->userdata("user_photo");

        $this->load->view("view_post", $data);
    }


    public function post()
    {
        $date_stamp = new DateTime("now", new DateTimeZone("Asia/Manila"));
        $post_id = random_string("alnum", 15);
        $organization_post_id = random_string("alnum", 15);
        $i = 0;
        $post_images = [];

        if (!empty($_FILES["post-image"]["name"][0])) {
            foreach ($_FILES["post-image"]["name"] as $key) {
                $exploded = explode(".", $key);
                $extension = $exploded[count($exploded) - 1];
                $post_images[$i] = random_string("alnum", 15) . '.' . $extension;
                $i++;
            }
        }

        $data = array(
            "type" => "org",
            "organization_post_id" => $organization_post_id,
            "organization_id" => $this->session->userdata("id"),
            "user_detail_id" => $this->session->userdata("user_detail_id"),
            "post_id" => $post_id,
            "post_text" => $this->input->post("post-content"),
            "date_time_stamp" => $date_stamp->format("Y-m-d H:i:s"),
            "status" => "posted",
            "post_up_vote" => 0,
            "post_down_vote" => 0,
            "post_image_path" => $post_images,
        );

        if ($this->post->submit($data)) {
            if (count($post_images)) {
                $done = 0;
                for ($i = 0; $i < count($post_images); $i++) {
                    $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'gif|jpg|png';

                    $config["file_name"]             = explode(".", $post_images[$i])[0];

                    $_FILES["p-image"]["name"] = $_FILES["post-image"]["name"][$i];
                    $_FILES["p-image"]["type"] = $_FILES["post-image"]["type"][$i];
                    $_FILES["p-image"]["tmp_name"] = $_FILES["post-image"]["tmp_name"][$i];
                    $_FILES["p-image"]["error"] = $_FILES["post-image"]["error"][$i];
                    $_FILES["p-image"]["size"] = $_FILES["post-image"]["size"][$i];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('p-image')) echo $this->upload->display_errors();
                    $done++;
                }
                if (count($post_images) == $done) redirect(base_url("index.php/organizations/") . $this->session->userdata("id"));
            } else redirect(base_url("index.php/organizations/") . $this->session->userdata("id"));
        }
    }
}
