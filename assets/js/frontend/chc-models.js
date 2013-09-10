/**
 * Models for the CHCApp
 */

( function ( window, Backbone, $, _, CHCApp ) {
	
	CHCApp.Models.Knowledgebases = Backbone.Model.extend({
		url: chcData.get_recent_posts
	});

	CHCApp.Models.Core = Backbone.Model.extend({
		initialize : function() {
			
		}
	});

	CHCApp.Models.Post = Backbone.Model.extend({
		// Alter the returned JSON
		parse : function( response ) {
			// Reformat the returned JSON
			var data           = response.posts[0];
			data.enqueues      = response.global.enqueues;
			data.queriedObject = response.global.queriedObject;
			data.titleAttr     = response.global.titleAttr;
			return data;
		},

		url: function() {
			return chcData.get_post + "id=" + this.id;
		}
	});



} ) ( window, Backbone, jQuery, _, CHCApp );
