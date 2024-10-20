
function validateform(){
    //first page
    var fname = document.getElementById('fname').value.trim();
    var lname = document.getElementById('lname').value.trim();
	var dob = document.getElementById('dob').value.trim();
	var mobile = document.getElementById('mobile').value.trim();
	var email = document.getElementById('email').value.trim();
    var valid1 = true;


    // first name    
    if(!fname){
        document.getElementById("fnameError").innerHTML="<br>Enter first name";
        valid1 = false;
    }
    else{
        document.getElementById("fnameError").innerHTML="";
    }
    
    // last name
    if(!lname){
        document.getElementById("lnameError").innerHTML="<br>Enter last name";
	    valid1 = false;
    }
    
    else{
        document.getElementById("lnameError").innerHTML="";
    }
    
    // date of birth name
    if(!dob){
        document.getElementById("dobError").innerHTML="<br>Enter Date of birth";
	    valid1 = false;
    }
    else{
        document.getElementById("dobError").innerHTML="";
    }

    // mobile no
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

    return valid1;


}

 
function validateform2(){
     //family details
     var ffname = document.getElementById('ffname').value.trim();
     var flname = document.getElementById('fflname').value.trim();
     var frel = document.getElementById('frel').value.trim();
     var fage = document.getElementById('fage').value.trim();
 
     var valid2 = true;
 
 
     //first name
     if(!ffname){  
         document.getElementById("ffnameError").innerHTML = "<br>Enter first name";
         valid2 = false;
 
     }
     else{
         document.getElementById("ffnameError").innerHTML = "";
     }
     
     //last name
     if(!flname){  
         document.getElementById("flnameError").innerHTML = "<br>Enter last name";
         valid2 = false;
 
     }
     else{
         document.getElementById("flnameError").innerHTML = "";
     }
     //relationship
     if(!frel){  
         document.getElementById("frelError").innerHTML = "<br>Enter relation name";
         valid2 = false;
 
     }
     else{
         document.getElementById("frelError").innerHTML = "";
     }
 
     //age
     if(!fage){  
         document.getElementById("fageError").innerHTML = "<br>Enter age name";
         valid2 = false;
 
     }
     else{
         document.getElementById("fageError").innerHTML = "";
     }
     return valid2;

}
    
 
function validateform3(){
    
     //address details
     var aline1 = document.getElementById('aline1').value.trim();
     var city = document.getElementById('city').value.trim();
     var pincode = document.getElementById('pincode').value.trim();
     var state = document.getElementById('state').value.trim();
    var valid3 = true;
        
        
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
      return valid3;
}

/*
//file upload
function validateform()
{
    var profilePic = document.getElementById('profilePic');
    var otherDoc = document.getElementById('otherDoc');
    const filePath = profilePic.value;
    const filePath_oth = otherDoc.value;
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    const allowedExtensions_oth=/(\.docx|\.doc|\.pdf)$/i;
    
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
        document.getElementById("otherDocError").innerHTML = "Please upload file having extensions .docx, .doc, .pdf only.";
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


// edit data

function showEdit(){
    //Window.location.href="edit.php";
}
var button = document.getElementById('editButton');
button.addEventListener('click',showEdit)

*/


