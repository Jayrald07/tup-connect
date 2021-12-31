<?php

use function PHPSTORM_META\map;

class Lobby extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('post', 'session'));
        $this->load->model("post_model");
    }

    public function post()
    {

        $date_stamp = new DateTime("now", new DateTimeZone("Asia/Manila"));
        $post_id = random_string("alnum", 15);
        $lobby_id = random_string("alnum", 15);
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
            "type" => "lobby",
            "lobby_id" => $lobby_id,
            "group_id" => $this->session->userdata("id"),
            "user_detail_id" => $this->session->userdata("user_detail_id"),
            "campus_id" => 0,
            "college_id" => 0,
            "category_id" => 0,
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
                if (count($post_images) == $done) redirect(base_url("index.php/groups/") . $this->session->userdata("id"));
            } else redirect(base_url("index.php/groups/") . $this->session->userdata("id"));
        }
    }

    public function insert_comment()
    {
        $date_stamp = new DateTime("now", new DateTimeZone("Asia/Manila"));
        $data = array(
            "comment_id" => random_string("alnum", 15),
            "post_id" => $this->input->post("post-id"),
            "comment_text" => $this->input->post("comment"),
            "comment_down_vote" => 0,
            "comment_up_vote" => 0,
            "user_detail_id" => $this->session->userdata("user_detail_id"),
            "date_time_stamp" => $date_stamp->format("Y-m-d H:i:s"),
            "status" => "commented"
        );
        echo $this->post->insert_comment($data);
    }

    public function get_comments()
    {
        echo json_encode($this->post->get_comments($this->input->post("post-id")));
    }

    private function get_groups()
    {
        $data["owned_groups"] = $this->post_model->get_owned_groups($this->session->userdata(
            "user_detail_id"
        ));
        $data["joined_groups"] = $this->post_model->get_joined_groups($this->session->userdata("user_detail_id"));

        return $data;
    }

    public function groups($group_id)
    {
        if (empty(trim($this->session->userdata("user_detail_id")))) redirect("login");

        $this->session->set_userdata(array(
            "type" => "group",
            "id" => $group_id
        ));
        $data = $this->get_groups();
        $data["type"] = "lobby";
        $data['group_id'] = $group_id;
        $data["categories"] = $this->post_model->get_categories();
        $data["posts"] = $this->post_model->get_posts("groups", $group_id);
        $data["members"] = $this->post_model->get_group_members($group_id);
        $this->load->view("view_post", $data);
    }

    public function index()
    {
        if (empty(trim($this->session->userdata("user_detail_id")))) redirect("login");

        $data = $this->get_groups();

        $data["type"] = "lobby";
        $data["posts"] = [];
        $data['group_id'] = NULL;
        $data["categories"] = $this->post_model->get_categories();

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

    public function add_group() {
        $data = array(
            "group_id" => random_string("alnum",15),
            "group_name" => $this->input->post("group-name"),
            "category_id" => $this->input->post("group-category"),
            "group_owner" => $this->session->userdata("user_detail_id")
        );

        if ($this->post_model->add_group($data)) redirect(base_url("index.php/groups"));
        else "error";
    }

    public function search_group() {
        $data = array(
            "group_name" => $this->input->post("group_name"),
            "categories" => $this->input->post("categories"),
            "user_detail_id" => $this->session->userdata("user_detail_id")
        );

        echo json_encode($this->post_model->search_group($data));
    }

    public function join_group() {
        $data = array(
            "group_id" => $this->input->post("group_id"),
            "user_detail_id" => $this->session->userdata("user_detail_id")
        );

        if ($this->post_model->join_group($data)) echo true;
        else echo false;
    }

    public function cancel_group_request() {
        $data = array(
            "group_id" => $this->input->post("group_id"),
            "user_detail_id" => $this->session->userdata("user_detail_id")
        );
        echo $this->post_model->cancel_group_request($data);
    }

    public function remove_group_user() {
        $data = array(
            "group_id" => $this->input->post("group_id"),
            "user_detail_id" => $this->input->post("user_detail_id")
        );
        echo $this->post_model->remove_group_user($data);
    }

    public function admin($group_id) {
        $this->session->set_userdata("group_id",$group_id);

        $val = $this->post_model->get_roles($group_id);
        for($i = 0;$i < count($val);$i++) {
            $r = $this->post_model->get_user_role($group_id,$val[$i]["role_id"]);
            if (count($r)) $val[$i]["count"] = $r[0]["count"];
        }

        $data = array(
            "group_id" => $group_id,
            "group_details" => $this->post_model->get_group($group_id),
            "member_request" => $this->post_model->get_group_user(array(
            "group_id" => $group_id,
            "status" => 0,
            )),
            "reported_posts" => $this->post_model->get_reported_group_post($group_id),
            "role" => $val
        );


        $this->load->view("admin",$data);
    }

    public function group_user_update_status() {

        if ($this->input->post("isBulk") === true) {
            $val = $this->input->post("user_detail_id");
            $i = 0;
            foreach($val as $v) {
                $data = array(
                    "group_id" => $this->session->userdata("group_id"),
                    "user_detail_id" => $v,
                );

                $status = $this->input->post("status");

                if ($this->post_model->group_user_update_status($data,$status)) $i++;
            }

            if ($i === count($val)) echo true;
            else echo false;

        } else {
            $data = array(
                "group_id" => $this->session->userdata("group_id"),
                "user_detail_id" => $this->input->post("user_detail_id"),
            );
    
            $status = $this->input->post("status");
    
            echo $this->post_model->group_user_update_status($data,$status);

        }


    }

    public function update_post_reported() {
        if ($this->input->post("isBulk") == "true") {
            $val = $this->input->post("post_id");
            $i = 0;
            foreach($val as $v) {
                $data = array(
                    "post_id" => $v
                );

                $status = $this->input->post("status");

                if ($this->post_model->update_post_reported($data,$status)) $i++;
            }

            if ($i === count($val)) echo true;
            else echo false;

        } else {
            $data = array(
                "post_id" => $this->input->post("post_id"),
            );
    
            $status = $this->input->post("status");
    
            echo $this->post_model->update_post_reported($data,$status);
        }
    }

    public function add_role() {
        echo json_encode($this->post_model->add_role($this->session->userdata("group_id"),$this->input->post("role_name")));
    }

    public function delete_role() {
        echo $this->post_model->delete_role($this->input->post("role_id"));
    }

    public function get_group_user_roles() {
        echo json_encode($this->post_model->get_group_user_roles($this->input->post("role_id"),$this->session->userdata("group_id")));
    }

    public function get_group_user_hasno_roles() {
        echo json_encode($this->post_model->get_group_user_hasno_roles($this->session->userdata("group_id")));
    }

    public function update_group_user_role() {
        $data = array(
            "group_id" => $this->session->userdata("group_id"),
            "user_detail_id" => $this->input->post("user_detail_id"),
            "role_id" => $this->input->post("role_id")
        );

        echo $this->post_model->update_group_user_role($data);

    }

}
