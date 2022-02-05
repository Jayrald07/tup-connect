<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo base_url("public/style.css") ?>">
    <title>TUP Connect Forgot Password</title>
</head>
<body>
    <main class="forgot-password-container">
        <?php if (isset($proceed_change) && $proceed_change) {?>

        <div class="success-sent-email">
            <h1>Email Sent!</h1>
            <p>We sent you an email containing the link to set your new password.</p>
            <a href="<?php echo base_url("index.php/login") ?>">Back Home</a>
        </div>
        <?php } else {?>

        <div class="forgot-password-box">
            <img src="<?php echo base_url("public/assets/logo.svg") ?>" />
            <?php
            if (isset($error_login) && $error_login) {
            ?>
                <section class="alert-error" style="margin-top: 20px">
                    <i class="fas fa-info-circle"></i>
                    <section>
                        <h1><?php echo $error_title ?></h1>
                        <p><?php echo $error_description ?></p>
                    </section>
                </section>
            <?php } ?>
            <h1>Forgot Password</h1>
            <form action="<?=base_url('index.php/login/forgotPassword')?>" method="post">
                <input type="email" required name="email" class="form-control" placeholder="Email">
                <button type="submit" class="forgot-pass-btn">Send Verification Email</button>
                <a class="login-instead" href="<?php echo base_url("index.php/login") ?>">Login Instead</a>
            </form>
        </div>

        <?php }?>

    </main>
</body>
</html>

