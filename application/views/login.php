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

    <label for="username"> Username or Email</label>
    <input type="text" name="username" required> <br> <br>

    <label for="password">Password</label>
    <input type="password" name="password" required>
    <br /><br />
    <a href="./register">Create an account</a><br /><br />
    <input type="submit" value="Log in">

    </form>
</body>

</html>