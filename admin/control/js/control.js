function fetchVotes() {
    $.ajax({
        url: '/project/api/fetch_votes.php',
        type: 'get',
        success: function (data) {
            var votes = JSON.parse(data);
            $('.collection-container').empty();
            console.log(votes);
            $.each(votes, function (index, vote) {
                $('.collection-container').append(
                    '<div class="uno-vote-list-container" style="display: flex;justify-content: space-between;">' +
                    '<div style="display: flex; justify-content: space-between; align-items: center;">' +
                    '<div style="margin-right: 10px;">Name: ' + vote.name + '</div>' +
                    '<div style="margin-right: 10px;"> ' + vote.description + '</div>' +
                    '<div>Votes: ' + vote.voted_voters + '/' + vote.total_voters + '</div>' +
                    '</div>' +
                    '<div style="display: flex; align-items: center;">' +
                    // '<button class="square-button edit-button" id="' + vote.vote_id + '">Edit</button>' +
                    '<button class="square-button delete-button"" id="' + vote.vote_id + '" style="margin-left: 10px;">Delete</button>' +
                    '</div>' +
                    '</div>'
                );
            });

            $('.edit-button').on('click', function () {
                var id = $(this).data('id');

            });

            $('.delete-button').on('click', function (e) {
                console.log(e.target.id);
                var id = e.target.id;
                $.ajax({
                    url: '/project/api/delete_vote.php',
                    method: 'POST',
                    data: {
                        vote_id: id
                    },
                    success: function (response) {
                        var parsedResponse = JSON.parse(response);
                        console.log(parsedResponse.success);
                        if (parsedResponse.success) {
                            // alert('Vote deleted successfully');
                            fetchVotes(); // Refresh the votes
                        } else {
                            alert('An error occurred while deleting the vote');
                        }
                    },
                    error: function () {
                        alert('An error occurred while sending the request');
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