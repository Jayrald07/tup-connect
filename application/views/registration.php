<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">

    <title>TUP Connect Registration</title>
</head>

<body>
    <main class="sign-up-container">

        <!-- <h1>TUP Connect</h1> -->
        <!-- <h2>Register Here!</h2> -->
        <?php echo form_error(); ?>
        <?php echo form_open($action); ?>

        <?php if ($type === "first") { ?>
            <div class="row names">
                <section>
                    <label for="givenname"><span class="required">*</span> Given Name: </label>
                    <input type="text" name="givenname" required> <br> <br>
                </section>
                <section>

                    <label for="middlename"> Middle Name: </label>
                    <input type="text" name="middlename">
                </section>
                <section>

                    <label for="lastname"><span class="required">*</span> Last Name: </label>
                    <input type="text" name="lastname" required> <br> <br>
                </section>

            </div>
            <div class="row bday-gender">
                <section>
                    <label for="lastname"><span class="required">*</span> Birthday: </label>
                    <input type="date" name="birthday" required> <br> <br>
                </section>
                <section>
                    <label for="lastname"><span class="required">*</span> Gender: </label>
                    <select name="gender" id="gender" required>
                        <?php foreach ($genders as $gender) : ?>
                            <option value=<?php echo $gender["gender_id"] ?>><?php echo $gender["gender"] ?></option>
                        <?php endforeach ?>
                    </select> <br> <br>
                </section>
            </div>

            <div class="row level-email">
                <section>
                    <label for="lastname"><span class="required">*</span> Year Level: </label>
                    <select name="year_level" id="year" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select> <br> <br>
                </section>
                <section>
                    <label for="tupmail"><span class="required">*</span> TUP Email: </label>
                    <input type="email" name="tupemail" required> <br> <br>
                </section>

            </div>

            <div class="row password">
                <section>
                    <label for="username"><span class="required">*</span> Username: </label>
                    <input type="text" name="username" required> <br> <br>
                </section>
                <section>
                    <label for="password"><span class="required">*</span> Password: </label>
                    <input type="password" name="password" required> <br> <br>
                </section>
                <section>
                    <label for="confirmpass"><span class="required">*</span> Confirm Password: </label>
                    <input type="password" name="confirmpass" required> <br> <br>
                </section>
            </div>
            <a class="login-instead" href="./login">Login instead</a>

        <?php } else { ?>
            <label for="campus"> Campus:</label>
            <select name="campus" id="campus" required>
                <?php foreach ($campuses as $campus) : ?>
                    <option value=<?php echo $campus["campus_id"] ?>><?php echo $campus["campus_name"] ?></option>
                <?php endforeach ?>
            </select> <br> <br>

            <label for="college"> College:</label>
            <select name="college" id="college" required>
                <?php foreach ($colleges as $college) : ?>
                    <option value=<?php echo $college["college_id"] ?>><?php echo $college["college_name"] . ' - ' .  $college["college_code"] ?></option>
                <?php endforeach ?>
            </select> <br> <br>

            <label for="lastname"> Course: </label>
            <select name="course" id="course" required>
                <?php foreach ($courses as $course) : ?>
                    <option value=<?php echo $course["course_id"] ?>><?php echo $course["course_name"] . ' - ' .  $course["course_code"] ?></option>
                <?php endforeach ?>
            </select> <br> <br>


            <label for="user-interests">Please pick your interests:</label> <br>
            <section class="interest-container">
                <?php foreach ($categories as $category) : ?>
                    <section class="interest">
                        <input type="checkbox" class="user-interests" name="user-interests[]" value=<?php echo $category["category_id"] ?> /><span><?php echo $category["category_name"] ?></span>
                    </section>
                <?php endforeach ?>
            </section>


            <br> <br>

        <?php } ?>

        <button type="submit" value="register">
            <?php
            if ($type === "first") echo "Next";
            else echo "Register";
            ?>
        </button>

        </form>
        </div>
        <div class="logo-container">
            <img src="../public/assets/logo.svg" />
        </div>
    </main>
</body>

</html>