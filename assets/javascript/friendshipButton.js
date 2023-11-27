$(document).ready(function () {
    $('#remove-friend-button.friendship-button').on('click', function () {
        const friendshipId = $(this).data('friendshipId');
        
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
                //refreshButtonUI(1);
                console.log(data.response);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        })
    })

    $('#add-friend-button.friendship-button').on('click', function () {
        const targetUserId = $(this).data('userId');
        
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
                refreshButtonUI(1);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        })
    })

    function refreshButtonUI(currentStatus, button){
        // Znaczenie poszczególnych wartości currentStatus:
        // 0 - użytkownik usunięty ze znajomych
        // 1 - wysłano zaproszenie
        // 2 - anulowano wysłane zaproszenie
        // 3 - zaakceptowano zaproszenie
        // 4 - odrzucono zaproszenie

        if(currentStatus == 0){

        }else if(currentStatus == 1){
            $('#invitation-sent.friendship-button-message').show();
            button.hide();
        }else if(currentStatus == 2){
            
        }else if(currentStatus == 3){

        }else if(currentStatus == 4){

        }
    }
})