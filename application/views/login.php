<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href=<?php echo base_url("public/style.css") ?>>
    <title>TUP Connect Log in</title>
</head>

<body>
    <!-- <h1>Log In</h1> -->

    <main class="login-container">
        <div>
            <img src="<?php echo base_url() . "public/assets/logo.svg" ?>"/>
            <?php
            if (isset($error_login) && $error_login) {
            ?>
                <section class="alert-error">
                    <i class="fas fa-info-circle"></i>
                    <section>
                        <h1><?php echo $error_title ?></h1>
                        <p><?php echo $error_description ?></p>
                    </section>
                </section>
            <?php } ?>
            <?php
            echo form_open("login/authenticate");
            ?>

            <label for="username" class="input-label"> Username or Email</label>
            <input type="text" class="<?php echo isset($error_login) && $error_login ? "error-input" : null ?> input-input" id="username" name="username" required placeholder="Example: juan.delacruz@tup.edu.ph"> <br> <br>

            <label for="password" class="input-label">Password</label>
            <input type="password" class="<?php echo isset($error_login) && $error_login ? "error-input" : null ?> input-input" id="password" name="password" required placeholder="------">
            <section class="login-features">
                <a href="<?= base_url() . "login/forgotPassword" ?>" class="forgot-password">Forgot Password?</a>
                <a href=<?php echo base_url() . "register" ?> class="create-account-button">Create an account</a><br /><br />
            </section>
            <input type="submit" class="input-button" value="Log in">

            </form>
        </div>
    </main>
    </form>
</body>

</html>