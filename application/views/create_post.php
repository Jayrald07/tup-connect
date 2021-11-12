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
                <li><a href="../lobby">Lobby</a></li>
                <li><a href="../fw">Freedom Wall</a></li>
                <li><a href="../forum">Forum</a></li>
            </ul>
        </aside>

        <?php echo validation_errors(); ?>
        <?php echo form_open_multipart($allowed['type'] . '/submit') ?>
        <?php if ($allowed['group']) { ?>
            <label>Group:</label>
            <select name="group">
                <?php foreach ($groups as $group) : ?>
                    <option value="<?php echo $group['group_id']; ?>"><?php echo $group['group_name']; ?></option>
                <?php endforeach; ?>
            </select><br /><br />
        <?php } ?>

        <?php if ($allowed['campus']) { ?>
            <label>Campus:</label>
            <select name="campus">
                <?php foreach ($campuses as $campus) : ?>
                    <option value="<?php echo $campus['campus_id']; ?>"><?php echo $campus['campus_name']; ?></option>
                <?php endforeach; ?>
            </select><br /><br />
        <?php } ?>


        <?php if ($allowed['college']) { ?>
            <label>College:</label>
            <select name="college">
                <?php foreach ($colleges as $college) : ?>
                    <option value="<?php echo $college['college_id']; ?>"><?php echo $college['college_name']; ?></option>
                <?php endforeach; ?>
            </select><br /><br />
        <?php } ?>

        <?php if ($allowed['category']) { ?>
            <label>Category:</label>
            <select name="category">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                <?php endforeach; ?>
            </select><br /><br />
        <?php } ?>

        <label style="display:block">
            Content:
        </label>
        <textarea name="content" rows="5" cols="50" maxlength="2000" required></textarea><br /><br />
        <label>Images:</label>
        <input type="file" name="post_images" multiple accept=".jpg,.gif,.png" max="5" /><br /><br />
        <input type="submit" name="post_submit" />
        </form>
    </div>
</body>

</html>