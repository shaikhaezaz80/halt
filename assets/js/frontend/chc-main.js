/**
 * Initiates the app.
 */
( function ( CHCApp, $, _, Backbone, window ) {
	var pushState = !!( window.history && window.history.pushState );

	// Do not run the app if browser does not support pushState. While Backbone supports it, non pushState browsers were a mess with WP
	if( pushState ){
		var view;

		if ( '1' === chcData.isTax || '1' === chcData.isFrontPage || '1' === chcData.isArchive ) {
			view = new CHCApp.Views.Core( {
				model : new CHCApp.Models.Core()
			} );
		}

		if ( '1' === chcData.isSingle ) {
			// Instantiate the core view for the single post page
			view = new CHCApp.Views.PostSingle( {
				model : new CHCApp.Models.Post
			} );
		}

		if ( 'object' === typeof( view ) ) {
			// Setup an event aggregator
			CHCApp.eventAggregator = _.extend( {}, Backbone.Events );
			
			// Setup an event for changing the document title
			CHCApp.eventAggregator.on( 'domchange:title', function( title ) {
				$( 'title' ).html( title );
			} );

			// Cache the individual page view
			CHCApp.history[ chcData.pathname ] = {
				pathname : chcData.pathname
			};

			// Instantiate the router
			var router = new CHCApp.Routers.Router( {
				view : view
			} );

			// Initiate history and use pushState
			// Backbone.history.start( {
			// 	pushState : true,
			// 	silent    : true
			// } );
		}
	}

})( CHCApp, jQuery, _, Backbone, window );
