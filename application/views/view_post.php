<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
</head>
<style>
    .container {
        display: grid;
        grid-template-columns: 1fr 4fr;
    }

    ul {
        padding: 0;
        margin: 0
    }

    ul li a {
        text-decoration: none;
        padding: 10px;
        display: block;
    }
</style>

<body>
    <div class="container">
        <aside>
            <ul>
                <li><a href="./lobby">Lobby</a></li>
                <li><a href="./fw">Freedom Wall</a></li>
                <li><a href="./forum">Forum</a></li>
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