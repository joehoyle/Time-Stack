<!DOCTYPE html>
<html>
	<head>

	<title>Time Stack</title>

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery.tmpl.js"></script>
		<script type="text/javascript" src="js/knockout.js"></script>
		<script type="text/javascript" src="js/spin.js"></script>
		<script type="text/javascript" src="js/models.js"></script>
		<script type="text/javascript" src="js/controllers.js"></script>
		<script type="text/javascript" src="js/js.js"></script>
				
		<link rel="stylesheet" href="css/bootstrap.css" />

	</head>

	<body style="padding: 10px; padding-top: 50px">

		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="" style="padding: 0 15px 0 15px">
					<a class="brand" style="display: inline-block; width: 14%" href="#">WordPress TimeStack</a>
					
					<form class="navbar-search pull-left" data-bind="submit: RequestsController.start">
						<input type="url" class="search-query span4" data-bind="value: url" placeholder="Enter URL">
					</form>

					<ul class="nav pull-right">
						<li><a href="#" data-bind="click: RequestsController.clearRequests"><strong>Clear</strong></a></li>
					</ul>

				</div>
			</div>


		</div>
		<div class="row-fluid">

			<div class="span2 js-height-to-floor" style="position: fixed; overflow: auto; margin: -10px; background: #f3f3f3; border-right: 1px solid #d6d6d6; min-height: 100%; ">
				<h4 style="padding: 10px 0 0 10px">Pages</h4>

				<!-- ko with: RequestsController -->
				<ul class="nav nav-pills nav-stacked" data-bind="foreach: requests">
					<li data-bind="css: { active: RequestsController.selectedRequest() == $data }">
						<a href="#" data-bind="click: function() {  RequestsController.selectedRequest( $data ) }">
							<span data-bind="text: url" style="white-space: pre; text-overflow: ellipsis; overflow: hidden; display: inline-block; width: 100%;"></span><br />
							<span style="color: #666">
								<strong data-bind="text: duration"></strong> ms
								<strong data-bind="text: queries().length"></strong> queries
							</span>
						</a>
					</li>
				</ul>
				<!-- /ko -->
			</div>
			<div class="span10" style="margin-left: 16%">
				
				<!-- ko if: RequestsController.selectedRequest -->
					<h3 style="padding: 15px 0; color: #999"><a style="color: #999" data-bind="text: RequestsController.selectedRequest().url"></a></h3>
					
					<div class="row-fluid">
						<div class="span8" style="border: 1px solid #f3f3f3; padding: 10px 0 0">

							<!-- ko with: RequestsController.selectedRequest -->
							<?php include( 'include-stack.php' ) ?>
							<!-- /ko -->
						</div>

						<!-- ko if: RequestsController.selectedOperation -->
							<!-- ko with: RequestsController.selectedOperation -->
							<div class="span4">
								<h4 data-bind="text: label" style="margin: 0 0 15px; white-space: pre; text-overflow: ellipsis; overflow: hidden; width: 100%; display: inline-block;"></h4>

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
				<!-- /ko -->

			</div>
		</div>
		
		<style>
			.nav-pills li.event { padding: 8px 10px; color: #666; }
			.nav-pills > li .right-text { display: inline-block; width: 100px; float: right; color: #999; text-align: right; }
		</style>
	</body>

</html>