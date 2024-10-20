function validateform()
{
	let fname = document.getElementById('fname').value;
	let lname = document.getElementById('lname').value;
	let dob = document.getElementById('dob').value;
	let mobile = document.getElementById('mobile').value;
	let email = document.getElementById('email').value;
	let username = document.getElementById('username').value;
	let paswrd = document.getElementById('paswrd').value;

// all error set to null
	document.getElementById("mobileError").innerHTML="";
	document.getElementById("emailError").innerHTML="";
	document.getElementById("passError").innerHTML="";


		
// patterns for validation
	let mpattern=/^[0-9]{10}$/;
	let epattern=/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
	let passPattern = /^(?=.*[A-Z])(?=.*[\W]).{6,}$/;

	if(fname == "" || lname == "" || dob == "" || mobile == "" || email== "" || logid == "" || paswrd == "")
		{
			alert("All fields are mendatory");
			return false;
		}


// mobile validation
	if(!mpattern.test(mobile))
		{
			document.getElementById("mobileError").innerHTML="Please Enter 10 digit No.";
			return false;
		}

// email validation
	if(!epattern.test(email))
		{
			document.getElementById("emailError").innerHTML="Please Enter valid email ID";
			return false;
		}


//password validation
	if(!passPattern.test(paswrd))
	{
		document.getElementById("passError").innerHTML="Please Enter 6 character password.(1 uppercase latter, 1 special characters)";
		return false;
	}

	return true;

}

function checkusername(){
	var username = document.getElementById("username").value;
	$.ajax({
		url: 'check_username.php',
		type: 'POST',
		data: { username: username },
		success: function(response) {
			if (response == "exists") {
				document.getElementById("usernameError").innerHTML = "Username already exists<br>";
				document.getElementById("myreg").onsubmit = function() {
                    return false;
				
				}
			} else {
				document.getElementById("usernameError").innerHTML = "";
				document.getElementById("myreg").onsubmit = null;
			}
		}
	});
}

function showNextStep(stepNumber) {
    var steps = document.querySelectorAll('.form-step');
    steps.forEach(function(step) {
        step.style.display = 'none';
    });
    document.getElementById('step' + stepNumber).style.display = 'block';
	
}

function showPreviousStep(stepNumber) {
    var steps = document.querySelectorAll('.form-step');
    steps.forEach(function(step) {
        step.style.display = 'none';
    });
    document.getElementById('step' + stepNumber).style.display = 'block';
	
}


/*
function validateStep(stepNumber) {
    let isValid = true;
    const step = document.querySelector(`#step${stepNumber}`);
    const inputs = step.querySelectorAll('input[required]');

    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('error');
            input.nextElementSibling.textContent = 'This field is required';
        } else {
            input.classList.remove('error');
            input.nextElementSibling.textContent = '';
        }
    });

    return isValid;
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', () => {
            if (input.value.trim()) {
                input.classList.remove('error');
                input.nextElementSibling.textContent = '';
            }
        });
    });

    // Prevent form submission for navigation buttons
    document.querySelectorAll('.btn1').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
        });
    });
});
*/