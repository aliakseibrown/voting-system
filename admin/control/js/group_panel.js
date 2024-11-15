function fetchGroups() {
    $.ajax({
        url: '/project/api/fetch_groups.php',
        method: 'GET',
        success: function (data) {
            var groups = JSON.parse(data);
            $('#groups').empty();
            groups.forEach(function (group) {
                console.log('Group:', group);
                $('#groups').append(
                    '<div class="group" data-group-id="' + group.id + '">' +
                    '<div>Group name: ' + group.group_name + '</div>' +
                    '<div>users: ' + group.users.length + '</div>' +
                    '<button class= "square-button" onclick="deleteGroup(' + group.id + ')">Delete</button>' +
                    '<button class= "square-button" onclick="editGroup(' + JSON.stringify(group).replace(/"/g, '&quot;') + ')">Edit</button>' +
                    '</div>'
                );
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            alert('An error occurred while fetching the groups.');
        }
    });
}
function deleteGroup(groupId) {
    console.log('Group ID:', groupId);
    $.ajax({
        url: '/project/api/delete_group.php',
        method: 'POST',
        data: { id: groupId },
        success: function (response) {
            var parsedResponse = JSON.parse(response);
            console.log(parsedResponse.success);
            if (parsedResponse.success) {
                // alert('Vote deleted successfully');
                fetchGroups(); // Refresh the votes
            } else {
                alert('An error occurred while deleting the vote');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            alert('An error occurred while deleting the group.');
        }
    });
}
function editGroup(group) {
    $('#section-container-2').html(`
        <h2>Edit a group</h2>
        <input type="text" class="general-input" id="group-name" value="${group.group_name}">
        <input type="number" class="general-input" id="main-proxies" ${group.main_proxies} min="0" max="2">
        <input type="text" class="general-input" id="email" placeholder="Enter user's email">
        <button class="square-button" id="check-voter" >Add User</button>
        <button class="square-button" id="save-group">Save Group</button>
    `);
}
$(document).ready(function () {
    fetchGroups();
    $('#create-group').click(function () {
        $('#section-container-2').html(`
        <h2>Create a group</h2>
        <input type="text" class="general-input" id="group-name" placeholder="Enter group's name">
        <input type="number" class="general-input" id="main-proxies" placeholder="Enter number of proxies" min="0" max="2">
        <input type="text" class="general-input" id="email" placeholder="Enter user's email">
        <button class="square-button" id="check-voter" >Add User</button>
        <button class="square-button" id="save-group">Save Group</button>
`);
    });

    $('.groups').on('click', '.group', function () {
        var groupId = $(this).data('group-id');
        $.ajax({
            url: '/project/api/fetch_group.php',
            method: 'POST',
            data: {
                groupId: groupId
            },
            success: function (response) {
                var data = JSON.parse(response);
                var html = '<h2>Edit Group</h2>';
                data.users.forEach(function (user) {
                    html += '<p>' + user.email + ' <button class="remove-user" data-user-id="' + user.id + '">Remove</button> Proxies: <input type="number" class="proxies-input" value="' + user.proxies + '" min="0" max="2"></p>';
                });
                html += '<button class="square-button" id="save-group">Save Group</button>';
                $('#section-container-2').html(html);
            },
            error: function () {
                alert('An error occurred while fetching the group.');
            }
        });
    });

    $(document).on('click', '#check-voter', function (e) {
        // $('#check-voter').click(function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var proxies = $('#proxies').val() || 0; // Default to 2 if the field is empty
        if (proxies > 2) {
            alert('Maximum number of proxies is 2');
            return;
        }
        // console.log(email);
        $.ajax({
            url: '/project/api/check_email.php',
            method: 'POST',
            data: {
                email: email
            },
            success: function (response) {
                var data = JSON.parse(response);
                var emails = [];
                // console.log(data.user); // Log the user data to the console
                // console.log(data.success);
                if (data.success) {
                    // console.log(data.success);
                    var emailExists = false;
                    $('#section-container-2 p').each(function () {
                        if ($(this).text().indexOf(data.user.email) !== -1) {
                            emailExists = true;
                            return false; // Break out of the .each() loop
                        }
                    });
                    if (!emailExists) {
                        $('#section-container-2').append('<p data-user-id="' + data.user.id + '" data-user-email="' + data.user.email + '">' + data.user.name + ' ' + data.user.surname + ' ' + data.user.email + ' Proxies: <input type="number" class="proxies-input" value="' + proxies + '" min="0" max="2"> <button class="square-button delete-email">Delete</button></p>');
                        // $('#section-container-2').append('<p>' + data.user.name + ' ' + data.user.surname + ' ' + data.user.email + ' Proxies: <input type="number" class="proxies-input" value="' + proxies + '" min="0" max="2"> <button class="square-button delete-email">Delete</button></p>');
                        var existingEmails = $('#voter-emails').val();
                        if (existingEmails !== '') {
                            existingEmails += ',';
                        }
                        $('#voter-emails').val(existingEmails + data.user.email);
                    } else {
                        alert('Email already exists in the list');
                    }
                } else {
                    alert('User not found');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX error: ", textStatus, errorThrown);
            }
        });

        $(document).on('click', '.delete-email', function () {
            console.log($(this).parent().text().split(' '));
            var emailToRemove = $(this).parent().text().split(' ')[2]; // Assuming the email is the third word in the text
            var existingEmails = $('#voter-emails').val().split(',');
            var emailIndex = existingEmails.indexOf(emailToRemove);
            var existingProxies = $(this).siblings('.proxies-input').val();
            if (emailIndex > -1) {
                existingEmails.splice(emailIndex, 1);
            }
            $('#voter-emails').val(existingEmails.join(','));
            $(this).parent().remove();
        });

    });

    $(document).on('click', '#save-group', function () {
        console.log('save-group button clicked'); // Add this line
        var groupName = $('#group-name').val();
        var mainProxies = $('#main-proxies').val();
        var users = [];
        $('#section-container-2 p').each(function () {
            var user_id = $(this).data('user-id');
            var user_email = $(this).data('user-email');
            var proxies = parseInt($(this).find('.proxies-input').val(), 10);

            users.push({
                user_id: user_id,
                user_email: user_email,
                proxies: proxies,
                voted_for: [],
                voted: ""
            });
            console.log(users); // This should log the current paragraph element
        });
        $.ajax({
            url: '/project/api/save_group.php',
            method: 'POST',
            data: {
                group_name: groupName,
                main_proxies: mainProxies,
                users: JSON.stringify(users)
            },
            success: function (response) {
                console.log(response); // Log the response from the server
                fetchGroups();
                // location.reload(); // Reload the page to update the group
            }
        });
    });
});