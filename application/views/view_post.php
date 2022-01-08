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
                <a href="#">
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
                            <a href="<?php echo base_url("index.php/account") ?>">
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

    <div class="comment-modal">
        <div class="comment-box">
            <div class="comment-header">
                <h1>Comments</h1>
                <a href="javascript:void(0)" class="comment-modal-close"><i class="fas fa-times"></i></a>
            </div>
            <div class="comment-body">
            </div>
            <div class="comment-footer">
                <input placeholder="Type your comment/reply" id="comment-input" />
                <button id="comment-button">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="post-option">
        <ul>
            <li class="user-based">
                <a href="javascript:void(0)" id="edit-post">Edit Post</a>
            </li>
            <li class="user-based">
                <a href="javascript:void(0)" id="delete-post">Delete Post</a>
            </li>
            <li>
                <a href="javascript:void(0)" id="report-post">Report Post</a>
            </li>
            <li>
                <a href="javascript:void(0)" id="report-user">Report User</a>
            </li>
            <li id="user-based-block">
                <a href="javascript:void(0)" id="block-user">Block User</a>
            </li>
        </ul>
    </div>

    <div class="report-modal">
        <div class="report-box">
            <div class="report-header">
                <h5>Select Reason</h5>
                <a href="javascript:void(0)" id="report-modal-close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="report-body">
                <ul>
                    <li>
                        <label for="malicious-content">
                            <input type="radio" class="report-desc" x-value="Malicious Content" id="malicious-content" name="report-option" />
                            <span>Malicious Content</span>
                        </label>
                    </li>
                    <li>
                        <label for="terrorism">
                            <input type="radio" class="report-desc" x-value="Terrorism" id="terrorism" name="report-option" />
                            <span>Terrorism</span>
                        </label>
                    </li>
                    <li>
                        <label for="sexual-content">
                            <input type="radio" class="report-desc" x-value="Sexual Content" id="sexual-content" name="report-option" />
                            <span>Sexual Content</span>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="report-footer">
                <button id="report-submit">Submit</button>
            </div>
        </div>
    </div>

    <div class="post-modal">
        <section class="post-modal-box">
            <div class="post-modal-header">
                <h5>Share your thoughts</h5>
                <a href="javascript:void(0)" class="post-modal-close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="post-modal-body">
                <?php
                if ($type === "lobby") echo form_open_multipart(base_url("index.php/post"));
                else if ($type === "org") echo form_open_multipart(base_url("index.php/org/post"));
                else if ($type === "fw") echo form_open_multipart(base_url("index.php/fw/post"));
                else if ($type === "forum") echo form_open_multipart(base_url("index.php/frm/post"));

                ?>
                <textarea required name='post-content'></textarea>
                <a href="javascript:void(0)" class="post-modal-upload">
                    <i class="fas fa-file-image"></i>
                </a>
                <small id="post-modal-upload-details">
                    <span id="upload-details">0 picture/s</span> 
                    <a href="javascript:void(0)" class="cancel-upload-files">
                        <i class="fas fa-times"></i>
                    </a>
                </small>
                <input type="file" name="post-image[]" accept=".png,.jpg" multiple id="post-modal-files"/>
                <button type="submit">Submit</button>
                </form>
            </div>
            <div class="post-modal-footer"></div>
        </section>
    </div>

    <div class="create-group-modal">
        <div class="create-group-box">
            <div class="create-group-header">
                <h1>Create Group</h1>
                <a href="javascript:void(0)" id="create-group-close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="create-group-body">
                <?php echo form_open(base_url("index.php/add_group")) ?>
                    <label>Group Name:</label>
                    <input type="text" name="group-name" required/>
                    <label>Category:</label>
                    <select name="group-category" required>
                        <?php foreach($categories as $category): ?>
                            <option value=<?php echo $category["category_id"] ?>><?php echo $category["category_name"] ?></option>
                        <?php endforeach ?>
                    </select>
                    <button>Create</button>
                </form>
            </div>
        </div>
    </div>

    <div class="members-modal">
        <div class="members-box">
            <div class="members-header">
                <h1>Members</h1>
                <a href="javascript:void(0)" id="members-close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="members-body">
                
                <?php foreach($members as $member): ?>
                    <div class="group-members-card">
                        <img src="<?php echo base_url("public/assets/user.png") ?>" />
                        <h1><?php echo $member["firstname"] . ' ' . $member["lastname"] ?></h1>
                        <a href="javascript:void(0)" class="group-members-remove" x-value=<?php echo $member["user_detail_id"] ?>>
                            <i class="fas fa-user-minus"></i>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>

    <div class="search-group-modal">
        <div class="search-group-box">
            <div class="search-group-header">
                <h1>Search Group</h1>
                <a href="javascript:void(0)" id="search-group-close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="search-group-body">
                <div class="search-input-container">
                    <label>Group Name:</label>
                    <input type="text" id="group-name">
                </div>
                <label>Interests: </label>
                <div class="search-interest-container">
                    <?php foreach($categories as $category): ?>
                        <div class="search-interest-card">
                            <input type="checkbox" id="<?php echo $category["category_name"]  ?>" class="search-interest" x-value="<?php echo $category["category_id"] ?>"/>
                            <label for="<?php echo $category["category_name"] ?>"><?php echo $category["category_name"] ?></label>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="search-result-container">
                    <h1>No Groups</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="post-modal v2-modal">
        <section class="post-modal-box">
            <div class="post-modal-header">
                <h5>Share your thoughts</h5>
                <a href="javascript:void(0)" class="post-modal-close v2-modal-close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="post-modal-body">
                <textarea required name='post-content-edit'></textarea>
                <section id="post-image-container">
                </section>
                <input type="file" id="post-image-add" accept=".png,.jpg" multiple />
                <button id="post-update-submit" type="submit">Save</button>
            </div>
            <div class="post-modal-footer"></div>
        </section>
    </div>

    <div class="delete-modal">
        <div class="delete-box">
            <div class="delete-body">
                <p>Are you sure to delete this post?</p>
            </div>
            <div class="delete-footer">
                <button id="delete-cancel">Cancel</button>
                <button id="delete-delete">Confirm</button>
            </div>
        </div>
    </div>

    <div class="delete-member-modal">
        <div class="delete-member-box">
            <div class="delete-member-body">
                <p>Are you sure to remove this member?</p>
            </div>
            <div class="delete-member-footer">
                <button id="delete-member-cancel">Cancel</button>
                <button id="delete-member-delete">Confirm</button>
            </div>
        </div>
    </div>

    <div class="post-container">
        <div style="position:relative">
            <aside class="pages-navigator">
                <ul>
                    <li><a href=<?php echo base_url("index.php/groups") ?> class=<?php if ($type === "lobby") echo "active-page" ?>><i class="fas fa-th-large"></i> Groups</a></li>
                    <li><a href=<?php echo base_url("index.php/organizations") ?> class=<?php if ($type === "org") echo "active-page" ?>><i class="fas fa-users"></i> Organization</a></li>
                    <li><a href=<?php echo base_url("index.php/fw") ?> class=<?php if ($type === "fw") echo "active-page" ?>><i class=" fas fa-volume-up"></i> Freedom Wall</a></li>
                    <li><a href=<?php echo base_url("index.php/forum") ?> class=<?php if ($type === "forum") echo "active-page" ?>><i class="fas fa-comments"></i> Forum</a></li>
                </ul>
            </aside>
        </div>
        <main>
            <?php if (isset($startup) AND $startup) {?>
                <div class="select-group-container">
                    <?php if ($type === "forum") {?>
                        <img src="<?php echo base_url("public/assets/choose-category.svg") ?>" id="select-group-image"/>
                        <p>Choose a category</p>
                    <?php } else if ($type === "lobby") {?>
                        <img src="<?php echo base_url("public/assets/select-group.svg") ?>" id="select-group-image"/>
                        <p>Select groups to start connecting to your peers</p>
                    <?php } else if ($type === "org") {?>
                        <img src="<?php echo base_url("public/assets/choose-org.svg") ?>" id="select-group-image"/>
                        <p>Select organization to start connecting to your peers</p>
                    <?php } else {?>
                        
                    <?php } ?>
                </div>
            
            <?php } else {?>
                <section class="groups-action">
                    <?php if ($type !== "fw" and $type !== "forum") { ?>
                        <div>
                            <a href="javascript:void(0)" id="members-modal-trigger" x-value="<?php if ($type === "lobby")echo $group_id; else echo null; ?>">
                                <i class="fas fa-users"></i>
                                Members
                            </a>
                        </div>
                        <div>
                            <a href="<?php if ($type === "lobby")echo base_url("index.php/groups/admin/$group_id"); else echo null; ?>" >
                                <i class="fas fa-cogs"></i>
                                Settings
                            </a>
                        </div>
                    <?php } ?>
                    <div class='<?php if ($type === "fw" or $type === "forum") echo "force-left fw-button" ?>'>
                        <a href="javascript:void(0)" class="post-button">
                            <i class="fas fa-pen"></i>
                            <?php if ($type === "fw") echo "Create Entry";
                            else if ($type === "forum") echo "Ask";
                            else echo "Post" ?>
                        </a>
                    </div>
                </section>
                <?php if (count($posts)) {?>

                <?php foreach ($posts as $post) : ?>
                    <?php if ($post["post_id"] === $pin_post) {?>
                    <section class="post-card pop">
                        <section class="post-header">
                            <?php if ($type !== "fw") { ?>
                                <figure>
                                    <?php
                                        $val = explode(".",$post["image_path"]);
                                        $path = "uploads/";

                                        if ($val[0] === "user-1") $path = "public/assets/";
                                    ?>
                                    <img src=<?php echo base_url($path) . $post["image_path"] ?> />
                                </figure>
                            <?php } ?>
                            <section>
                                <h1><?php
                                    if ($type === "fw") echo "Anonymous";
                                    else echo $post["first_name"] . " " . $post["last_name"] ?>
                                </h1>
                                <time><?php
                                        if ($type === 'fw') echo "Entry ID: " . $post["fw_id"];
                                        else echo $post["date_time_stamp"];
                                        ?></time>
                            </section>
                            <div>
                                <a href="javascript:void(0)" class="post-option-toggle" post-value=<?php echo $post["post_id"] ?> user-value=<?php echo $post["user_detail_id"] ?>>
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                            </div>
                        </section>
                        <section class="post-body">
                            <div class="post-body-text">
                                <?php echo $post['post_text'] ?>
                            </div>
                            <?php if (count($post["post_image_path"])) { ?>
                                <div class="splide">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            <?php foreach ($post["post_image_path"] as $image_path) : ?>
                                                <!-- <figure> -->
                                                <li class="splide__slide">
                                                    <img src=<?php echo base_url("uploads/") . $image_path["post_image_path"] ?> />
                                                </li>
                                                <!-- </figure> -->
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        </section>
                        <section class="post-footer">
                            <a href="javascript:void(0)" class="up-vote" x-value=<?php echo $post["post_id"] ?>>
                                <i class="fas fa-arrow-up"></i>
                                <span class="up-vote-count"><?php echo $post['post_up_vote'] ?></span>
                            </a>
                            <a href="javascript:void(0)" class="down-vote" x-value=<?php echo $post["post_id"] ?>>
                                <i class="fas fa-arrow-down"></i>
                                <span class="down-vote-count"><?php echo $post['post_down_vote'] ?></span>
                            </a>
                            <a href="javascript:void(0)" class="comment" x-value=<?php echo $post["post_id"] ?>>
                                <i class="fas fa-comment"></i>
                                <span class="comment-count"><?php echo $post['comments_count'] ?></span>
                            </a>
                        </section>
                    </section>
                    <hr class="divider"/>
                    <?php }?>
                <?php endforeach; ?>

                <?php foreach ($posts as $post) : ?>
                    <?php if ($post["post_id"] !== $pin_post) {?>
                    <section class="post-card">
                        <section class="post-header">
                            <?php if ($type !== "fw") { ?>
                                <figure>
                                    <?php
                                        $val = explode(".",$post["image_path"]);
                                        $path = "uploads/";

                                        if ($val[0] === "user-1") $path = "public/assets/";
                                    ?>
                                    <img src=<?php echo base_url($path) . $post["image_path"] ?> />
                                </figure>
                            <?php } ?>
                            <section>
                                <h1><?php
                                    if ($type === "fw") echo "Anonymous";
                                    else echo $post["first_name"] . " " . $post["last_name"] ?>
                                </h1>
                                <time><?php
                                        if ($type === 'fw') echo "Entry ID: " . $post["fw_id"];
                                        else echo $post["date_time_stamp"];
                                        ?></time>
                            </section>
                            <div>
                                <a href="javascript:void(0)" class="post-option-toggle" post-value=<?php echo $post["post_id"] ?> user-value=<?php echo $post["user_detail_id"] ?>>
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                            </div>
                        </section>
                        <section class="post-body">
                            <div class="post-body-text">
                                <?php echo $post['post_text'] ?>
                            </div>
                            <?php if (count($post["post_image_path"])) { ?>
                                <div class="splide">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            <?php foreach ($post["post_image_path"] as $image_path) : ?>
                                                <!-- <figure> -->
                                                <li class="splide__slide">
                                                    <img src=<?php echo base_url("uploads/") . $image_path["post_image_path"] ?> />
                                                </li>
                                                <!-- </figure> -->
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        </section>
                        <section class="post-footer">
                            <a href="javascript:void(0)" class="up-vote" x-value=<?php echo $post["post_id"] ?>>
                                <i class="fas fa-arrow-up"></i>
                                <span class="up-vote-count"><?php echo $post['post_up_vote'] ?></span>
                            </a>
                            <a href="javascript:void(0)" class="down-vote" x-value=<?php echo $post["post_id"] ?>>
                                <i class="fas fa-arrow-down"></i>
                                <span class="down-vote-count"><?php echo $post['post_down_vote'] ?></span>
                            </a>
                            <a href="javascript:void(0)" class="comment" x-value=<?php echo $post["post_id"] ?>>
                                <i class="fas fa-comment"></i>
                                <span class="comment-count"><?php echo $post['comments_count'] ?></span>
                            </a>
                        </section>
                    </section>
                    <?php }?>
                <?php endforeach; ?>

                <?php } else { ?>
                    <div class="select-group-container">
                        <?php if ($type === "forum") {?>
                            <img src="<?php echo base_url("public/assets/start-ask.svg") ?>" id="select-group-image"/>
                            <p>Start asking or answer anyone's questions </p>
                        <?php } else if ($type === "lobby") {?>
                            <img src="<?php echo base_url("public/assets/start-post.svg") ?>" id="select-group-image"/>
                            <p>Start sharing your thoughts </p>
                        <?php } else if ($type === "fw") {?>
                            <img src="<?php echo base_url("public/assets/start-fw.svg") ?>" id="select-group-image"/>
                            <p>Share your thoughts and feelings freely!</p>
                        <?php } else {?>

                        <?php } ?>
                    </div>
                <?php } ?>
            <?php }?>

        </main>

        <?php if ($type !== "fw") { ?>
            <div style="position:relative">
                <div class="container-container">
                    <?php if ($type !== "forum") { ?>
                        <section class="container-action">
                            <?php if ($type === "lobby") {?>
                                <a href="#" id="search-group-trigger"><i class="fas fa-search"></i> Search</a>
                                <a href="#" id="create-group-trigger"><i class="fas fa-plus"></i> Create</a>
                            <?php } else { ?>
                                <a href="#"><i class="fas fa-search"></i> Search</a>
                                <a href="#" id="create-org-trigger"><i class="fas fa-plus"></i> Create</a>
                            <?php } ?>
                        </section>
                        <hr class="container-divider" />
                    <?php } ?>
                    <section class="container-own">
                        <?php if ($type !== "forum") { ?>
                            <h1>Your <?php if ($type === "org") echo "Organizations";
                                        else echo "Groups"; ?></h1>
                            <?php if ($type === "lobby") { ?>
                                <?php foreach ($owned_groups as $group) : ?>
                                    <a href=<?php echo base_url("index.php/groups/") . $group["group_id"] ?> class="container-card <?php echo $group["group_id"] === $group_id ? 'active-page' : '' ?>">
                                        <?php echo $group["group_name"] ?>
                                    </a>
                                <?php endforeach; ?>
                                <?php if (!count($owned_groups)) {?>
                                    <small>No Available</small>
                                <?php }?>
                            <?php } else if ($type === "org") { ?>
                                <?php foreach ($org_owned as $org) : ?>
                                    <a href=<?php echo base_url("index.php/organizations/") . $org["organization_id"] ?> class="container-card <?php echo $org["organization_id"] === $org_id ? 'active-page' : '' ?>">
                                        <?php echo $org["organization_name"] ?>
                                    </a>
                                <?php endforeach; ?>
                                <?php if (!count($org_owned)) {?>
                                    <small>No Available</small>
                                <?php }?>
                            <?php } ?>
                        <?php } else { ?>
                            <h1>Categories</h1>
                            <?php foreach ($categories as $category) : ?>
                                <a href=<?php echo base_url("index.php/forum/") . $category["category_id"] ?> class="container-card <?php echo $category["category_id"] === $category_id ? 'active-page' : '' ?>">
                                    <?php echo $category["category_name"] . ' ('.$category["count"].')' ?>
                                </a>
                            <?php endforeach; ?>
                        <?php } ?>
                    </section>

                    <?php if ($type !== "forum") { ?>
                        <hr class="container-divider" />
                        <section class="container-joined">
                            <h1>Joined <?php if ($type === "org") echo "Organizations";
                                        else echo "Groups"; ?></h1>
                            <?php if ($type === "lobby") { ?>
                                <?php foreach ($joined_groups as $group) : ?>
                                    <a href=<?php echo base_url("index.php/groups/") . $group["group_id"] ?> class="container-card <?php echo $group["group_id"] === $group_id ? 'active-page' : '' ?>">
                                        <?php echo $group["group_name"] ?>
                                    </a>
                                <?php endforeach; ?>
                                <?php if (!count($joined_groups)) {?>
                                    <small>No Available</small>
                                <?php }?>
                            <?php } else if ($type === "org") { ?>
                                <?php foreach ($org_joined as $org) : ?>
                                    <a href=<?php echo base_url("index.php/organizations/") . $org["organization_id"] ?> class="container-card <?php echo $org["organization_id"] === $org_id ? 'active-page' : '' ?>">
                                        <?php echo $org["organization_name"] ?>
                                    </a>
                                <?php endforeach; ?>
                                <?php if (!count($org_joined)) {?>
                                    <small>No Available</small>
                                <?php }?>
                            <?php } ?>

                        </section>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <script src=<?php echo base_url("public/script.js") ?>></script>
    <script>
        controller.posts_init()
        CKEDITOR.replace('post-content')
        CKEDITOR.replace('post-content-edit')
    </script>
</body>

</html>