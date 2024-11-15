$(document).ready(function () {
    var optionCount = 2;
    $('#add-option').click(function (e) {
        e.preventDefault();
        $('#option-container').append('<input type="text" class="general-input" name="option[]" placeholder="Option ' + optionCount + '" />');
        optionCount++;
    });
    $('#cancel-option').click(function (e) {
        e.preventDefault();
        if (optionCount > 2) { // Prevents removing the first option
            $('#option-container').children().last().remove();
            optionCount--;
        }
    });
    $('#check-voter').click(function (e) {
        e.preventDefault();
        var email = $('#email').val();
        var proxies = $('#proxies').val() || 0; // Default to 2 if the field is empty

        if (proxies > 2) {
            alert('Maximum number of proxies is 2');
            return;
        }
        console.log(email);
        $.ajax({
            url: '/project/api/check_email.php',
            method: 'POST',
            data: {
                email: email
            },
            success: function (response) {
                var data = JSON.parse(response);
                var emails = [];
                console.log(data.success);
                if (data.success) {
                    console.log(data.success);
                    var emailExists = false;
                    $('#email-list p').each(function () {
                        if ($(this).text().indexOf(data.user.email) !== -1) {
                            emailExists = true;
                            return false; // Break out of the .each() loop
                        }
                    });
                    if (!emailExists) {
                        $('#email-list').append('<p>' + data.user.name + ' ' + data.user.surname + ' ' + data.user.email + ' Proxies: <input type="number" class="proxies-input" value="0" min="0" max="2"> <button class="delete-email">Delete</button></p>');
                        var existingEmails = $('#voter-emails').val();
                        // var proxies = parseInt($(this).find('.proxies-input').val(), 10);

                        if (existingEmails !== '') {
                            existingEmails += ',';
                        }
                        var newVoter = {
                            user_id: data.user.id,
                            user_email: data.user.email,
                            proxies: parseInt(proxies, 10),
                            voted_for: [],
                            voted: ''
                        };

                        $('#voter-emails').val(existingEmails + JSON.stringify(newVoter));
                    } else {
                        alert('Email already exists in the list');
                    }
                } else {
                    alert('User not found');
                }
            }
        });
        $(document).on('click', '.delete-email', function () {
            var emailToRemove = $(this).parent().text().split(' ')[2]; // Assuming the email is the third word in the text
            var existingEmails = $('#voter-emails').val().split(',');
            var emailIndex = existingEmails.indexOf(emailToRemove);
            if (emailIndex > -1) {
                existingEmails.splice(emailIndex, 1);
            }
            $('#voter-emails').val(existingEmails.join(','));
            $(this).parent().remove();
            // var emailToRemove = $(this).parent().text().split(' ')[2]; // Assuming the email is the third word in the text
            // var existingVoters = JSON.parse($('#voter-emails').val() || '[]'); // Get the existing voters from the hidden field
            // var voterIndex = existingVoters.findIndex(voter => voter.user_email === emailToRemove); // Find the index of the voter to remove
            // if (voterIndex > -1) {
            //     existingVoters.splice(voterIndex, 1); // Remove the voter from the array
            // }
            // $('#voter-emails').val(JSON.stringify(existingVoters)); // Store the updated array in the hidden field
            // $(this).parent().remove();
        });
    });
});