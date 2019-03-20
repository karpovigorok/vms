@extends('admin.master')

@section('css')
	<style type="text/css">
	.has-switch .switch-on label {
			background-color: #FFF;
			color: #000;
			}
	.make-switch{
		z-index:2;
	}
	</style>
@stop


@section('content')




<div id="admin-container">
<!-- This is where -->
	
	<div class="admin-section-title">
		<h3><i class="entypo-credit-card"></i> <?php echo _i("Payment Settings");?></h3>
	</div>
	<div class="clear"></div>
	<form method="POST" action="{{ URL::to('admin/payment_settings') }}" accept-charset="UTF-8" enctype="multipart/form-data">
		
		<div class="row">
			
			<div class="col-md-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
					<div class="panel-title"><?php echo _i("Live Mode Or Test Mode");?></div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body" style="display: block;"> 
						<p><?php echo _i("Payment Settings are in Live Mode");?>:</p>
	
						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($payment_settings->live_mode) || (isset($payment_settings->live_mode) && $payment_settings->live_mode))checked="checked" value="1"@else value="0"@endif name="live_mode" id="live_mode" />
				            </div>
						</div>
						
					</div> 
				</div>
                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
					<div class="panel-title"><?php echo _i("Stripe Subscription Plans");?></div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body" style="display: block;">
						<?php
                        if($stripe_subscription_plans && sizeof($stripe_subscription_plans->data)):
                            foreach($stripe_subscription_plans->data as $stripe_subscription_plan):
                                echo '<p>' . $stripe_subscription_plan->nickname . ": " . $stripe_subscription_plan->amount/100 . ' ' . $stripe_subscription_plan->currency . ' per ' . $stripe_subscription_plan->interval_count . ' ' . $stripe_subscription_plan->interval . '</p>';
                            endforeach;
                            ?>
                        <?php else:
                        echo _i('You should have at least one subscription plan. Please configure your subscription plans <a target="_blank" href="%s">here</a>.', 'https://dashboard.stripe.com/test/subscriptions/products');
                        endif;?>
					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><?php echo _i("Stripe Payment API Keys");?> (<a href="https://dashboard.stripe.com/account/apikeys" target="_blank">https://stripe.com/docs/tutorials/dashboard</a>)</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body" style="display: block;"> 
						<p><?php echo _i("Test Secret Key");?>:</p>
						<input type="text" class="form-control" name="test_secret_key" id="test_secret_key" placeholder="<?php echo _i("Test Secret Key");?>" value="@if(!empty($payment_settings->test_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings->test_secret_key }}@endif" />

						<br />
						<p><?php echo _i("Test Publishable Key");?>:</p>
						<input type="text" class="form-control" name="test_publishable_key" id="test_publishable_key" placeholder="<?php echo _i("Test Publishable Key");?>" value="@if(!empty($payment_settings->test_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings->test_publishable_key }}@endif" />

						<br />
						<p><?php echo _i("Live Secret Key");?>:</p>
						<input type="text" class="form-control" name="live_secret_key" id="live_secret_key" placeholder="<?php echo _i("Live Secret Key");?>" value="@if(!empty($payment_settings->live_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings->live_secret_key }}@endif" />

						<br />
						<p><?php echo _i("Live Publishable Key");?>:</p>
						<input type="text" class="form-control" name="live_publishable_key" id="live_publishable_key" placeholder="<?php echo _i("Live Publishable Key");?>" value="@if(!empty($payment_settings->live_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings->live_publishable_key }}@endif" />
					</div> 
				</div>
			</div>

		</div>

		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="submit" value="<?php echo _i("Update Payment Settings");?>" class="btn btn-success pull-right" />

	</form>

	<div class="clear"></div>

</div><!-- admin-container -->

@section('javascript')
	<script src="{{ '/application/assets/admin/js/bootstrap-switch.min.js' }}"></script>
	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){

			$('input[type="checkbox"]').change(function() {
				if($(this).is(":checked")) {
			    	$(this).val(1);
			    } else {
			    	$(this).val(0);
			    }
			});

		});

	</script>

@stop

@stop