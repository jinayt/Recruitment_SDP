

//first page
function showNextStep1(stepNumber) {
    var valid1 = true;

    // first name
    var fname = document.getElementById('fname').value.trim();    
    if(!fname){
        document.getElementById("fnameError").innerHTML="<br>Enter first name";
        valid1 = false;
    }
    else{
        document.getElementById("fnameError").innerHTML="";
    }
    
    // last name
    var lname = document.getElementById('lname').value.trim();
    if(!lname){
        document.getElementById("lnameError").innerHTML="<br>Enter last name";
	    valid1 = false;
    }
    
    else{
        document.getElementById("lnameError").innerHTML="";
    }
    
    // date of birth

    var dob = document.getElementById('dob').value;
    var dobDate = new Date(dob);
    var today = new Date();
    var age = today.getFullYear() - dobDate.getFullYear();
    var monthDifference = today.getMonth() - dobDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dobDate.getDate())) {
        age--;
    }

    if(!dob){
        document.getElementById("dobError").innerHTML="<br>Enter Date of birth";
	    valid1 = false;
    }
    else if(age < 18){
        document.getElementById("dobError").innerHTML="<br>Below 18 year age can't register.";
	    valid1 = false;
    }
    else{
        document.getElementById("dobError").innerHTML="";
    }

    // mobile no
    var mobile = document.getElementById('mobile').value.trim();
    var mpattern=/^[0-9]{10}$/;
    if(!mobile){
        document.getElementById("mobileError").innerHTML="<br>Enter mobile no.";
	    valid1 = false;
    }
    else if(!mpattern.test(mobile) || (mobile < 0)){
        document.getElementById("mobileError").innerHTML="<br>Please Enter 10 digit No.";
        valid1 = false;
    }
    else{
        document.getElementById("mobileError").innerHTML="";
    }

    //email
    var email = document.getElementById('email').value.trim();
    var epattern=/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if(!email){
        document.getElementById("emailError").innerHTML="<br>Enter email id";
	    valid1 = false;
    }
    else if(!epattern.test(email)){
        document.getElementById("emailError").innerHTML="<br>Please Enter valid email id";
        valid1 = false;
    }
    else{
        document.getElementById("emailError").innerHTML="";
    }

    if(!valid1) return;
     
    

    var steps = document.querySelectorAll('.form-step');
    steps.forEach(function (step) {
        step.style.display = 'none';
    });
    document.getElementById('step' + stepNumber).style.display = 'block';

}

//second page
function checkusername() {
    var username = document.getElementById("username").value.trim();
    $.ajax({
        url: 'Data_for_ajax.php',
        type: 'POST',
        data: { username: username },
        success: function (response) {
            if (response == "exists") {
                document.getElementById("usernameError").innerHTML = "Username already exists.";
                document.getElementById("myreg").onsubmit = function () {
                    return false;

                }
            } else {
                document.getElementById("usernameError").innerHTML = "";
                document.getElementById("myreg").onsubmit = null;
            }
        }
    });
}
function showNextStep2(stepNumber) {

    var username = document.getElementById("username").value.trim();
    var passwrd = document.getElementById("paswrd").value.trim();
    var cnpasswrd = document.getElementById("paswrdcn").value.trim();

    var valid2 = true;
    // username  
    if(!username){  
        document.getElementById("usernameError").innerHTML = "<br>Enter username";
        valid2 = false;

    }
    else{
        document.getElementById("usernameError").innerHTML = "";
    }

    //password
    var passPattern = /^(?=.*[A-Z])(?=.*[\W]).{6,}$/;
    if(!passwrd){  
        document.getElementById("passError").innerHTML = "<br>Enter password";
        valid2 = false;

    }
    else if(!passPattern.test(passwrd)){
        document.getElementById("passError").innerHTML = "<br>Please Enter 6 character password.(1 uppercase latter, 1 special characters)";
        valid2 = false;

    }
    else{
        document.getElementById("passError").innerHTML = "";
    }
    
    
    //confirm password
    if(!cnpasswrd){  
        document.getElementById("conpassError").innerHTML = "<br>Enter Confirm password";
        valid2 = false;

    }
    else if(cnpasswrd != passwrd){
        document.getElementById("conpassError").innerHTML = "<br>Confirm password not matching";
        valid2 = false;

    }
    else{
        document.getElementById("conpassError").innerHTML = "";
    }
    
    
    if (!valid2) return;

    var steps = document.querySelectorAll('.form-step');
    steps.forEach(function (step) {
        step.style.display = 'none';
    });
    document.getElementById('step' + stepNumber).style.display = 'block';
}

function showNextStep3(stepNumber) {

     //family details
     var ffname = document.getElementById('ffname').value.trim();
     var flname = document.getElementById('fflname').value.trim();
     var frel = document.getElementById('frel').value.trim();
     
 
     var valid3 = true;
 
 
     //first name
     if(!ffname){  
         document.getElementById("ffnameError").innerHTML = "<br>Enter first name";
         valid3 = false;
 
     }
     else{
         document.getElementById("ffnameError").innerHTML = "";
     }
     
     //last name
     if(!flname){  
         document.getElementById("flnameError").innerHTML = "<br>Enter last name";
         valid3 = false;
 
     }
     else{
         document.getElementById("flnameError").innerHTML = "";
     }
     //relationship
     if(!frel){  
         document.getElementById("frelError").innerHTML = "<br>Enter relation name";
         valid3 = false;
 
     }
     else{
         document.getElementById("frelError").innerHTML = "";
     }
 
     //age
     var fage = document.getElementById('fage').value;
     var fageDate = new Date(fage);
     fageDate.setHours(0, 0, 0, 0);
     var today = new Date();
     today.setHours(0, 0, 0, 0);

     if(!fage){  
         document.getElementById("fageError").innerHTML = "<br>Enter date of birth.";
         valid3 = false;
 
     }
     else if(fageDate > today){
        document.getElementById("fageError").innerHTML = "<br>Date of birth cannot be in future.";
         valid3 = false;
     }
     else{
         document.getElementById("fageError").innerHTML = "";
     }
 
 
     //address details
     var aline1 = document.getElementById('aline1').value.trim();
     var city = document.getElementById('city').value.trim();
     var pincode = document.getElementById('pincode').value.trim();
     var state = document.getElementById('state').value.trim();
 
     //line1 
     if(!aline1){  
         document.getElementById("aline1Error").innerHTML = "<br>Enter address line";
         valid3 = false;
 
     }
     else{
         document.getElementById("aline1Error").innerHTML = "";
     }
 
     //city
     if(!city){  
         document.getElementById("cityError").innerHTML = "<br>Enter city name";
         valid3 = false;
 
     }
     else{
         document.getElementById("cityError").innerHTML = "";
     }
     
     //pincode
     var ppattern=/^[0-9]{6}$/;
     if(!pincode){  
         document.getElementById("pincodeError").innerHTML = "<br>Enter pincode";
         valid3 = false;
 
     }
     else if(!ppattern.test(pincode) || (pincode < 0)){
         document.getElementById("pincodeError").innerHTML = "<br>Enter valid pincode";
         valid3 = false;
     }
     else{
         document.getElementById("pincodeError").innerHTML = "";
     }
     //state
     if(!state){  
         document.getElementById("stateError").innerHTML = "<br>Enter city name";
         valid3 = false;
 
     }
     else{
         document.getElementById("stateError").innerHTML = "";
     }
     
     if(!valid3) return;

    var steps = document.querySelectorAll('.form-step');
    steps.forEach(function (step) {
        step.style.display = 'none';
    });
    document.getElementById('step' + stepNumber).style.display = 'block';

}



//previus page
function showPreviousStep(stepNumber) {
    var steps = document.querySelectorAll('.form-step');
    steps.forEach(function (step) {
        step.style.display = 'none';
    });
    document.getElementById('step' + stepNumber).style.display = 'block';

}
//file upload
function validateform()
{
    var profilePic = document.getElementById('profilePic');
    var otherDoc = document.getElementById('otherDoc');
    const filePath = profilePic.value;
    const filePath_oth = otherDoc.value;
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    const allowedExtensions_oth=/(\.pdf)$/i;
    
    var valids = true;
    
    if (profilePic.files.length === 0) {
        document.getElementById("profilePicError").innerHTML = "Upload profile picture";
        valids = false;
    } else if (!allowedExtensions.exec(filePath)) {
        document.getElementById("profilePicError").innerHTML = "Please upload file having extensions .jpeg, .jpg, .png only.";
        profilePic.value = '';
        valids = false;
    }

    
    if (otherDoc.files.length === 0) {
        document.getElementById("otherDocError").innerHTML = "Upload other document";
        valids = false;
    } else if (!allowedExtensions_oth.exec(filePath_oth)) {
        document.getElementById("otherDocError").innerHTML = "Please upload file having extensions .pdf only.";
        otherDoc.value = '';
        valids = false;
    }
    return valids;
       
}
document.getElementById('myreg').addEventListener('submit', function(event) {
    if (!validateform()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});



