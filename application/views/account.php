<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://cdn.ckeditor.com/4.17.1/basic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.9/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.9/dist/js/splide.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url("public/style.css") ?>">
    <title>Post</title>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="<?php echo base_url("index.php") ?>">
                    <img src="<?php echo base_url() ?>/public/assets/logo.svg" />
                </a>
            </li>
            <li class="user-pic-container">
                <a href="#">
                    <img class="user-pic" src="<?php echo base_url() ?>/public/assets/user.png" />
                </a>
                <div class="account-option">
                    <ul>
                        <li>
                            <a href="#">
                                <i class="fas fa-user"></i>
                                Account
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("index.php/signout") ?>">
                                <i class="fas fa-sign-out"></i>
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>

    <main class="account-container">
      
        <section>
            <div class="account-action">
                <ul>
                    <li>
                        <a href="<?php echo base_url("index.php/account") ?>" class="<?php if ($type === "profile") echo "account-active-option" ?>"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url("index.php/activities") ?>" class="<?php if ($type === "activities") echo "account-active-option" ?>"><i class="fas fa-pen"></i> Activities</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url("index.php/settings") ?>" class="<?php if ($type === "settings") echo "account-active-option" ?>"><i class="fas fa-cog"></i> Settings</a>
                    </li>
                </ul>
                <!-- <img src="<?php echo base_url() ?>/public/assets/user.png"/> -->
            </div>
            
            <?php if ($type === "profile") { ?>

            <div class="account-profile">
                <div class="profile-container">
                    <div class="profile-cover"></div>
                    <div class="profile-main">
                        <?php
                            $val = explode(".",$detail["image_path"]);
                            $path = "uploads/";

                            if ($val[0] === "user-1") $path = "public/assets/";
                        ?>
                        <img src="<?php echo base_url($path).$detail["image_path"] ?>" >
                        <h1><?php echo $detail["first_name"] . ' ' . $detail["middle_name"] . ' ' . $detail["last_name"] ?></h1>
                        <p>
                            <b>Campus:</b> <?php echo $detail["campus_code"] ?>
                        </p>
                        <p>
                            <b>College:</b> <?php echo $detail["college_code"] ?>
                        </p>
                        <p>
                            <b>Course:</b> <?php echo $detail["course_code"] ?>
                        </p>
                        <p>
                            <b>Year Level:</b> <?php 
                                $order = array(
                                    "1" => "st",
                                    "2" => "nd",
                                    "3" => "rd",
                                    "4" => "th",
                                    "5" => "th"
                                );
                                echo $detail["year_level"] . $order[$detail["year_level"]]." year";
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } else if ($type === "activities") { ?>
            <div class="account-activities">

                <?php foreach($activities as $activity): ?>
                <div class="activity-card">
                    <div class="activity-card-header">
                        <p><b>Posted:</b> <?php echo $activity["date_time_stamp"] ?></p>
                        <span class="<?php 
                            $val = array(
                                "1" => array("color" => "badge-blue","name"=>"Lobby"),
                                "2" => array("color" => "badge-green","name"=>"Organization"),
                                "3" => array("color" => "badge-orange","name"=>"FW"),
                                "4" => array("color" => "badge-red","name"=>"Forum"),
                            );
                            echo $val[$activity["type"]]["color"];
                        ?> badge"><?php 
                            echo $val[$activity["type"]]["name"];
                        ?></span>
                        <a href="<?php
                            $val = array(
                                "1" => "groups",
                                "2" => "organizations",
                                "3" => "fw",
                                "4" => "forum",
                            );

                            if ($activity["type"] == "3") {
                                echo base_url("index.php/".$val[$activity["type"]]) . '?pin=' . $activity["post_id"];
                            } else {
                                echo base_url("index.php/".$val[$activity["type"]]) . '/' . $activity["reference_id"] . '?pin=' . $activity["post_id"];
                            }

                            
                        ?>"><i class="fas fa-eye"></i></a>
                    </div>
                    <div class="activity-card-body">
                        <div class="activity-card-content">
                            <?php echo $activity["post_text"] ?>
                        </div>
                        <?php if (count($activity["images"])) { ?>
                            <div class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <?php foreach($activity["images"] as $image): ?>
                                            <li class="splide__slide">
                                                <img src=<?php echo base_url("uploads/") . $image["post_image_path"]?> />
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php } else if ($type === "settings") { ?>
            <div class="account-settings">
                <div class="account-update">
                    <?php echo form_open_multipart(base_url("index.php/update_profile")) ?>
                        <div class="account-image-container">
                            <?php
                                $val = explode(".",$detail["image_path"]);
                                $path = "uploads/";

                                if ($val[0] === "user-1") $path = "public/assets/";
                            ?>
                            <img src="<?php echo base_url($path) . $detail["image_path"] ?>" id="account-image-source">
                            <div class="account-image-action">
                                <a href="javascript:void(0)" id="account-image-select" class="solid-button">Select Picture</a>
                                <a href="javascript:void(0)" id="account-image-cancel" role="button" class="solid-button shallow">Cancel</a>
                            </div>
                            <input type="file" name="account_image" id="account-image"/>
                        </div>
                        <label>First Name:</label>
                        <input type="text" value="<?php echo $detail["first_name"] ?>" name="account_firstname">
                        <label>Middle Name:</label>
                        <input type="text" value="<?php echo $detail["middle_name"] ?>" name="account_middlename">
                        <label>Last Name:</label>
                        <input type="text" value="<?php echo $detail["last_name"] ?>" name="account_lastname">
                        <label>Birthday:</label>
                        <input type="date" value="<?php echo $detail["birthday"] ?>" name="account_birthday">
                        <label>Gender:</label>
                        <select name="account_gender">
                            <?php foreach($genders as $gender): ?>
                                <option value="<?php echo $gender["gender_id"] ?>" <?php if ($gender["gender_id"] === $detail["gender_id"]) echo "selected" ?>><?php echo $gender["gender"] ?></option>
                            <?php endforeach ?>
                        </select>
                        <label>Username:</label>
                        <input type="text" value="<?php echo $detail["user_name"] ?>" name="account_username">
                        <label>Password:</label>
                        <input type="password" name="account_password">
                        <button>Save Changes</button>
                    </form>
                </div>
            </div>
            <?php } ?>
        </section>
    </main>
    <script src="<?php echo base_url("public/script.js") ?>"></script>
    <script>
        controller.account()

    </script>
</body>
</html>