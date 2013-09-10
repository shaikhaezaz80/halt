/**
 * Collections for the CHCApp
 */

( function ( window, Backbone, $, _, CHCApp ) {
	
	CHCApp.Collections.PostArchive = Backbone.Collection.extend({
		initialize: function( model ) {
			// Set the model to an instance var
			this.set( 'model', model );
		},
		
		url: chcData.get_recent_posts,

		parse: function( response ) {
			// Set the global data that is not post specific
			CHCApp.queriedObject = response.global.queriedObject;
			CHCApp.enqueues      = response.global.enqueues;
			CHCApp.nextButton    = response.global.nextButton;
			CHCApp.bodyClasses   = response.global.bodyClasses;
			CHCApp.isHome        = response.global.isHome;
			CHCApp.isArchive     = response.global.isArchive;
			CHCApp.isTax         = response.global.isTax;
			CHCApp.titleAttr     = response.global.titleAttr;
			CHCApp.archiveTitle  = response.global.archiveTitle;

			// Return the array of posts for the Collection to iterate through
			return response.posts;
		}
	});


} ) ( window, Backbone, jQuery, _, CHCApp );
