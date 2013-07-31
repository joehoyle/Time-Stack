
jQuery( document ).ready( function() {
	viewModel.url( localStorage.getItem( 'url' ) )

	if ( localStorage.getItem( 'url' ) )	
		RequestsController.start();
	
	jQuery( window ).resize( function() {
		jQuery( '.js-height-to-floor' ).each( function() {
			ExpandElementToFloor( jQuery( this ) );
		} );
	})

	jQuery( window ).resize()
})

var runGetter = function() {
	
}

setTimeout( function() { ko.applyBindings(viewModel); }, 10 );

function ExpandElementToFloor( element ) {
	element.height( jQuery( window ).height() - element.offset().top );
}


var getTimeStack = function( callback ) {

	lastAjaxRequestDidFinish = false;

	try {
		var req = jQuery.getJSON( viewModel.url() + '?action=hm_get_stacks&jsoncallback=?', callback );
	} catch( e ) {

		setTimeout( function() {
			getTimeStack( callback );
		}, 1000 );	
	}

	req.error( function(err) { 

		setTimeout( function() {
			getTimeStack( callback );
		}, 1000 );
	} );

	setTimeout( function() {
		if ( lastAjaxRequestDidFinish == false ) {
			req.abort();
		}
	}, 5000 );

}