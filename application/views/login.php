<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUP Connect Log in</title>
</head>
<body>
    <h1>Log In</h1>

    <?php

    echo form_open("login/authenticate");


    ?>

<form action="<?=base_url('index.php/login')?>" method="post">  
    <label for="username"> Username or Email</label>
    <input type="text" name= "username" > <br> <br>

    <label for="password">Password</label>
    <input type="password" name="password">

    <input type="submit" value= "Log in">

    <a href="<?=base_url()?>index.php/login/forgotPassword">Forgot Password?</a>

</form>
</body>
</html>