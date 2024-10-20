function addTittle() {
    var option = document.getElementById('title').value.trim();
    if (option == "Other") {
        document.getElementById('hideninput').innerHTML = "<br><input type='text' id='new_title' name='new_title' placeholder='Enter new title' onkeyup='checkTittle()'>";
    } else {
        document.getElementById('hideninput').innerHTML = "";
    }
}

// job tittle 
function checkTittle() {
    var new_title = document.getElementById("new_title").value.trim();
    $.ajax({
        url: 'Data_for_ajax.php',
        type: 'POST',
        data: { new_title: new_title },
        success: function (response) {
            if (response == "exists") {
                document.getElementById("titleError").innerHTML = "<br>Tittle already exists";
                document.getElementById("createjob").onsubmit = function () {
                    document.getElementById("titleError").innerHTML = "<br>Tittle already exists";
                    return false;

                }
            } else {
                document.getElementById("titleError").innerHTML = "";
                document.getElementById("createjob").onsubmit = null;
            }
        }
    });
}


function validateform2() {
    var job_title = document.getElementById('title').value.trim();
    var new_title = job_title == "Other" ? document.getElementById('new_title').value.trim() : "";
    var s_date = document.getElementById('s_date').value;
    var e_date = document.getElementById('e_date').value;
    var num_post = document.getElementById('num_post').value;
    var desc = document.getElementById('desc').value;

    var valid4 = true;

    // Clear previous error messages
    document.getElementById("titleError").innerHTML = "";
    document.getElementById("s_dateError").innerHTML = "";
    document.getElementById("e_dateError").innerHTML = "";
    document.getElementById("num_postError").innerHTML = "";
    document.getElementById("descError").innerHTML = "";

    if (!job_title) {
        document.getElementById("titleError").innerHTML = "<br>Enter job title";
        valid4 = false;
    } else if (job_title == "Other" && !new_title) {
        document.getElementById("titleError").innerHTML = "<br>Enter job title";
        valid4 = false;
    }

    if (!s_date) {
        document.getElementById("s_dateError").innerHTML = "<br>Enter opening date";
        valid4 = false;
    }

    if (!e_date) {
        document.getElementById("e_dateError").innerHTML = "<br>Enter closing date";
        valid4 = false;
    }

    if (!num_post) {
        document.getElementById("num_postError").innerHTML = "<br>Enter number of job vacancy ";
        valid4 = false;
    }
    
    if (!desc) {
        document.getElementById("descError").innerHTML = "<br>Enter description ";
        valid4 = false;
    }

    return valid4;
}

document.getElementById('createjob').addEventListener('submit', function(event) {
    if (!validateform2()) {
        event.preventDefault();
    }
});


//search
//$(document).ready(function(){
//$("#live_search").on("key",function(e)
/*function liveSearch()
        {
            //var search_term = $(this).val().trim();
            var search_term = document.getElementById("live_search").value.trim();
            $.ajax({
                url: 'Data_for_ajax.php',
                type: 'POST',
                data: { search: search_term },
                success: function (data) {
                    $("#table_data").html(data);
                },
                error: function (xhr, status, error) {
                    // Handle errors here
                    console.error('Error occurred: ', error);
                }
            });
        }//);
    
//});
*/


    

    
    
