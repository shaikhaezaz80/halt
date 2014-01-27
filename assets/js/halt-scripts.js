
(function (window, $) {
    'use strict';

    // Cache document for fast access.
	var document = window.document;

	/**
	 * The faux "class" constructor.
	 *
	 * @since  1.0.
	 *
	 * @return void
	 */
	var Halt = function () {

		/**
		 * Holds reusable elements.
		 *
		 * @since 1.0.
		 *
		 * @type  {{}}
		 */
		var cache = {};

		/**
		 * Initiate all actions for this class.
		 *
		 * @since  1.0.
		 *
		 * @return void
		 */
		function init() {
			// Cache the reusable elements
			cacheElements();

			// Bind events
			bindEvents();
		}

		/**
		 * Caches elements that are used in this scope.
		 *
		 * @since  1.0.
		 *
		 * @return void
		 */
		function cacheElements() {
			cache.$window = $(window);
			cache.$document = $(document);

			cache.$isSingleArticle = ($('body.single-article').length > 0);
		}

		/**
		 * Setup event binding.
		 *
		 * @since  1.0.
		 *
		 * @return void
		 */
		function bindEvents() {
			if (cache.$isSingleArticle) {
				cache.$document.on('ready', articleVote);
			}
		}

		/**
		 * Article upvote/downvote functionality.
		 *
		 * @since  1.0
		 *
		 * @return void
		 */
		function articleVote() {
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
		}

		// Initiate the actions.
		init();
	};

    // Instantiate the "class".
    window.Halt = new Halt();
})(window, jQuery);
