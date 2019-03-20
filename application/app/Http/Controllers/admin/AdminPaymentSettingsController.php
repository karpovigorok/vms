<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<?php

use \Redirect as Redirect;
use App\Models\PaymentSetting;
use App\Models\Setting;

class AdminPaymentSettingsController extends \AdminBaseController {

	public function index()
	{


        $payment_settings = PaymentSetting::first();
        $stripe_subscription_plans = false;
        if(!$payment_settings->live_mode && $payment_settings->test_secret_key != '') {
            \Stripe\Stripe::setApiKey($payment_settings->test_secret_key);
            $stripe_subscription_plans = \Stripe\Plan::all();
        }
        else if($payment_settings->live_mode && $payment_settings->live_secret_key != '') {
            \Stripe\Stripe::setApiKey($payment_settings->live_secret_key);
            $stripe_subscription_plans = \Stripe\Plan::all();
        }
		$data = array(
			'admin_user' => Auth::user(),
			'settings' => Setting::first(),
			'payment_settings' => $payment_settings,
            'stripe_subscription_plans' => $stripe_subscription_plans
			);


		return View::make('admin.paymentsettings.index', $data);
	}

	public function save_payment_settings(){

		$input = Input::all();

		$payment_settings = PaymentSetting::first();

		if(!isset($input['live_mode'])){
			$input['live_mode'] = 0;
		}

        $payment_settings->update($input);

        return Redirect::to('admin/payment_settings')->with(array('note' => _i('Successfully Updated Payment Settings!'), 'note_type' => 'success') );

	}

}