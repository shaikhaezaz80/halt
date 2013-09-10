/**
 * Views for the CHCApp
 */
( function ( window, Backbone, $, _, CHCApp ) {
	
	CHCApp.Views.Core = Backbone.View.extend({
		el : function() {
			return document.getElementById( 'container' );
		},

		render: function(){
			console.log("Hello");
		}
	});

	CHCApp.Views.PostSingle = Backbone.View.extend( {
		el : $( '#playground' ),
		$body : $( 'body' ),

		// The "constructor
		initialize : function () {
			// When the model changes, render the content
			this.listenTo( this.model, 'change', this.render );
		},


	} );

} ) ( window, Backbone, jQuery, _, CHCApp );
