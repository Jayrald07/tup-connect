<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../public/style.css">

    <title>Verify</title>
</head>

<body>
    <style>
        input {
            width: 30px;
            height: 30px;
            text-align: center;
        }
    </style>

    <main class="verification-container">
        <div class="verification-form">
            <h1>Email Verification</h1>
            <p>
                <i class="fas fa-envelope"></i> Enter the 6-digit code we sent to your email
            </p>
            <?php echo form_open("./verify_email"); ?>
            <section class="code-box">
                <input type="text" name="code[]" />
                <input type="text" name="code[]" />
                <input type="text" name="code[]" />
                <input type="text" name="code[]" />
                <input type="text" name="code[]" />
                <input type="text" name="code[]" />
            </section>
            <button>Verify</button>
            </form>
        </div>

        <div class="logo-container">
            <img src="../public/assets/logo.svg" />
        </div>
    </main>

</body>

</html>