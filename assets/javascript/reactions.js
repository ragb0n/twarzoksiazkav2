// public/js/reactions.js

$(document).ready(function () {
    $('.reaction-btn').on('click', function () { //przy kliknięciu bloku z klasą reaction-btn 
        const postId = $(this).data('postId'); //przypisz do zmiennych dane z parametrów data-post-id oraz data-reacion-type
        const reactionType = $(this).data('reactionType');
        // wykonanie AJAX
        $.ajax({ 
            url: `/post/${postId}/react`, //pod ten route
            type: 'POST', //metoda POST
            headers: { //headers
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
            }, //jakie dane mają zostać przekazane w żądaniu
            data: { type: reactionType },
            success: function (data) {
                // w przypadku sukcesu - wykonaj updateReactionUI
                updateReactionUI(postId, data.reactions);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });

    function updateReactionUI(postId, reactionCounts) {
        //zaktiializuj licznik reakcji
        $('.post-' + postId + ' .reaction-count').each(function () {
            const reactionType = $(this).data('reactionType');
            const count = reactionCounts[reactionType] || 0;
            $(this).text(count);
        });
    }
});
