<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="<?php echo base_url() ?>/public/style.css">
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
    <div class="post-container">
        <aside class="pages-navigator">
            <ul>
                <li><a href="./lobby" class=<?php if ($type === "lobby") echo "active-page" ?>><i class="fas fa-th-large"></i> Lobby</a></li>
                <li><a href="./fw" class=<?php if ($type === "org") echo "active-page" ?>><i class="fas fa-users"></i> Organization</a></li>
                <li><a href="./fw" class=<?php if ($type === "fw") echo "active-page" ?>><i class="fas fa-volume-up"></i> Freedom Wall</a></li>
                <li><a href="./forum" class=<?php if ($type === "forum") echo "active-page" ?>><i class="fas fa-comments"></i> Forum</a></li>
            </ul>
        </aside>
        <main>
            <h1><?php echo ucfirst($type); ?> Posts</h1>
            <a href="<?php echo $type; ?>/create">Create Post</a>
            <?php foreach ($posts as $post) : ?>
                <section>
                    <p><?php echo $post["post_text"]; ?></p>
                    <small><?php echo $post["date_time_stamp"]; ?></small><br />
                    <a href="./remove/<?php echo $post["post_id"]; ?>" target="_self">Delete</a>
                    <?php if ($type != 'fw') { ?>
                        <a href="./<?php echo $type; ?>/edit/<?php echo $post["post_id"];  ?>">Edit</a>
                    <?php } ?>
                </section>
                <hr />
            <?php endforeach ?>
        </main>
    </div>
</body>

</html>