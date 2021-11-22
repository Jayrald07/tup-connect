<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <?php echo form_open("./verify_email"); ?>
    <h1>Email Verification</h1>
    <input type="text" name="code[]" />
    <input type="text" name="code[]" />
    <input type="text" name="code[]" />
    <input type="text" name="code[]" />
    <input type="text" name="code[]" />
    <input type="text" name="code[]" /><br /><br />
    <button>Verify</button>
    </form>
</body>

</html>