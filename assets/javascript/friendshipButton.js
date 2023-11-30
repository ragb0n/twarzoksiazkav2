$(document).ready(function () {
    $('[id="remove-friend-button"].friendship-button').on('click', function () {
        var friendshipId = $(this).data('friendshipId');
        var userId = $(this).data('userId');

        $.ajax({
            url: '/friendship/${friendshipId}/remove',
            type: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            data: {
                friendship: friendshipId
            },
            success: function (data) {
                refreshButtonUI(0, userId);
                console.log(data.response);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        })
    })

    $('[id^="add-friend-button"].friendship-button').on('click', function () {
        var targetUserId = $(this).data('userId');
        var userId = $(this).data('userId');
 
        $.ajax({
            url: '/friendship/${friendshipId}/add',
            type: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            data: {
                target: targetUserId
            },
            success: function () {
                refreshButtonUI(1, userId);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        })
    })

    function refreshButtonUI(currentStatus, userId){
        // Znaczenie poszczególnych wartości currentStatus:
        // 0 - użytkownik usunięty ze znajomych
        // 1 - wysłano zaproszenie
        // 2 - anulowano wysłane zaproszenie
        // 3 - zaakceptowano zaproszenie
        // 4 - odrzucono zaproszenie

        if(currentStatus == 0){
            $('#friend-deleted-message-'+userId).show();
            $('.friendship-buttons-'+userId).hide();
        }else if(currentStatus == 1){
            $('#invitation-sent-message-'+userId+'.friendship-button-message').show();
            $('#add-friend-button-'+userId+'.friendship-button').hide();
        }else if(currentStatus == 2){
            
        }else if(currentStatus == 3){

        }else if(currentStatus == 4){

        }
    }
})