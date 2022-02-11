<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo base_url() . "public/style.css" ?>">

    <title>Verify</title>
</head>

<body>
    <main class="verification-container">
        <div>
            <img src="<?php echo "public/assets/logo.svg" ?>" />
            <?php
            // print_r($_SESSION);
            if (isset($error) && $error) {
            ?>
                <section class="alert-error">
                    <i class="fas fa-info-circle"></i>
                    <section>
                        <h1><?php echo $error_title ?></h1>
                        <p><?php echo $error_description ?></p>
                    </section>
                </section>
            <?php } ?>
            <div class="verification-form">
                <h1>Email Verification</h1>
                <p>
                    <i class="fas fa-envelope"></i> Enter the 6-digit code we sent to your email
                </p>
                <?php echo form_open(base_url()."verify_email"); ?>
                <section class="code-box">
                    <input class="input-code-box" maxlength="1" required type="text" name="code[]" />
                    <input class="input-code-box" maxlength="1" required type="text" name="code[]" />
                    <input class="input-code-box" maxlength="1" required type="text" name="code[]" />
                    <input class="input-code-box" maxlength="1" required type="text" name="code[]" />
                    <input class="input-code-box" maxlength="1" required type="text" name="code[]" />
                    <input class="input-code-box" maxlength="1" required type="text" name="code[]" />
                </section>
                <div class="resend-container">
                </div>
                <button class="input-button">Verify</button>
                </form>
            </div>
        </div>
    </main>
    <script>
        var base_url = "<?php echo base_url() ?>"
    </script>
    <script src=<?php echo base_url() . "public/script.js" ?>></script>
    <script>
        controller.verify();
    </script>
</body>

</html>