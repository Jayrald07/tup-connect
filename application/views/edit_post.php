<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
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
                <li><a href="/index.php/lobby">Lobby</a></li>
                <li><a href="/index.php/fw">Freedom Wall</a></li>
                <li><a href="/index.php/forum">Forum</a></li>
            </ul>
        </aside>

        <?php echo validation_errors(); ?>
        <?php echo form_open_multipart($type . '/save') ?>

        <input type="text" hidden="true" name="post_id" value="<?php echo $post[0]["post_id"]; ?>" />
        <label style=" display:block">
            Content:
        </label>
        <textarea name="content" rows="5" cols="50" maxlength="2000" required><?php echo $post[0]["post_text"]; ?></textarea><br /><br />
        <label>Images:</label><br /><br />
        <small>-- Set of Image Here --</small><br /><br />
        <input type="submit" name="post_save" value="Save" />
        <a href="/index.php/lobby">Cancel</a>
        </form>
    </div>
</body>

</html>