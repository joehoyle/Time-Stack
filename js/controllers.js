var viewModel = { 
	timeStacks: ko.observableArray([]),
	url: ko.observable( '' ),
	selectedUser: ko.observable( '' )
}

var lastAjaxRequestDidFinish = false;


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

var RequestsController = new function() {

	var self = this;

	self.requests = ko.observableArray([]);
	self.selectedRequest = ko.observable();
	self.selectedOperation = ko.observable();

	//self.requests.push( new Request( data[0 ]) );
	self.selectedRequest.subscribe( function() {
		self.selectedOperation( self.selectedRequest() );
	} );

	self.start = function() {
		localStorage.setItem( 'url', viewModel.url() );
		getTimeStack( function( data ) {
			lastAjaxRequestDidFinish = true;
			setTimeout( self.start, 1000 );

			if ( data == null || data == false ) {
				return;
			}
			
			data = data.reverse();

			ko.utils.arrayForEach( data, function( jsonStack ) {
				
				self.requests.unshift( new Request( jsonStack ) );

			
			} )
			
			
		} )
	}

	self.clearRequests = function() {

		self.requests( [] );
		self.selectedRequest( null )
		self.selectedOperation( null )
	}

}
