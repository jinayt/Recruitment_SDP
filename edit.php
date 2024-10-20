<?php include_once "header.php";?>
<?php 
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
print_r($id);
$result='';
?> 

<div class="container">
    <div class="container1">
        <form id="myreg" method="post" action="update.php" onsubmit="return validateform()" enctype="multipart/form-data">
            <div class="form-step" id="step1">
                <div class="input-text">
                    <h2> Step 1: Personal Details:</h2><br>
                    <label for="fname">Name:</label><br>
                    <input type="text" id="fname" name="fname" value="<?php echo $result ? $result : '';?>" placeholder="Enter Fist Name" maxlength="20">
                    <span class="err" id="fnameError"></span>
                    <input type="text" id="lname" name="lname" placeholder="Enter Last Name" maxlength="20">
                    <span class="err" id="lnameError"></span>
                    <br>
                    <label for="dob">Date of Birth:</label><br>
                    <input type="date" id="dob" name="dob" placeholder="Date of Birth">
                    <span class="err" id="dobError"></span>
                    <br>
                    <label for="mobile">Mobile NO:</label><br>
                    <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile No" maxlength="10">
                    <span class="err" id="mobileError"></span>
                    <br>
                    <label for="email">Email Id:</label><br>
                    <input type="email" id="email" name="email" placeholder="Enter Email ID" maxlength="40">
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

                <div class="btn">
                    <button type="button" class="btn1" onclick="showNextStep1(2)">Next</button>
                </div>
            </div>
            <div class="form-step" id="step2" style="display:none;">
                <div class="input-text">
                    <br>
                    <h2>Step 2: Login Details:</h2><br>
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username" placeholder="Enter Username" onchange="checkusername()" maxlength="20">
                    <span class="err" id="usernameError"></span><br>
                    <label for="paswrd">Password:</label><br>
                    <input type="password" id="paswrd" name="paswrd" placeholder="Enter Password" maxlength="15">
                    <span class="err" id="passError"></span><br>
                    <label for="paswrdcn">Confirm Password:</label><br>
                    <input type="password" id="paswrdcn" name="paswrdcn" placeholder="Enter confirm Password" maxlength="15">
                    <span class="err" id="conpassError"></span><br>
                    
                </div>
                <br>
                <div class="btn">
                    <button type="button" class="btn1" onclick="showPreviousStep(1)">Previous</button>
                    <button type="button" class="btn1" onclick="showNextStep2(3)">Next</button>
                </div>
            </div>
            <div class="form-step" id="step3" style="display:none;">
                <div class="input-text">
                    <br>
                    <h2>Step 3: Family details</Details>:</h2><br>
                    <label for="ffname">Name:</label><br>
                    <input type="text" id="ffname" name="ffname" placeholder="Enter Fist Name" maxlength="5">
                    <span class="err" id="ffnameError"></span><br>
                    
                    <input type="text" id="fflname" name="fflname" placeholder="Enter Last Name" maxlength="5">
                    <span class="err" id="flnameError"></span>
                    <br>
                    <label for="frel">Relation:</label><br>
                    <input type="text" id="frel" name="frel" placeholder="Enter Fist Name" maxlength="5">
                    <span class="err" id="frelError"></span>
                    <br>
                    <label for="fage">Age:</label><br>
                    <input type="text" id="fage" name="fage" placeholder="Enter Age" maxlength="5">
                    <span class="err" id="fageError"></span>
                    <br>
                    <br>
                    
                    <h2>Address details</h2><br>
                    <label for="aline1">Address line1:</label><br>
                    <input type="text" id="aline1" name="aline1" placeholder="Enter Address" maxlength="5">
                    <span class="err" id="aline1Error"></span>
                    <br>
                    <label for="aline2">Address line2:</label><br>
                    <input type="text" id="aline2" name="aline2" placeholder="Enter Address" maxlength="5">
                    <br>
                    <label for="aline3">Address line3:</label><br>
                    <input type="text" id="aline3" name="aline3" placeholder="Enter Address" maxlength="5">
                    <br>
                    <label for="city">City:</label><br>
                    <input type="text" id="city" name="city" placeholder="Enter city name" maxlength="5">
                    <span class="err" id="cityError"></span>
                    <br>
                    <label for="pincode">Pincode:</label><br>
                    <input type="text" id="pincode" name="pincode" placeholder="Enter city name" maxlength="6" >
                    <span class="err" id="pincodeError"></span>
                    <br>
                    <label for="state">State:</label><br>
                    <select id="state" name="state">
                        <option value="">Please Select state</option>
                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                        <option value="Assam">Assam</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Chhattisgarh">Chhattisgarh</option>
                        <option value="Goa">Goa</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Haryana">Haryana</option>
                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Manipur">Manipur</option>
                        <option value="Meghalaya">Meghalaya</option>
                        <option value="Mizoram">Mizoram</option>
                        <option value="Nagaland">Nagaland</option>
                        <option value="Odisha">Odisha</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Sikkim">Sikkim</option>
                        <option value="Tamil Nadu">Tamil Nadu</option>
                        <option value="Telangana">Telangana</option>
                        <option value="Tripura">Tripura</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Uttarakhand">Uttarakhand</option>
                        <option value="West Bengal">West Bengal</option>
                    </select>
                    <span class="err" id="stateError"></span>

                </div>
                <div class="btn">
                    <button type="button" class="btn1" onclick="showPreviousStep(2)">Previous</button>
                    <button type="button" class="btn1" onclick="showNextStep3(4)">Next</button>
                </div>
            </div>
            <div class="form-step" id="step4" style="display:none;">
                <div class="input-text">
                    <br>
                    <h2>Step 4: Document</Details>:</h2><br>
                    <label for="profilePic">Profile picture</label><br>
                    <input type="file" id="profilePic" name="profilePic">
                    <span class="err" id="profilePicError"></span>
                    <br>
                    <label for="otherDoc">Other document</label><br>
                    <input type="file" id="otherDoc" name="otherDoc">
                    <span class="err" id="otherDocError"></span>
                    <br>

                </div>
                <div class="btn">
                    <button type="button" class="btn1" onclick="showPreviousStep(3)">Previous</button>
                    <button class="btn1" type="submit" name="submit">Submit</button>
                    <button class="btn1" type="reset">Reset</button>
                </div>
            </div>
        </form>

    </div>
</div>

<?php include_once "footer.php" ?>
