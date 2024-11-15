$(document).ready(function () {
    var voteId = window.location.search.split('=')[1];
    console.log(voteId);
    $.ajax({
        url: '/project/api/fetch_options.php',
        type: 'POST',
        data: { options_id: voteId },
        success: function (data) {
            var vote = JSON.parse(data);
            $('.voting-container').html('<h2>' + vote.name + '</h2>');
            $('.voting-container').append('<h2>' + vote.description + '</h2>');

            vote.options.forEach(function (option) {
                $('.voting-container').append(
                    '<button class="vote-option" data-vote-id="' + vote.vote_id + '" data-option="' + option + '">' +
                    option +
                    '</button>'
                );
            });
            $('.voting-container').append('<button class="login-button" id="vote-button" type="button">Vote</button>');

            $('.vote-option').click(function () {
                $('.vote-option').removeClass('selected'); // Remove the selected class from all buttons
                $(this).addClass('selected'); // Add the selected class to the clicked button
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });


    $('.voting-container').on('click', '#vote-button', function () {
        var selectedOption = $('.selected').data('option'); // Get the selected option
        var voteId = $('.selected').data('vote-id'); // Get the vote id

        // Write the JSON string to a file
        $.ajax({
            url: '/project/api/write_vote.php',
            type: 'POST',
            data: {
                selected_option: selectedOption,
                vote_user_id: voteId
            },
            success: function (data) {
                console.log('Vote saved successfully');
                window.location.href = 'votes.php';
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    });
});