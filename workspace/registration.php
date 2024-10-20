<?php include "heder.php";?>
    <div class="container">
        <div class="container1">
            <h2>Personal Details:</h2><br>
            <form  id="myreg"  method="post" action="reg_manager.php" onsubmit="return validateform()">
               <div class="input-text">
                    <label for="fname">Name:</label><br>
                    <input type="text" id="fname" name="fname" placeholder="Enter Fist Name">
                    <input type="text" id="lname" name="lname" placeholder="Enter Last Name">
                    <br>
                    <label for="dob">Date of Birth:</label><br>
                    <input type="date" id="dob" name="dob"  placeholder="Date of Birth" >
                    <br> 
                    <label for="mobile">Mobile NO:</label><br>
                    <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile No">
                    <span class="err" id="mobileError"></span>
                    <br>
                    <label for="email">Email Id:</label><br>
                    <input type="email" id="email" name="email" placeholder="Enter Email ID" >
                    <span class="err" id="emailError"></span>
                </div>
                
                <div class="input-btn">
                    <label for="gender">Gender:</label><br><br>
                    <input type="radio" id="gender" name="gender" value="M" checked>
                    <label for="male">Male</label>
                    <input type="radio" id="gender" name="gender" value="F">
                    <label for="female">Female</label>
                    <input type="radio" id="gender" name="gender" value="O">
                    <label for="other">Other</label>
                </div>

                <div class="input-text">
                    <br>
                    <h2>Login Details:</h2><br>
                    <label for="username">Username:</label><br>
                    <input type="text"id="username" name="username" placeholder="Enter Username" onchange="checkusername()"><br>
                    <span class="err" id="usernameError"></span>
                    <label for="logid">Password:</label><br>
                    <input type="password" id="paswrd" name="paswrd" placeholder="Enter Password">
                    <span class="err" id="passError"></span>
                </div>
                <br>
                <div class="btn">
                    <button class="btn1" type="submit">Submit</button><button class="btn1" type="reset">Reset</button>
                </div>
            </form>

        </div>
    </div>
<?php include "footer.php"?>