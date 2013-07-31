<!DOCTYPE html>
<html>
	<head>

	<title>Time Stack</title>

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery.tmpl.js"></script>
		<script type="text/javascript" src="js/knockout.js"></script>
		<script type="text/javascript" src="js/libs.js"></script>
		<script type="text/javascript" src="js/spin.js"></script>
		<script type="text/javascript" src="js/models.js"></script>
		<script type="text/javascript" src="js/controllers.js"></script>
		<script type="text/javascript" src="js/js.js"></script>
				
		<link rel="stylesheet" href="css/bootstrap.css" />

	</head>

	<body style="padding: 10px; padding-top: 50px">

		<div class="" style="position: absolute; overflow: auto; background: #4280C9; border-bottom: 0px solid #384E6D; top: 0; left: 0px; right: 0; height:60px; width: 100%">
			<div class="pull-left" style="margin-right: 30px; width: 320px">
				<h4 class="brand" style="display: inline-block; margin: -0px 0 10px 0; padding: 0 0 0 10px; color: #fff; overflow: hidden; white-space: pre; text-overflow: ellipsis;" href="#">WordPress TimeStack</h4>
				
				<form class="navbar-search pull-left" data-bind="submit: RequestsController.start" style="padding: 0 0 0 10px; margin: -5px 0 0 0">
					<input style="border-radius: 0; opacity: 0.3; border: none; color: black" type="url" class="span4" data-bind="value: url" placeholder="Enter URL">
				</form>
			</div>
			<div class="pull-right" style="color: #fff; opacity: .7; margin-right: 30px;">
				<strong style="padding: 5px 0 5px 0; display: inline-block; opacity: .5;">AVG response time</strong><br />
				<strong data-bind="text: RequestsController.averageResponseTime" style="font-size: 30px">0</strong> ms
			</div>

			<div class="pull-right" style="color: #fff; opacity: .7; margin-right: 30px;">
				<strong style="padding: 5px 0 5px 0; display: inline-block; opacity: .5;">Request rate</strong><br />
				<strong data-bind="text: RequestsController.requestRate" style="font-size: 30px">42</strong> /min
			</div>

			<div class="pull-right" style="color: #fff; opacity: .7; margin-right: 30px;">
				<strong style="padding: 5px 0 5px 0; display: inline-block; opacity: .5;">AVG DB queries</strong><br />
				<strong data-bind="text: RequestsController.averageDBCount" style="font-size: 30px">42</strong> /request
			</div>

			<div class="pull-right" style="color: #fff; opacity: .7; margin-right: 30px;">
				<strong style="padding: 5px 0 5px 0; display: inline-block; opacity: .5;">AVG DB time</strong><br />
				<strong data-bind="text: RequestsController.averageDBTime" style="font-size: 30px">42</strong> ms
			</div>

			<div class="pull-right" style="opacity: .7">
				<div style="width: 490px; margin-top: 5px; height: 60px;" data-bind="kendoChart: { data: RequestsController.requestsChart, transitions: false, seriesDefaults: { gap: 0.15, border: { width: 0 } }, seriesColors: ['#fff'], xAxis: { line: { width: 0 } }, valueAxis: { line: { width: 0 }, labels: { visible: false }, majorGridLines: { visible: false } }, chartArea: { background: 'transparent' }, categoryAxis: { line: { visible: false }, majorGridLines: { visible: false }  }, series: [{ name: '', field: 'value' }] }"> </div>
			</div>

			<ul class="nav pull-right">
				<li><a href="#" data-bind="click: RequestsController.clearRequests"><strong>Clear</strong></a></li>
			</ul>
		</div>

		<div class="" style="position: absolute; overflow: auto; background: #f3f3f3; border-right: 1px solid #d6d6d6; top: 60px; left: 0px; bottom: 0; width: 15%">
			<h5 style="padding: 0 0 0 10px; opacity: .6">Requests</h5>

			<!-- ko with: RequestsController -->
			<ul class="nav nav-pills nav-stacked" data-bind="foreach: requests">
				<li data-bind="css: { active: RequestsController.selectedRequest() == $data }">
					<a style="border-radius: 0;" href="#" data-bind="click: function() {  RequestsController.selectedRequest( $data ) }">
						<span data-bind="text: requestType"></span>
						<span data-bind="text: url" style="white-space: pre; text-overflow: ellipsis; overflow: hidden; display: inline-block; "></span><br />
						<span style="color: #666; opacity: .6; font-size: 12px;">
							<strong data-bind="text: duration"></strong> ms
							<strong data-bind="text: queries().length"></strong> queries
						</span>
					</a>
				</li>
			</ul>
			<!-- /ko -->
		</div>
			<div class="" style="position: absolute; overflow: auto; top: 60px; right: 25%; bottom: 0; width: 60%">
				
				<div style="padding: 10px">

					<!-- ko if: RequestsController.selectedRequest -->
						<h4 style="padding: 0 0 0 0; margin: 0 0 10px; color: #999"><a style="color: #999" data-bind="text: RequestsController.selectedRequest().fullurl"></a></h4>
						
						<div class="row-fluid">
							<div class="span12" style="padding: 10px 0 0; overflow: hidden; font-size: .95em">

								<!-- ko with: RequestsController.selectedRequest -->
								<?php include( 'include-stack.php' ) ?>
								<!-- /ko -->
							</div>
						</div>
					<!-- /ko -->
				</div>
			</div>

			<div class="" style="position: absolute; overflow: auto; top: 60px; right: 0px; bottom: 0; width: 25%">
				<!-- ko if: RequestsController.selectedOperation -->
					<!-- ko with: RequestsController.selectedOperation -->
					<div class="span4">
						<h4 data-bind="text: label" style="margin: 25px 0 15px; white-space: pre; text-overflow: ellipsis; overflow: hidden; width: 100%; display: inline-block;"></h4>

						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Run Time</th>
									<th>Memory Usage</th>
									<th>MySQL</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><span class="" data-bind="text: duration"></span> ms</td>
									<td><span class="badge badge-success" data-bind="text: memoryUsage"></span> MB</td>
									<td><span class="badge badge-success" data-bind="text: queryTime()"></span> ms (<span data-bind="text: queries().length"></span> Queries)</td>
								</tr>
							</tbody>
						</table>

						<!-- ko if: queries().length -->
							<h5>MySQL queries in this operation</h5>
							<!-- ko foreach: queries -->
								<pre data-bind="text: query"></pre>
							<!-- /ko -->
						<!-- /ko -->
						

					</div>
					<!-- /ko -->
				<!-- /ko -->
			</div>

		<!-- Modal -->
		<div id="details-modal" data-bind="submit: DetailsController.setDetails" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <h3 id="myModalLabel">WordPress TimeStack</h3>
		  </div>
		    <form class="form-horizontal">
		  <div class="modal-body">
		    <p>Enter your WordPress install's address below. You must be running the <a href="https://github.com/joehoyle/Time-Stack">TimeStack</a> plugin and have APC or Memcached Object Caching enabled.</p>
		    <p></p>
		  
			  <div class="control-group">
			    <label class="control-label" for="inputEmail">URL</label>
			    <div class="controls">
			      <input type="text" data-bind="value: DetailsController.url" required id="inputEmail" placeholder="www.sky.com">
			    </div>
			  </div>
			
		  </div>
		  <div class="modal-footer">
		    <button class="btn btn-primary">Let's Go!</button>
		  </div>
		  </form>
		</div>

		<style>
			.nav-pills li.event { padding: 8px 10px; color: #666; }
			.nav-pills > li .right-text { display: inline-block; width: 100px; float: right; color: #999; text-align: right; }
		</style>
	</body>

</html>