function fetchVotes() {
    $.ajax({
        url: '/project/api/fetch_voters_votes.php',
        type: 'get',
        success: function (data) {
            var votes = JSON.parse(data);
            $('.collection-container').empty();
            console.log(votes);
            $.each(votes, function (index, vote) {
                // Add a dropdown list for selecting a voter
                var voterSelection = '<select class="voter-selection">';
                $.each(vote.voters, function (index, voter) {
                    voterSelection += '<option value="' + voter.user_email + '">' + voter.user_email + '</option>';
                });
                voterSelection += '</select>';

                $('.collection-container').append(
                    '<div class="uno-vote-list-container" style="display: flex;justify-content: space-between;">' +
                    '<div style="display: flex; justify-content: space-between; align-items: center;">' +
                    '<div style="margin-right: 10px;">Name: ' + vote.name + '</div>' +
                    '<div style="margin-right: 10px;"> ' + vote.description + '</div>' +
                    '<div>Votes: ' + vote.voted_voters + '/' + vote.total_voters + '</div>' +
                    '</div>' +
                    '<div style="display: flex; align-items: center;">' +
                    '<button class="square-button vote-button" id="' + vote.vote_id + '">Vote</button>' +
                    '<button class="square-button give-button" id="' + vote.vote_id + '" style="margin-left: 10px;">Give away</button>' +
                    voterSelection +  // Add the voter selection dropdown to the HTML
                    '</div>' +
                    '</div>'
                );

                $.ajax({
                    url: '/project/api/has_voted.php',
                    type: 'POST',
                    data: { vote_user_id: vote.vote_id },
                    success: function (data) {
                        var hasVoted = JSON.parse(data);
                        if (hasVoted) {
                            console.log('User has already voted');
                            $('#' + vote.vote_id).addClass('voted');
                            $('#' + vote.vote_id).prop('disabled', true); // Disable the 'vote' button
                        } else {
                            console.log('User HAS NOT already voted');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
            });

            $('.vote-button').on('click', function () {
                var voteId = $(this).attr('id');
                window.location.href = 'voting.php?vote_id=' + voteId;

            });

            $('.give-button').on('click', function () {
                var voteId = $(this).attr('id');
                var selectedVoter = $(this).siblings('.voter-selection').val();

                $.ajax({
                    url: '/project/api/give_vote.php',
                    type: 'POST',
                    data: { vote_id: voteId, given_voter_email: selectedVoter },
                    success: function (data) {
                        // Handle the success case
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
            });

        },
        error: function () {
            alert('An error occurred while fetching the votes.');
        }
    });
}

$(document).ready(function () {
    fetchVotes();

    $("#create-vote").on('click', function () {
        window.location.href = 'create_vote.php';
    });
    $("#show-groups").on('click', function () {
        window.location.href = 'group_panel.php';
    });
});