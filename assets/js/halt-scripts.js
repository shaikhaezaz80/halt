
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
			$('[data-article-id]').not('.voted').find('a').on('click', function () {
			    var $this = $(this),
			    	clicked = false;

			    var container = $this.closest('.article-vote'),
			    	post_id = container.data('article-id'),
			    	user_id = container.data('user-id'),
			    	type = $this.data('vote-type'),
			    	data = {
			    		action: 'halt_article_vote',
			    		post_id: post_id,
			    		user_id: user_id,
			    		vote_type: type,
			    		nonce: halt_vars.ajax_nonce
			    	};

			    // don't allow the user to love the item more than once
				if( $this.hasClass('voted') ) {
					alert(halt_vars.already_voted_text);
					return false;
				}

				if (halt_vars.logged_in == 'false' && $.cookie('article-vote-' + post_id)) {
					alert(halt_vars.already_voted_text);
					return false;
				}

			    if( !clicked ) {
			    	// prevent quick user clicks
			    	clicked = true;
			    	$.ajax({
			    		type: "POST",
			    		data: data,
			    		dataType: "json",
			    		url: halt_vars.ajaxurl,
			    		success: function( response ) {
			    			if( parseInt( response.code ) == 1 ) {
			    				container.addClass('voted');
			    				var count_wrap = $this.find('.count');
			    				var count = count_wrap.text();
			    				count_wrap.text(parseInt(count) + 1);
			    				if(halt_vars.logged_in == 'false') {
			    					$.cookie('article-vote-' + post_id, 'yes', { expires: 1 });
			    				}
			    			} else {
								alert(halt_vars.error_message);
			    			}
			    			clicked = false;
			    		}
			    	}).fail( function(data){
			    		console.log(data);
			    	});
			    }

			    return false;
			});
		}

		// Initiate the actions.
		init();
	};

    // Instantiate the "class".
    window.Halt = new Halt();
})(window, jQuery);
