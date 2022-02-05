<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url() . "public/style.css" ?>">

    <title>TUP Connect Registration</title>
</head>

<body>
    <main class="sign-up-container">
        <div>
            <figure>
                <img src="<?php echo base_url() . "public/assets/logo.svg" ?>" />
            </figure>

            <?php echo form_error(); ?>
            <?php echo form_open($action, "id='basic-profile-id'"); ?>

            <?php if ($type === "first") { ?>
                <div class="reg-basic-profile">
                    <div>
                        <section>
                            <label for="givenname" class="input-label"><span class="required">*</span> Given Name: </label>
                            <input type="text" class="input-input" name="givenname" required> <br> <br>
                        </section>
                        <section>

                            <label for="middlename" class="input-label"> Middle Name: </label>
                            <input type="text" class="input-input" name="middlename">
                        </section>
                        <section>

                            <label for="lastname" class="input-label"><span class="required">*</span> Last Name: </label>
                            <input type="text" class="input-input" name="lastname" required> <br> <br>
                        </section>

                        <section>
                            <label for="lastname" class="input-label"><span class="required">*</span> Birthday: </label>
                            <input type="date" class="input-input" name="birthday" required> <br> <br>
                        </section>
                        <section>
                            <label for="lastname" class="input-label"><span class="required">*</span> Gender: </label>
                            <select name="gender" class="input-input" id="gender" required>
                                <?php foreach ($genders as $gender) : ?>
                                    <option value=<?php echo $gender["gender_id"] ?>><?php echo $gender["gender"] ?></option>
                                <?php endforeach ?>
                            </select> <br> <br>
                        </section>
                    </div>
                    <div>
                        <section>
                            <label for="lastname" class="input-label"><span class="required">*</span> Year Level: </label>
                            <select name="year_level" class="input-input" id="year" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select> <br> <br>
                        </section>
                        <section>
                            <label for="tupmail" class="input-label"><span class="required">*</span> TUP Email: </label>
                            <input type="email" id="reg-email" class="input-input" name="tupemail" required> <br> <br>
                        </section>


                        <section>
                            <label for="username" class="input-label"><span class="required">*</span> Username: </label>
                            <input type="text" class="input-input" name="username" required> <br> <br>
                        </section>
                        <section>
                            <label for="password" class="input-label"><span class="required">*</span> Password: </label>
                            <input type="password" id="reg-password" class="input-input" name="password" required> <br> <br>
                        </section>
                        <section>
                            <label for="confirmpass" class="input-label"><span class="required">*</span> Confirm Password: </label>
                            <input type="password" id="reg-confirm-password" class="input-input" name="confirmpass" required> <br> <br>
                        </section>
                    </div>
                </div>
                <button type="submit" class="input-button" value="register">Next</button>
                <a class="login-instead" href="<?php echo base_url() . "login" ?>">Login instead</a>
        </div>

    <?php } else { ?>
        <div class="reg-univ-profile">
            <div>
                <label for="campus" class="input-label"> Campus:</label>
                <select name="campus" id="campus" class="input-input" required>
                    <?php foreach ($campuses as $campus) : ?>
                        <option value=<?php echo $campus["campus_id"] ?>><?php echo $campus["campus_name"] ?></option>
                    <?php endforeach ?>
                </select> <br> <br>

                <label for="college" class="input-label"> College:</label>
                <select name="college" id="college" class="input-input" required>
                    <?php foreach ($colleges as $college) : ?>
                        <option value=<?php echo $college["college_id"] ?>><?php echo $college["college_name"] . ' - ' .  $college["college_code"] ?></option>
                    <?php endforeach ?>
                </select> <br> <br>

                <label for="lastname" class="input-label"> Course: </label>
                <select name="course" id="course" class="input-input" required>
                    <?php foreach ($courses as $course) : ?>
                        <option value=<?php echo $course["course_id"] ?>><?php echo $course["course_name"] . ' - ' .  $course["course_code"] ?></option>
                    <?php endforeach ?>
                </select> <br> <br>
            </div>
            <div>
                <label for="user-interests" class="input-label">Please pick your interests:</label> <br>
                <section class="interest-container">
                    <?php foreach ($categories as $category) : ?>
                        <section class="interest input-input">
                            <input type="checkbox" class="user-interest" name="user-interests[]" value=<?php echo $category["category_id"] ?> /><span><?php echo $category["category_name"] ?></span>
                        </section>
                    <?php endforeach ?>
                </section>
            </div>
        </div>
        <div class="center-align">
            <button type="submit" class="input-button" value="register">Submit</button>
        </div>

    <?php } ?>

    </form>
    </main>
    <script src=<?php echo  base_url() . "public/script.js" ?>></script>
    <script>
        controller.init()
    </script>
</body>

</html>