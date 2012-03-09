var viewModel = { 
	timeStacks: ko.observableArray([]),
	url: ko.observable( '' )
}

viewModel.url.subscribe( function() {

	if ( viewModel.url() )
		runGetter();

	localStorage.setItem( 'url', viewModel.url() )

} );

jQuery( document ).ready( function() {
	viewModel.url( localStorage.getItem( 'url' ) )
})


var Operation = function( jsonData ) {
	
	var self = this;

	self.children 	= ko.observableArray([]);
	self.duration 	= ko.observable(0.0);
	self.label		= ko.observable('');
	self.queries	= ko.observableArray([]);
	self.queriesExpanded = ko.observable(false);
	self.memoryUsage= ko.observable(0.0);
	self.type		= ko.observable('HM_Time_Stack_Operation');
	self.vars		= ko.observableArray([]);
	self.open		= ko.observable( false );
	self.json		= jsonData;
	
	self.queryTime = ko.dependentObservable( function() {

		var time = 0;

		ko.utils.arrayForEach( self.queries(), function( query ) {
	    	
			time += query.duration();
			
        });

        return Math.round(time*Math.pow(10,2))/Math.pow(10,2);
	}, self );

	self.importJSON = function( jsonData ) {
	
		// primatives
		self.duration( jsonData.duration );
		self.open( jsonData.is_open );
		self.label( jsonData.label );
		self.memoryUsage( jsonData.memory_usage );
		self.type( jsonData.type );
		
		if ( jsonData.queries ) {
		
			ko.utils.arrayForEach( jsonData.queries, function( json ) {
			
				var q = new Query();
				q.query( json[0] );
				q.duration( json[1] );
				
				self.queries.push( q );		
			} )
		}
		
		if ( typeof( jsonData.children ) == 'object' ) {
		
			ko.utils.arrayForEach( jsonData.children, function( json ) {
				
				var c = new Operation( json );
				
				self.children.push( c );
			} )
		}
	}
	self.importJSON( jsonData );
}

var Query = function() {

	var self = this;
	
	self.query = ko.observable('');
	self.duration = ko.observable(0.0);

}

var getTimeStack = function( callback ) {

	jQuery.getJSON( viewModel.url() + '?action=hm_get_stacks&jsoncallback=?', callback ).error( function(err) { 

		viewModel.url( '' );
	} );
}

var runGetter = function() {
	
	getTimeStack( function( data ) {
		
		data = jQuery.parseJSON( data );
		
		setTimeout( runGetter, 1000 );

		if ( data == null ) {
			return;
		}
		
		data = data.reverse();

		ko.utils.arrayForEach( data, function( jsonStack ) {
			
			var o = new Operation( jsonStack.stack );
			o.url = ko.observable( jsonStack.url );
			o.date = ko.observable( jsonStack.date );
			
			viewModel.timeStacks.unshift( o );
		
		} )
		
		
	} )
}

setTimeout( function() { ko.applyBindings(viewModel); }, 10 );
