<ul class="nav nav-pills nav-stacked" style="margin-bottom: 0" data-bind="foreach: children">

	<!-- ko if: type == 'HM_Time_Stack_Operation' -->
		<li data-bind="css: { active: RequestsController.selectedOperation() == $data }">
			<a href="#" data-bind="click: function() { RequestsController.selectedOperation( $data ); ! $data.open() && $data.children().length > 0 ? $data.open(true) : $data.open(false); }">

				<span style="width: 100px; color: #999" class="">+ <i data-bind="text: time"></i>ms</span>

				<strong data-bind="text: label"></strong>

				<!-- ko if: children().length > 0 -->
					<strong>&crarr;</strong>
				<!-- /ko -->

				<span class="right-text">
					<span data-bind="text: duration"></span>ms
				</span>
			</a>

			<?php 
			global $include_time;
			$include_time++;

			if ( $include_time < 5 ) : ?>
			<!-- ko if: open -->
			<div class="" style="background: rgba( 0,0,0,0.03 ); margin-top: -3px; box-shadow: inset 0 0 5px 0px rgba(0, 0, 0, .2)">
				<?php include( __FILE__ ); ?>
			</div>
			<?php endif; ?>
			<!-- /ko -->
		</li>
	<!-- /ko -->

	<!-- ko if: type == 'HM_Time_Stack_Event' -->
		<li class="event">
			<span style="width: 100px; color: #999;" class="">+ <i data-bind="text: time"></i>ms</span>
			&rarr; <span data-bind="text: label"></span>

		</li>
	<!-- /ko -->
</ul>