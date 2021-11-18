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
        <div class="header">

            <h1>TUP Connect</h1>
            <h2>Register Here!</h2>

        </div>

        <form method="post" action="<?php echo base_url();?>register/validation">

            <div>
                <label for= "givenname"> Given Name: </label> 
                <input type="text" name= "givenname" required> <br> <br>
                
                <label for= "middlename"> Middle Name: </label>
                <input type="text" name= "middlename">

                <label for= "lastname"> Last Name: </label> 
                <input type="text" name= "lastname" required> <br> <br>

                <label for= "tupmail"> TUP Email: </label> 
                <input type="email" name= "tupmail" required> <br> <br>

                <label for= "username"> Username: </label> 
                <input type="text" name= "username" required> <br> <br>

                <label for= "password"> Password: </label> 
                <input type="password" name= "password" required> <br> <br>

                <label for= "confirmpass"> Confirm Password: </label>
                <input type="password" name= "confirmpass" required> <br>  <br>

            </div>
            
            <button type="submit" value= "register"> Create Account </button>

            <h3>Already have an account <a href="login_account">Log In</a></h3>

            </div>

        <label for="user-photo">Profile Photo:</label>
        <input type="file" name="user-photo"> <br> <br>
        
    
        <div>
            <label for="campus"> Campus:</label>
            <select name="campus" id="campus" forms="campus" required>
                <option value="none"></option>
                <option value="TUPM">TUP Manila</option>
                <option value="TUPT">TUP Taguig</option>
                <option value="TUPC">TUP Cavite</option>
                <option value="TUPV">TUP Visayas</option>
            </select> <br> <br>
        </div>

        <div>
            <label for="college"> College:</label>
            <input type="text" name="college" required> <br> <br>
        </div>

        <div>
            <label for="user-cor">Certificate of Registration:</label>
            <input type="file" name="user-cor"> <br> <br>
        </div>

        <div>
            <label for="user-interests">Please pick your interests:</label> <br> 
            <input type="checkbox" id="user-interests" name="user-interests" value="Arts"/> Arts
            <input type="checkbox" id="user-interests" name="user-interests" value="Education"/> Education
            <input type="checkbox" id="user-interests" name="user-interests" value="Engineering"/> Engineering
            <input type="checkbox" id="user-interests" name="user-interests" value="Film"/> Film <br> <br>
            <input type="checkbox" id="user-interests" name="user-interests" value="Games"/> Games
            <input type="checkbox" id="user-interests" name="user-interests" value="Math"/> Math
            <input type="checkbox" id="user-interests" name="user-interests" value="Memes"/> Memes
            <input type="checkbox" id="user-interests" name="user-interests" value="Music"/> Music <br> <br>
            <input type="checkbox" id="user-interests" name="user-interests" value="Politics"/> Games
            <input type="checkbox" id="user-interests" name="user-interests" value="Programming"/> Math
            <input type="checkbox" id="user-interests" name="user-interests" value="Science"/> Memes
            <input type="checkbox" id="user-interests" name="user-interests" value="Sports"/> Music <br> <br>

        </div>

        </form>

        

    </div>
</body>
</html>