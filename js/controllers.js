var viewModel = { 
	timeStacks: ko.observableArray([]),
	url: ko.observable( '' ),
	selectedUser: ko.observable( '' )
}

var lastAjaxRequestDidFinish = false;
var loadedTime = new Date().getTime();

var RequestsController = new function() {

	var self = this;

	self.requests = ko.observableArray([]);
	self.selectedRequest = ko.observable();
	self.selectedOperation = ko.observable();

	//self.requests.push( new Request( data[0 ]) );
	self.selectedRequest.subscribe( function() {
		self.selectedOperation( self.selectedRequest() );
	} );

	self.requestsChart = ko.dependentObservable( function() {

		var data = [];

		ko.utils.arrayForEach( self.requests(), function( request ) {
			
			data.push( { name: 'awd', value: request.duration } );
		});

		if ( data.length >= 40 ) {
			data = data.slice( 0, 39 );
		} else {
			while( data.length < 40 )
				data.push( { name: 'awd', value: 0 } );
		}
		data.reverse();
		
		return data;
	} );


	self.averageResponseTime = ko.dependentObservable( function() {

		var total_time = 0;
		var total_count = 0;

		ko.utils.arrayForEach( self.requests(), function( request ) {
			
			total_time += request.duration;
			total_count++;
		});

		return Math.round( total_time / total_count );
	}, self );

	self.averageDBTime = ko.dependentObservable( function() {

		var total_time = 0;
		var total_count = 0;

		ko.utils.arrayForEach( self.requests(), function( request ) {
			
			total_time += request.queryTime();
			total_count++;
		});

		return Math.round( total_time / total_count );
	}, self );

	self.averageDBCount = ko.dependentObservable( function() {

		var total_time = 0;
		var total_count = 0;

		ko.utils.arrayForEach( self.requests(), function( request ) {
			
			total_time += request.queries().length;
			total_count++;
		});

		return Math.round( total_time / total_count );
	}, self );

	self.requestRate = ko.dependentObservable( function() {
		var timeTaken  = ( new Date().getTime() - loadedTime ) / 1000;

		return Math.round( self.requests().length / timeTaken ) * 60;
	}, self );

	self.start = function() {

		if ( ! viewModel.url() ) {
			DetailsController.show();
			return;
		}
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

var DetailsController = new function() {

	this.url = ko.observable('');
	var self = this;

	this.show = function() {
		jQuery( '#details-modal' ).modal( { backdrop: true, show: true } );
	}

	this.setDetails = function() {
		viewModel.url( self.url() );
		debugger;
		jQuery( '#details-modal' ).modal('hide');
	}

}
