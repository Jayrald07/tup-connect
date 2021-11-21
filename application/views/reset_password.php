<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set new Password</title>
</head>
<body>
      <p class="login-box-msg">Set New Password</p>

      <form action="<?=base_url('index.php/reset/password?hash='.$hash)?>" method="post">
            <label for="exampleInputEmail1">Current Password</label>
            <input type="password" class="form-control" name="currentPassword" id="exampleInputEmail1" placeholder="Current Password">
            <label for="exampleInputPassword1">New Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Confirm new Password">
            <label for="exampleInputPassword1">Confirm New Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="cpassword" placeholder="Confirm new Password">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
</body>
</html>
