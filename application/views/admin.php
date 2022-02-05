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
            <?php if ($is_admin) {?>
            <li>
                <a href=<?php echo base_url("index.php/org_verification/0") ?> class="admin-lock">
                    <i class="fas fa-lock"></i>
                </a>
            </li>
            <?php  }?>
            <li class="user-pic-container">
                <a href="#">
                    <?php
                        $val = explode(".",$user_photo);
                        $path = "uploads/";
                        if ($val[0] === "user-1") $path = "public/assets/";
                    ?>
                    <img src=<?php echo base_url($path) . $user_photo ?> />
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

    <div class="delete-modal">
        <div class="delete-box">
            <div class="delete-body">
                <p>Are you sure to delete this role?</p>
            </div>
            <div class="delete-footer">
                <button id="delete-cancel">Cancel</button>
                <button id="delete-delete">Confirm</button>
            </div>
        </div>
    </div>

    <div class="members-modal">
        <div class="members-modal-box">
            <div class="members-modal-header">
                <h1>Members</h1>
                <a href="javascript:void(0)" id="members-modal-close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="members-modal-body">
                
            </div>
        </div>
    </div>
    <main class="admin-panel">
        <section class="admin-action-panel">
            <a href="<?php 
                if ($type === "group")
                    echo base_url("index.php/groups/$group_id");
                else 
                    echo base_url("index.php/organizations/$org_id")
            ?>"><?php if ($type === "group") echo $group_details[0]["group_name"]; else echo $org_details[0]["organization_name"]; ?></a>
            <ul>
                <?php if (count($permissions) and $permissions[0]["member_request"] OR $is_owner) {?>

                <li><a href="javascript:void(0)" class="admin-trigger admin-panel-selected" data-target="mr"><i class="fas fa-user-clock"></i><span>Member Request</span></a></li>
            <?php }?>
            <?php if (count($permissions) and $permissions[0]["reported_content"] OR $is_owner) {?>

                <li><a href="javascript:void(0)" class="admin-trigger" data-target="rc"><i class="fas fa-user-times"></i><span>Reported Content</span></a></li>
                <?php }?>
            <?php if (count($permissions) and $permissions[0]["manage_roles"] OR $is_owner) {?>
                <li><a href="javascript:void(0)" class="admin-trigger" data-target="mrr"><i class="fas fa-user-cog"></i><span>Manage Roles</span></a></li>
                <?php }?>
            <?php if (count($permissions) and $permissions[0]["manage_permission"] OR $is_owner) {?>
                <li><a href="javascript:void(0)" class="admin-trigger" data-target="mp"><i class="fas fa-user-edit"></i><span>Manage Permissions</span></a></li>
            <?php }?>

            </ul>
        </section>
        <section class="admin-content-panel">
            <?php if (count($permissions) and $permissions[0]["member_request"] OR $is_owner) {?>
            <div class="member-request-container admin-container" id="mr">
                <div class="member-request-header">
                    <div class="select-all-container">
                        <input id="select-all" type="checkbox"/>
                        <label for="select-all">Select All</label>
                    </div>
                    <div class="member-request-action">
                        <a href="javascript:void(0)" id="member-request-approve-all">Approve</a>
                        <a href="javascript:void(0)" id="member-request-decline-all">Decline</a>
                    </div>
                </div>
                <div class="member-request-body">
                    <?php foreach($member_request as $mr): ?>
                        <div class="member-request-card" id="<?php echo $mr["user_detail_id"] ?>">
                            <div class="member-request-card-header">
                                <div class="select-all-container">
                                    <input id="select-all" data-target="<?php echo $mr["user_detail_id"] ?>" type="checkbox" class="check-member-request" x-value="<?php echo $mr["user_detail_id"] ?>"/>
                                </div>
                                <div class="mr-card-header">
                                    <?php
                                        $val = explode(".",$mr["image_path"]);
                                        $path = "uploads/";
                                        if ($val[0] === "user-1") $path = "public/assets/";
                                    ?>
                                    <img src="<?php echo base_url($path) . $mr["image_path"] ?>" />
                                    <div class="mr-card-header-author">
                                        <h1><?php echo $mr["firstname"] . ' ' . $mr["middlename"] . ' ' . $mr["lastname"]?></h1>
                                    </div>
                                </div>
                                <div class="member-request-action">
                                    <a href="javascript:void(0)" data-target="<?php echo $mr["user_detail_id"] ?>" class=<?php if ($type === "group") echo "member-request-approve"; else echo "member-org-request-approve" ?> x-value="<?php echo $mr["user_detail_id"] ?>">Approve</a>
                                    <a href="javascript:void(0)" data-target="<?php echo $mr["user_detail_id"] ?>" class=<?php if ($type === "group") echo "member-request-decline"; else echo "member-org-request-decline" ?> x-value="<?php echo $mr["user_detail_id"] ?>">Decline</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php }?>
            <?php if (count($permissions) and $permissions[0]["reported_content"] OR $is_owner) {?>

            <div class="reported-content-container admin-container hidden" id="rc">
                <div class="member-request-header">
                    <div class="select-all-container">
                        <input id="select-reported-all" type="checkbox"/>
                        <label for="select-reported-all">Select All</label>
                    </div>
                    <div class="member-request-action">
                        <a href="javascript:void(0)" id="reported-content-keep-all">Keep</a>
                        <a href="javascript:void(0)" id="reported-content-remove-all">Remove</a>
                    </div>
                </div>
                <div class="rc-body">
                    <?php foreach($reported_posts as $post): ?>
                        <div class="rc-card" id="<?php echo $post["post"][0]["post_id"] ?>">
                            <div class="member-request-card-header">
                                <div class="select-all-container">
                                    <input class="select-reported-check" type="checkbox"  data-target="<?php echo $post["post"][0]["post_id"] ?>" x-value="<?php echo $post["post"][0]["post_id"] ?>"/>
                                </div>
                                <div class="mr-card-header">
                                    <img src="<?php echo base_url("public/assets/user.png") ?>" />
                                    <div class="mr-card-header-author">
                                        <h1><?php echo $post["user"][0]["first_name"] . ' ' . $post["user"][0]["middle_name"] . ' ' .  $post["user"][0]["last_name"]?></h1>
                                        <time><?php echo $post["post"][0]["date_time_stamp"] ?></time>
                                    </div>
                                </div>
                                <div class="rc-reason">
                                    <select>
                                        <?php foreach($post["report"] as $postr): ?>
                                            <option>
                                                <?php echo $postr["report_description"] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>    
                                </div>
                                <div class="member-request-action">
                                    <a href="javascript:void(0)" data-target="<?php echo $post["post"][0]["post_id"] ?>" class="reported-content-keep" x-value="<?php echo $post["post"][0]["post_id"] ?>">Keep</a>
                                    <a href="javascript:void(0)" data-target="<?php echo $post["post"][0]["post_id"] ?>" class="reported-content-remove" x-value="<?php echo $post["post"][0]["post_id"] ?>">Remove</a>
                                </div>
                            </div>
                            <div class="rc-card-content">
                                <div>
                                    <?php echo $post["post"][0]["post_text"] ?>
                                </div>
                                <?php foreach($post["post_image"] as $image): ?>
                                    <div class="splide">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                <li class="splide__slide">
                                                    <img src=<?php echo base_url("uploads/") . $image["post_image_path"] ?> />
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <?php }?>
            <?php if (count($permissions) and $permissions[0]["manage_roles"] OR $is_owner) {?>

            <div class="manage-roles-container admin-container hidden" id="mrr">
                <div class="manage-roles-header">
                    <a href="javascript:void(0)" id=<?php if ($type === "group") echo "add-role-trigger"; else echo "add-org-role-trigger" ?>>Create</a>
                    <input type="text" placeholder="Input new role" id="role-name"/>
                </div>
                <div class="manage-roles-content">
                    <table class="manage-roles-table">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Members</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="role-container">
                            <?php foreach($role as $r): ?>
                                <tr id="role-c-<?php echo $r["role_id"] ?>">
                                    <td><?php echo $r["role_name"] ?></td>
                                    <td>
                                        <a href="javascript:void(0)" x-value="<?php echo $r["role_id"] ?>" class=<?php if ($type === "group") echo "role-members"; else echo "role-org-members"?>>
                                            <i class="fas fa-eye"></i>
                                            <span id="rm-count-<?php echo $r["role_id"] ?>"><?php echo $r["count"] ?></span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class=<?php if ($type === "group") echo "role-add-member"; else echo "role-org-add-member"?> x-value="<?php echo $r["role_id"] ?>">Add Members</a>
                                        <a href="javascript:void(0)" class="role-delete-member" x-value="<?php echo $r["role_id"] ?>">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php }?>
            <?php if (count($permissions) and $permissions[0]["manage_permission"] OR $is_owner) {?>

            <div class="manage-permission-container admin-container hidden" id="mp">
                <div class="manage-permission-header">
                    <div class="manage-permission-select-role">
                        <select id="role-permission">
                            <?php foreach($permission as $perm): ?>
                                <option value="<?php echo $perm["role_id"] ?>">
                                    <?php echo $perm["role_name"] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="manage-permission-clear">
                        <a href="javascript:void(0)" id="role-clear-permission">Clear Permission</a>
                    </div>
                </div>
                <div class="manage-permission-content">
                    <div class="manage-permission-card">
                        <h1>Manage Member Request</h1>
                        <div id="mpc" class="toggler <?php if (count($permission)) echo $permission[0]["permissions"][0]["member_request"] ? '' : 'toggler-off' ?>">
                            <div class="toggler-thumb <?php if (count($permission)) echo $permission[0]["permissions"][0]["member_request"] ? 'thumb-on' : '' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="manage-permission-card">
                        <h1>Manage Reported Content</h1>
                        <div  id="mrc" class="toggler <?php if (count($permission)) echo $permission[0]["permissions"][0]["reported_content"] ? '' : 'toggler-off' ?>">
                            <div class="toggler-thumb <?php if (count($permission)) echo $permission[0]["permissions"][0]["reported_content"] ? 'thumb-on' : '' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="manage-permission-card">
                        <h1>Manage Roles</h1>
                        <div id="manr" class="toggler <?php if (count($permission)) echo $permission[0]["permissions"][0]["manage_roles"] ? '' : 'toggler-off' ?>">
                            <div class="toggler-thumb <?php if (count($permission)) echo $permission[0]["permissions"][0]["manage_roles"] ? 'thumb-on' : '' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="manage-permission-card">
                        <h1>Manage Permissions</h1>
                        <div id="manp" class="toggler <?php if (count($permission)) echo $permission[0]["permissions"][0]["manage_permission"] ? '' : 'toggler-off' ?>">
                            <div class="toggler-thumb <?php if (count($permission)) echo $permission[0]["permissions"][0]["manage_permission"] ? 'thumb-on' : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>

        </section>
    </main>
    <script src="<?php echo base_url("public/script.js") ?>"></script>
    <script>
        controller.admin();
        var splide = new Splide( '.splide' );
        splide.mount();
    </script>
</body>
</html>