<?php

class Organization extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('post', 'session'));
        $this->load->model("organization_model");
        $this->load->helper("string");
    }

    public function get_orgs()
    {
        $data["org_joined"] = $this->organization_model->get_joined_org($this->session->userdata("user_detail_id"));
        $data["org_owned"] = $this->organization_model->get_owned_org($this->session->userdata("user_detail_id"));

        return $data;
    }

    public function index()
    {
        if (empty(trim($this->session->userdata("user_detail_id")))) redirect(base_url()."login");

        $data = $this->get_orgs();

        $data["type"] = "org";
        $data["posts"] = [];
        $data['org_id'] = NULL;
        $data["startup"] = TRUE;
        $data["user_photo"] = $this->session->userdata("user_photo");
        $data["colleges"] = $this->organization_model->get_colleges();
        $data["categories"] = $this->post_model->get_categories();
        $data["is_admin"] = $this->session->userdata("is_admin");



        $this->load->view("view_post", $data);
    }


    public function org($org_id)
    {

        if (empty(trim($this->session->userdata("user_detail_id")))) redirect(base_url() . "login");

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
        $data["colleges"] = $this->organization_model->get_colleges();
        $data["categories"] = $this->post_model->get_categories();
        $data["members"] = $this->organization_model->get_members($org_id);
        $data["permissions"] = $this->organization_model->get_user_permissions($this->session->userdata("user_detail_id"));
        $data["is_owner"] = $this->organization_model->is_org_owner($this->session->userdata("user_detail_id"));
        $data["is_verified"] = $this->organization_model->is_verified($org_id);
        $data["is_admin"] = $this->session->userdata("is_admin");
        


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

        $status_post = "posted";

        if ($this->input->post("is_announcement")) $status_post = "announced";

        $data = array(
            "type" => "org",
            "organization_post_id" => $organization_post_id,
            "organization_id" => $this->session->userdata("id"),
            "user_detail_id" => $this->session->userdata("user_detail_id"),
            "post_id" => $post_id,
            "post_text" => $this->input->post("post-content"),
            "date_time_stamp" => $date_stamp->format("Y-m-d H:i:s"),
            "status" => $status_post,
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
                if (count($post_images) == $done) redirect(base_url()."organizations/" . $this->session->userdata("id"));
            } else redirect(base_url()."organizations/" . $this->session->userdata("id"));
        }
    }


    public function add_org() {
        $data = array(
            "organization_id" => random_string("alnum",15),
            "organization_name" => $this->input->post("org-name"),
            "category_id" => $this->input->post("org-category"),
            "organization_image" => "../",
            "organization_owner" => $this->session->userdata("user_detail_id"),
            "organization_type" => $this->input->post("org-type"),
        );
        if ($this->organization_model->add_org($data)) redirect(base_url()."organization");
        else redirect(base_url()."organization");
    }

    public function find_org() {
        $this->load->model("organization_model");
        $data = array(
            "organization_name" => $this->input->post("org_name"),
            "use_org_type" => $this->input->post("use_org_type"),
            "org_type" => $this->input->post("org_type"),
            "college_id" => $this->input->post("college_id"),
            "interests" => $this->input->post("interests")
        );
        echo json_encode($this->organization_model->find_org($data));
    }

    public function join_org() {
        echo $this->organization_model->join_org(array("organization_id" => $this->input->post("organization_id")));
    }

    public function cancel_org_request() {
        $data = array(
            "organization_id" => $this->input->post("organization_id"),
            "user_detail_id" => $this->session->userdata("user_detail_id")
        );
        echo $this->organization_model->cancel_org_request($data);
    }

    public function admin($org_id) {
        $this->session->set_userdata("organization_id",$org_id);

        $val = $this->post_model->get_roles($org_id);
        for($i = 0;$i < count($val);$i++) {
            $r = $this->organization_model->get_user_role($org_id,$val[$i]["role_id"]);
            if (count($r)) $val[$i]["count"] = $r[0]["count"];
        }

        $data = array(
            "org_id" => $org_id,
            "org_details" => $this->organization_model->get_org($org_id),
            "member_request" => $this->organization_model->get_org_user(array(
            "organization_id" => $org_id,
            "status" => 0,
            )),
            "reported_posts" => $this->organization_model->get_reported_org_post($org_id),
            "role" => $val,
            "permission" => $this->organization_model->get_role_permissions($org_id),
            "type" => "org",
            "user_photo" => $this->session->userdata("user_photo"),
            "is_admin" => $this->session->userdata("is_admin")
        );
        $data["permissions"] = $this->organization_model->get_user_permissions($this->session->userdata("user_detail_id"));
        $data["is_owner"] = $this->organization_model->is_org_owner($this->session->userdata("user_detail_id"));

        $this->load->view("admin",$data);
    }

    public function remove_org_user() {
        $data = array(
            "organization_id" => $this->input->post("org_id"),
            "user_detail_id" => $this->input->post("user_detail_id")
        );
        echo $this->organization_model->remove_group_user($data);
    }

    public function org_user_update_status() {

        if ($this->input->post("isBulk") === true) {
            $val = $this->input->post("user_detail_id");
            $i = 0;
            foreach($val as $v) {
                $data = array(
                    "organization_id" => $this->session->userdata("organization_id"),
                    "user_detail_id" => $v,
                );

                $status = $this->input->post("status");

                if ($this->organization_model->org_user_update_status($data,$status)) $i++;
            }

            if ($i === count($val)) echo true;
            else echo false;

        } else {
            $data = array(
                "organization_id" => $this->session->userdata("organization_id"),
                "user_detail_id" => $this->input->post("user_detail_id"),
            );
    
            $status = $this->input->post("status");
    
            echo $this->organization_model->org_user_update_status($data,$status);

        }


    }

    public function add_role() {
        echo json_encode($this->organization_model->add_role($this->session->userdata("organization_id"),$this->input->post("role_name")));
    }

    public function get_org_user_hasno_roles() {
        echo json_encode($this->organization_model->get_org_user_hasno_roles($this->session->userdata("organization_id")));
    }

    public function update_org_user_role() {
        $data = array(
            "organization_id" => $this->session->userdata("organization_id"),
            "user_detail_id" => $this->input->post("user_detail_id"),
            "role_id" => $this->input->post("role_id")
        );

        echo $this->organization_model->update_org_user_role($data);
    }

    public function get_org_user_roles() {
        echo json_encode($this->organization_model->get_org_user_roles($this->input->post("role_id"),$this->session->userdata("organization_id")));
    }

    public function org_verification($status) {

        if (empty(trim($this->session->userdata("user_detail_id")))) redirect(base_url()."login");


        $data["user_photo"] = $this->session->userdata("user_photo");
        $data["orgs"] = $this->organization_model->get_org_by_status($status);
        $data["status"] = $status;
        $data["is_admin"] = $this->session->userdata("is_admin");


        $this->load->view("org_verification",$data);
    }

    public function org_validate() {
        $id = $this->input->post("id");
        $type = $this->input->post("type");

        if ($type === "del") {
            if ($this->organization_model->delete_org($id)) echo TRUE;
            else echo FALSE;
        } else {
            $status_details = array(
                "approve" => 1,
                "reval" => 0,
                "revoke" => 3,
                "decline" => 2
            );
    
            $status = $status_details[$type];

            if ($this->organization_model->update_org_status($id,$status)) echo TRUE;
            else echo FALSE;
        }



    }

}
