<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUP Connect Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
    <form action="<?=base_url('index.php/login/forgotPassword')?>" method="post">
            <input type="email" required name="email" class="form-control" placeholder="Email">
            <button type="submit" class="forgot-pass-btn">Send Verification Email</button>
    </form>

            
</body>
</html>

