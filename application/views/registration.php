<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUP Connect Registration</title>
</head>

<body>

    <div class="container">
        <h1>TUP Connect</h1>
        <h2>Register Here!</h2>
        <?php echo form_error(); ?>
        <?php echo form_open($action); ?>

        <?php if ($type === "first") { ?>

            <label for="givenname"> Given Name: </label>
            <input type="text" name="givenname" required> <br> <br>

            <label for="middlename"> Middle Name: </label>
            <input type="text" name="middlename">

            <label for="lastname"> Last Name: </label>
            <input type="text" name="lastname" required> <br> <br>

            <label for="lastname"> Birthday: </label>
            <input type="date" name="birthday" required> <br> <br>

            <label for="lastname"> Gender: </label>
            <input type="text" name="gender" required> <br> <br>

            <label for="lastname"> Year Level: </label>
            <input type="text" name="year_level" required> <br> <br>

            <label for="tupmail"> TUP Email: </label>
            <input type="email" name="tupemail" required> <br> <br>

            <label for="username"> Username: </label>
            <input type="text" name="username" required> <br> <br>

            <label for="password"> Password: </label>
            <input type="password" name="password" required> <br> <br>

            <label for="confirmpass"> Confirm Password: </label>
            <input type="password" name="confirmpass" required> <br> <br>

            <br />
            <h3>Already have an account <a href="./login">Log In</a></h3>

        <?php } else { ?>
            <label for="lastname"> Course: </label>
            <input type="text" name="lastname" required> <br> <br>

            <label for="campus"> Campus:</label>
            <select name="campus" id="campus" forms="campus" required>
                <option value="none"></option>
                <option value="TUPM">TUP Manila</option>
                <option value="TUPT">TUP Taguig</option>
                <option value="TUPC">TUP Cavite</option>
                <option value="TUPV">TUP Visayas</option>
            </select> <br> <br>

            <label for="college"> College:</label>
            <input type="text" name="college" required> <br> <br>

            <label for="user-interests">Please pick your interests:</label> <br>
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Arts" /> Arts
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Education" /> Education
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Engineering" /> Engineering
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Film" /> Film <br> <br>
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Games" /> Games
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Math" /> Math
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Memes" /> Memes
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Music" /> Music <br> <br>
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Politics" /> Politics
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Programming" /> Programming
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Science" /> Science
            <input type="checkbox" class="user-interests" name="user-interests[]" value="Sports" /> Sports <br> <br>

        <?php } ?>

        <button type="submit" value="register">
            <?php
            if ($type === "first") echo "Next";
            else echo "Register";
            ?>
        </button>

        </form>

    </div>


    </div>
</body>

</html>