<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://cdn.ckeditor.com/4.17.1/basic/ckeditor.js"></script>
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
                <section class="comment-section">
                    <div class="comment-section-header">
                        <figure>
                            <img src=<?php echo base_url("public/assets/user.png") ?> />
                        </figure>
                        <div>
                            <h1>Juan Dela Cruz</h1>
                            <time>10m</time>
                        </div>
                        <a href="#">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                    </div>
                    <div class="comment-section-body">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae porro dignissimos est harum adipisci, sint tempore obcaecati nemo saepe veniam facere dolor, exercitationem repudiandae aliquam eveniet aspernatur molestias nihil id.
                        </p>
                    </div>
                    <div class="comment-section-footer">
                        <a href="#">
                            <i class="fas fa-reply"></i>
                        </a>
                        <a href="#">
                            View Replies
                        </a>
                    </div>
                </section>

                <section class="comment-section">
                    <div class="comment-section-header">
                        <figure>
                            <img src=<?php echo base_url("public/assets/user.png") ?> />
                        </figure>
                        <div>
                            <h1>Juan Dela Cruz</h1>
                            <time>10m</time>
                        </div>
                        <a href="#">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                    </div>
                    <div class="comment-section-body">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae porro dignissimos est harum adipisci, sint tempore obcaecati nemo saepe veniam facere dolor, exercitationem repudiandae aliquam eveniet aspernatur molestias nihil id.
                        </p>
                    </div>
                    <div class="comment-section-footer">
                        <a href="#">
                            <i class="fas fa-reply"></i>
                        </a>
                        <a href="#">
                            View Replies
                        </a>
                    </div>
                </section>
            </div>
            <div class="comment-footer">
                <input placeholder="Type your comment/reply" />
                <button>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="post-option">
        <ul>
            <li>
                <a href="#">Report Post</a>
            </li>
            <li>
                <a href="#">Report User</a>
            </li>
        </ul>
    </div>

    <div class="post-modal">
        <section class="post-modal-box">
            <div class="post-modal-header">
                <a href="javascript:void(0)" class="post-modal-close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="post-modal-body">
                <?php echo form_open_multipart(base_url("index.php/post")) ?>
                <textarea required name='post-content'></textarea>
                <input type="file" name="post-image" accept=".png,.jpg" />
                <button type="submit">Submit</button>
                </form>
            </div>
            <div class="post-modal-footer"></div>
        </section>
    </div>

    <div class="post-container">
        <div style="position:relative">
            <aside class="pages-navigator">
                <ul>
                    <li><a href=<?php echo base_url("index.php/general") ?> class=<?php if ($type === "general") echo "active-page" ?>><i class="fas fa-th-large"></i> General</a></li>
                    <li><a href=<?php echo base_url("index.php/groups") ?> class=<?php if ($type === "lobby") echo "active-page" ?>><i class="fas fa-th-large"></i> Groups</a></li>
                    <li><a href=<?php echo base_url("index.php/fw") ?> class=<?php if ($type === "org") echo "active-page" ?>><i class="fas fa-users"></i> Organization</a></li>
                    <li><a href=<?php echo base_url("index.php/fw") ?> class=<?php if ($type === "fw") echo "active-page" ?>><i class=" fas fa-volume-up"></i> Freedom Wall</a></li>
                    <li><a href=<?php echo base_url("index.php/forum") ?> class=<?php if ($type === "forum") echo "active-page" ?>><i class="fas fa-comments"></i> Forum</a></li>
                </ul>
            </aside>
        </div>
        <main>

            <section class="groups-action">
                <div>
                    <a href="#">
                        <i class="fas fa-users"></i>
                        Members
                    </a>
                </div>
                <div>
                    <a href="javascript:void(0)" class="post-button">
                        <i class="fas fa-pen"></i>
                        Post
                    </a>
                </div>
            </section>

            <?php foreach ($posts as $post) : ?>
                <section class="post-card">
                    <section class="post-header">
                        <figure>
                            <img src=<?php echo base_url("public/assets/user.png") ?> />
                        </figure>
                        <section>
                            <h1><?php echo $post["first_name"] . " " . $post["last_name"] ?></h1>
                            <time><?php echo $post["date_time_stamp"] ?></time>
                        </section>
                        <div>
                            <a href="javascript:void(0)" class="post-option-toggle">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                        </div>
                    </section>
                    <section class="post-body">
                        <p>
                            <?php echo $post['post_text'] ?>
                        </p>
                    </section>
                    <section class="post-footer">
                        <a href="#" class="up-vote">
                            <i class="fas fa-arrow-up"></i>
                            <span class="up-vote-count"><?php echo $post['post_up_vote'] ?></span>
                        </a>
                        <a href="#" class="down-vote">
                            <i class="fas fa-arrow-down"></i>
                            <span class="up-vote-count"><?php echo $post['post_down_vote'] ?></span>
                        </a>
                        <a href="javascript:void(0)" class="comment">
                            <i class="fas fa-comment"></i>
                            <span class="up-vote-count">0</span>
                        </a>
                    </section>
                </section>
            <?php endforeach; ?>

            <!-- <?php foreach ($posts as $post) : ?>
                <section>
                    <p><?php echo $post["post_text"]; ?></p>
                    <small><?php echo $post["date_time_stamp"]; ?></small><br />
                    <a href="./remove/<?php echo $post["post_id"]; ?>" target="_self">Delete</a>
                    <a onclick="pop()" class="btn">Report</a>
                    <a onclick="pop1()" class="btn">Report User</a>
                    <?php if ($type != 'fw') { ?>
                        <a href="./<?php echo $type; ?>/edit/<?php echo $post["post_id"];  ?>">Edit</a>
                    <?php } ?>

                    <div id="box">
                        <form method="POST" action="./<?php echo $type; ?>/report/<?php echo $post["post_id"];  ?>">
                            <span>Report Post</span><br>
                            <input type="radio" name="report_description" value="Sexual Content">Sexual Content<br>
                            <input type="radio" name="report_description" value="Malicious Content">Malicious Content<br>
                            <input type="radio" name="report_description" value="Terrorism">Terrorism<br>
                            <input type="radio" name="report_description" value="Racism">Racism<br>
                            <input type="submit" name="report" />
                        </form>
                    </div>

                    <div id="box1">
                        <form method="POST" action="./<?php echo $type; ?>/user_report/<?php echo $post['user_detail_id']; ?>">
                            <span>Report User</span><br>
                            <input type="radio" name="report_description" value="Sexual Content">Sexual Content<br>
                            <input type="radio" name="report_description" value="Malicious Content">Malicious Content<br>
                            <input type="radio" name="report_description" value="Terrorism">Terrorism<br>
                            <input type="radio" name="report_description" value="Racism">Racism<br>
                            <input type="submit" name="report" />
                        </form>
                    </div>
                </section>
                <hr />
            <?php endforeach ?> -->

        </main>
        <div style="position:relative">
            <div class="container-container">
                <section class="container-action">
                    <a href="#"><i class="fas fa-search"></i> Search</a>
                    <a href="#"><i class="fas fa-plus"></i> Create</a>
                </section>
                <hr class="container-divider" />
                <section class="container-own">
                    <h1>Your Groups</h1>
                    <?php foreach ($owned_groups as $group) : ?>
                        <a href=<?php echo base_url("index.php/groups/") . $group["group_id"] ?> class="container-card <?php echo $group["group_id"] === $group_id ? 'active-page' : '' ?>">
                            <?php echo $group["group_name"] ?>
                        </a>
                    <?php endforeach; ?>
                </section>
                <hr class="container-divider" />

                <section class="container-joined">
                    <h1>Joined Groups</h1>
                    <?php foreach ($joined_groups as $group) : ?>
                        <a href=<?php echo base_url("index.php/groups/") . $group["group_id"] ?> class="container-card <?php echo $group["group_id"] === $group_id ? 'active-page' : '' ?>">
                            <?php echo $group["group_name"] ?>
                        </a>
                    <?php endforeach; ?>
                </section>
            </div>
        </div>
    </div>
    <script src=<?php echo base_url("public/script.js") ?>></script>
    <script>
        controller.posts_init()
        CKEDITOR.replace('post-content')
    </script>
</body>

</html>