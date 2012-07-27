
jQuery( document ).ready( function() {
	viewModel.url( localStorage.getItem( 'url' ) )

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