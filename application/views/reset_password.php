<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url("public/style.css") ?>">
    <title>Set new Password</title>
</head>
<body>
    <main class="forgot-password-container">
        <?php if (isset($password_success) && $password_success) {?>
        <div class="success-sent-email">
            <h1>Password Changed!</h1>
            <p>Your password has been changed successfully.</p>
            <a href="<?php echo base_url("index.php/login") ?>">Login Now</a>
        </div>
        <?php } else {?>
        <div class="forgot-password-box">
            <img src="<?php echo base_url("public/assets/logo.svg") ?>" />
            <h1>Set New Password</h1>
            <form action="<?=base_url('index.php/reset/password?hash='.$hash)?>" method="post">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Confirm new Password">
                  <label for="exampleInputPassword1">Confirm New Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" name="cpassword" placeholder="Confirm new Password">
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <?php }?>

    </main>
</body>
</html>
