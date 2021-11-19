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
                    <a onclick="pop()" class ="btn">Report</a>
                    <?php if ($type != 'fw') { ?>
                        <a href="./<?php echo $type; ?>/edit/<?php echo $post["post_id"];  ?>">Edit</a>
                    <?php } ?>
                        <?php foreach ($comments as $comment): ?>
                            
                        <?php if($post["post_id"] == $comment["post_id"]) { ?>
                        <section>
                            <p><?php echo $comment["comment_text"]; ?></p>
                            <small><?php echo $comment["date_time_stamp"]; ?></small>
                            <span><button> ⇧ </button><span id="upvote_result"> 0 </span> | 
                            <button> ⇩ </button><span id="downvote_result" > 0 </span></span>
                        </section>
                        <hr />
                        <?php } ?>
                    <?php endforeach ?>
                    <section>
                        <form method="POST" action="./<?php echo $type; ?>/submit_comment/<?php echo $post["post_id"];  ?>">
                            <textarea name="comment" rows="5" cols="50" maxlength="2000" placeholder="Type your comment..." required></textarea> </br>
                            <input type="submit" name="submit_comment" />   
                            <hr />
                        </form>
                    </section>
                </section>
            <?php endforeach ?>
        </main>
    </div>
</body>

</html>