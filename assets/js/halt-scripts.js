(function ($) {
    "use strict";
    $(document).ready(function () {
        
        // Article Upvote/Downvote
        $('[data-article-id]').find('a').on('click', function (e) {
            e.preventDefault();
            var container   = $(this).closest('.article-vote'),
                postid      = parseInt(container.data('article-id')),
                type        = $(this).data('vote-type'),
                that        = $(this),
                data        = {
                    action: 'halt_article_vote',
                    nonce: halt_vars.ajax_nonce,
                    vote_type: type,
                    postid: postid
                };

            if (!container.hasClass('voted')) {
                $.post(halt_vars.ajaxurl, data, function (response) {
                    that.find('.count').text(response);
                    container.addClass('voted');
                });
            }
        });

    });

}) (jQuery);