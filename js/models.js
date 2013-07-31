var Request = function( jsonData ) {

	var self = this;
	self.__proto__ = new Operation( jsonData.stack );

	self.url = jsonData.url;
	self.date = jsonData.date;
	self.fullurl = jsonData.full_url;
	self.requestType = jsonData.request_type;
	self.getVars = jsonData.get_vars;

	
	if ( typeof( jsonData.user ) != 'undefined' )
		self.user( jsonData.user )

	var queryTimes = []

	ko.utils.arrayForEach( self.queries(), function( query ) {
		queryTimes.push( query.duration );
	} )

	var data = ko.toJS( self );
}

var Operation = function( jsonData ) {
	
	var self = this;

	console.log( jsonData );
	self.children 	= ko.observableArray([]);
	self.duration 	= 0.0
	self.label		= ''
	self.queries	= ko.observableArray([]);
	self.queriesExpanded = ko.observable(false);
	self.memoryUsage= 0.0
	self.type		= 'HM_Time_Stack_Operation';
	self.vars		= ko.observableArray([]);
	self.open		= ko.observable( false );
	self.json		= jsonData;
	self.user 		= ko.observable();
	self.isExpanded = ko.observable( false );

	self.queryTime = ko.dependentObservable( function() {

		var time = 0;

		ko.utils.arrayForEach( self.queries(), function( query ) {
			
			time += query.duration;
			
		});

		return Math.round(time*Math.pow(10,2))/Math.pow(10,2);
	}, self );

	self.toggleExpanded = function() {
		self.isExpanded() ? self.isExpanded( false ) : self.isExpanded( true );
	}

	self.toggleQueriesExpanded = function() {
		self.queriesExpanded() ? self.queriesExpanded( false ) : self.queriesExpanded( true );
	}

	self.importJSON = function( jsonData ) {
	
		// primatives
		if ( ! jsonData ) {

			console.log('not valid');
			return;
			
		}
		self.duration = Math.round((jsonData.duration * 1000)*Math.pow(10,2))/Math.pow(10,2);
		self.open( jsonData.is_open );
		self.label = jsonData.label;

		self.memoryUsage = jsonData.memory_usage;
		self.type = jsonData.type;

		if ( jsonData.queries ) {
		
			ko.utils.arrayForEach( jsonData.queries, function( json ) {
			
				var q = new Query();
				q.query = json[0];
				q.duration = Math.round((json[1] * 1000)*Math.pow(10,2))/Math.pow(10,2);
				
				self.queries.push( q );	
			} )
		}

		if ( typeof( jsonData.time ) != 'undefined' ) {
			self.time = Math.round( jsonData.time * 1000 );
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

	var self = this
	
	self.query = ''
	self.duration = 0.0

}