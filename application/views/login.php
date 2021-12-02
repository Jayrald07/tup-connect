<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
    <title>TUP Connect Log in</title>
</head>

<body>
    <!-- <h1>Log In</h1> -->

    <main class="login-container">

        <?php

        echo form_open("login/authenticate");

        ?>

        <label for="username"> Username or Email</label>
        <input type="text" name="username" required placeholder="Example: juan.delacruz@tup.edu.ph"> <br> <br>

        <label for="password">Password</label>
        <input type="password" name="password" required placeholder="------">
        <a href="#" class="forgot-password">Forgot Password?</a>
        <br /><br />
        <input type="submit" value="Log in">
        <a href="./register" class="create-account-button">Create an account</a><br /><br />

        </form>
        <div class="logo-container">
            <img src="../public/assets/logo.svg" />
        </div>
    </main>

</body>

</html>