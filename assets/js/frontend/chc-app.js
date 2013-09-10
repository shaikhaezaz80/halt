(function ( window, $, _, Backbone ) {
	// Cache document for fast access.
	var document = window.document;

	var CHCApp = function () {

		var _Collections = {},
			_Models = {},
			_Routers = {},
			_Views = {},
			_history = {};
		
		/**
		 * Add new scripts and styles to the page.
		 *
		 * @since 1.0.
		 *
		 * @param type        Script or style.
		 * @param needed      Array of enqueues needed for the view.
		 * @param existing    Array of already existing enqueues.
		 * @private
		 */
		var _renderEnqueues = function ( type, needed, existing ) {
			// Find out what is still needed comparing loaded scripts to the needed scripts
			var handles_to_add = _.difference( _.keys( needed ), existing );

			// Based on the needed handles, build an array of script data to add to the page
			var new_enqueues = _.filter( needed, function ( data ) {
				return _.contains( handles_to_add, data.handle );
			} );

			// Render the enqueues
			if ( 'scripts' === type ) {
				_renderScripts( new_enqueues );
			} else {
				_renderStyles( new_enqueues );
			}
		};

		/**
		 * Add scripts to the page.
		 *
		 * @since 1.0.
		 *
		 * @param scripts    The script objects to add to the page
		 * @private
		 */
		var _renderScripts = function ( scripts ) {
			_.each( scripts, function( list, iterator ) {
				// Add script handle to list of those already parsed
				collectionsSPAData.scripts.push( list.handle );

				// Determine where to load the script
				var where = ( list.footer ) ? 'body' : 'head';

				/**
				 * Loading these scripts in the head can break the video/audio player in some situations. WordPress
				 * has them set to load in the head; however, they are always enqueued during a shortcode callback. As
				 * such, they are loaded in the footer. I am mimicking that here so that things function properly.
				 */
				if ( _.contains( [ 'mediaelement', 'wp-mediaelement' ] , list.handle ) ) {
					where = 'body';
				}

				// Output extra data, if present
				if ( list.extra_data ) {
					var data        = document.createElement('script'),
						dataContent = document.createTextNode( "//<![CDATA[ \n" + list.extra_data + "\n//]]>" );

					data.type = 'text/javascript';
					data.appendChild( dataContent );

					document.getElementsByTagName( where )[0].appendChild( data );
				}

				// Load the script and trigger a callback function when the script is fully loaded and executed
				_loadAndExecute( list.src, where, list.handle, function() {
					$( window.document ).trigger( 'post-load' );
				} );
			} );
		};

		/**
		 * Add styles to the page.
		 *
		 * @since 1.0.
		 *
		 * @param styles    The style objects to add to the page
		 * @private
		 */
		var _renderStyles = function ( styles ) {
			_.each( styles, function ( list, iterator ) {
				// Add stylesheet handle to list of those already parsed
				collectionsSPAData.styles.push( list.handle );

				// Build link tag
				var style  = document.createElement( 'link' );
				style.rel  = 'stylesheet';
				style.href = list.src;
				style.id   = list.handle + '-css';

				// Destroy link tag if a conditional statement is present and either the browser isn't IE, or the conditional doesn't evaluate true
				if ( list.conditional && ( ! isIE || ! eval( list.conditional.replace( /%ver/g, IEVersion ) ) ) ) {
					style = false;
				}

				// Append link tag if necessary
				if ( style ) {
					document.getElementsByTagName( 'head' )[0].appendChild( style );
				}
			} );
		};		

		// props hagenburger (https://gist.github.com/hagenburger/500716)
		/**
		 * Load a script and execute a function once it is loaded.
		 *
		 * @since 1.0.
		 *
		 * @param src         The source for the script.
		 * @param where       Head or footer.
		 * @param handle      The script's ID.
		 * @param callback    The function to execute.
		 * @private
		 */
		var _loadAndExecute = function( src, where, handle, callback ) {
			// Create the script element
			var script = document.createElement( 'script' ),
				loaded;

			// Append the necessary source
			script.setAttribute( 'src', src );

			// If there is a callback, run it when the script is loaded
			if ( callback ) {
				script.onreadystatechange = script.onload = function () {
					if ( ! loaded ) {
						callback();
					}
					loaded = true;
				};
			}

			// Append the script
			document.getElementsByTagName( where )[0].appendChild( script );
		};

		/**
		 * Trigger the post load event and run the media element player script if needed.
		 *
		 * @since 1.0
		 *
		 * @private
		 */
		var _postLoadJS = function() {
			$( window.document ).trigger( 'post-load' );

			// Make sure "mejs" is set first before execution
			if ( 'undefined' !== typeof( mejs ) ) {
				$('.wp-audio-shortcode, .wp-video-shortcode').mediaelementplayer();
			}
		}

		// Return accessible private vars
		return {
			Collections    : _Collections,
			Models         : _Models,
			Routers        : _Routers,
			Views          : _Views,
			history        : _history,
			renderEnqueues : _renderEnqueues,
			renderScripts  : _renderScripts,
			renderStyles   : _renderStyles,
			loadAndExecute : _loadAndExecute,
			postLoadJS     : _postLoadJS
		}
	}

	// Instantiate the "class".
	window.CHCApp = new CHCApp();
})( window, jQuery, _, Backbone );
