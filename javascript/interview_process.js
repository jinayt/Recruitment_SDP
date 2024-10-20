function validateForm() {
    var valid = true;
    var status = $('#status').val().trim();

    var h_date = $('#hire_date').val();
    var hire_date = new Date(h_date);
    hire_date.setHours(0, 0, 0, 0);

    var i_date = $('#inter_date').val();
    var inter_date = new Date(i_date);
    inter_date.setHours(0, 0, 0, 0);

    var current_date = new Date();
    current_date.setHours(0, 0, 0, 0);


    // alert(hire_date + ' ' + h_date);

    $('#dateError').html('');

    if (status === 'Selected' && (!h_date)) {
        $('#dateError').html('Please Enter Date.<br>');
        valid = false;
    } else if (status === 'Selected' && (current_date > hire_date)) {
        $('#dateError').html('Hire date cannot be in the past.<br>');
        valid = false;
    }


    if (status === 'In Progress' && (!i_date)) {
        $('#dateError').html('Please Enter Date.<br>');
        valid = false;
    } else if (status === 'In Progress' && (current_date > inter_date)) {
        $('#dateError').html('Interview date cannot be in the past.<br>');
        valid = false;
    }


    return valid;
}

//update form
$(document).ready(function() {
    

    $(document).on('change', '#status', function() {
        var status = $(this).val();

        if (status === 'Selected') {
            $('#hire_date').css('display', 'block');
            $('#hire_lable').css('display', 'block');
            $('#inter_date').val('');
        } else {
            $('#hire_date').css('display', 'none');
            $('#hire_lable').css('display', 'none');
        }

        if (status === 'In Progress') {
            $('#inter_date').css('display', 'block');
            $('#int_lable').css('display', 'block');
            $('#hire_date').val('');
        } else {
            $('#inter_date').css('display', 'none');
            $('#int_lable').css('display', 'none');
        }

    });

    $(document).on('click', '#updateButton', function() {
        var apply_id = $(this).data('app-id');
        var person_id = $(this).data('person-id');

        $.ajax({
            url: 'interview_man.php',
            type: 'POST',
            data: {
                apply_id: apply_id,
                person_id: person_id
            },
            success: function(data) {
                $('#update').html(data);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
                alert("Error: " + xhr.responseText);
            }

        });
    });


    $(document).on('click', '#submit', function(e) {
        
    if (!validateForm()) {
        return;
    }
    else{
        var app_id = $(this).data('app-id');
        var person_id = $(this).data('person-id');
        var status = $('#status').val().trim();
        var hire_date = $('#hire_date').val();
        var inter_date = $('#inter_date').val();
        alert(person_id); 

    $.ajax({
        url: 'interview_man.php',
        type: 'POST',
        data: {
            person_id: person_id,
            app_id: app_id,
            status: status,
            hire_date: hire_date,
            inter_date: inter_date
        },
        success: function(data) {
            
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + status + " - " + error);
            alert("Error: " + xhr.responseText);
        }

    });
    }
    });

   

});