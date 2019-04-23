<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php

use \Auth as Auth;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Contracts\Auth\PasswordBroker;
use \App\Libraries\ThemeHelper;

use \App\Models\PaymentSetting;
use \App\Models\VideoCategory;
use \App\Models\PostCategory;
use \App\Models\Page;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;

class ThemeAuthController extends BaseController {

	public function __construct()
	{
		$this->middleware('secure');
        parent::__construct();
	}
	
	/*
	|--------------------------------------------------------------------------
	| Auth Controller
	|--------------------------------------------------------------------------
	*/

	public function login_form(){
        Log::debug('Log in form');
		if(!Auth::guest()){
			return Redirect::to('/');
		}
		$data = array(
			'type' => 'login',
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);
		return View::make('Theme::auth', $data);
	}

	public function signup_form(){

		if(!Auth::guest()){
			return Redirect::to('/');
		}
		$data = array(
			'type' => 'signup',
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'payment_settings' => PaymentSetting::first(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);
		return View::make('Theme::auth', $data);
	}

	public function login(){

        Log::debug('Log in post');

		$settings = ThemeHelper::getSystemSettings();

	    // get login POST data
	    $email_login = array(
	        'email' => Input::get('email'),
	        'password' => Input::get('password')
	    );

	    $username_login = array(
	        'username' => Input::get('email'),
	        'password' => Input::get('password')
	    );

	    if ( Auth::attempt($email_login) || Auth::attempt($username_login) ){

	    	if($settings->free_registration && !Auth::user()->stripe_active){
    			Auth::user()->role = 'registered';
    			$user = User::find(Auth::user()->id);
    			$user->role = 'registered';
    			$user->save();
    		}
	    	if(Auth::user()->subscribed('main') || (Auth::user()->role == 'admin' || Auth::user()->role == 'demo') || ($settings->free_registration && Auth::user()->role == 'registered') ):
	    		$redirect = (Input::get('redirect', 'false')) ? Input::get('redirect') : '/';
	    		if(Auth::user()->role == 'demo' && ThemeHelper::getSystemSettings()->demo_mode != 1){
	    			Auth::logout();
	    			return Redirect::to($redirect)->with(array('note' => 'Sorry, demo mode has been disabled', 'note_type' => 'error'));
	    		} elseif($settings->free_registration && $settings->activation_email && Auth::user()->active == 0) {
	    			Auth::logout();
	    			return Redirect::to($redirect)->with(array('note' => 'Please make sure to activate your account in your email before logging in.', 'note_type' => 'error'));
	    		} else {
                    Log::debug('Logged in');
	    			return Redirect::to($redirect)->with(array('note' => 'You have been successfully logged in.', 'note_type' => 'success'));
	    		}
	    	else:
	    		$username = Auth::user()->username;
	    		return Redirect::to('user/' . $username . '/renew_subscription')->with(array('note' => _i('Uh oh, looks like you don\'t have an active subscription, please renew to gain access to all content'), 'note_type' => 'error'));
	    	endif;
	    	
	    } else {

	    	$redirect = (Input::get('redirect', false)) ? '?redirect=' . Input::get('redirect') : '';
	        // auth failure! redirect to login with errors
	        return Redirect::to('login' . $redirect)->with(array('note' => _i('Invalid login, please try again.'), 'note_type' => 'error'));
	    }
	    
	}

	public function signup(){

		$input = Input::all();
		$user_data = array('username' => Input::get('username'), 'email' => Input::get('email'), 'password' => Hash::make(Input::get('password')) );

		$settings = ThemeHelper::getSystemSettings();
		if(!$settings->free_registration){
		
			$payment_settings = PaymentSetting::first();

			if($payment_settings->live_mode){
				User::setStripeKey( $payment_settings->live_secret_key );
			} else {
				User::setStripeKey( $payment_settings->test_secret_key );
			}
			  
			$token = Input::get('stripeToken');

			unset($input['stripeToken']);
		} else {
			if($settings->activation_email):
				$user_data['activation_code'] = str_random(60);
				$user_data['active'] = 0;
			endif;

			$user_data['role'] = 'registered';
		}

		$validation = Validator::make( $input, User::$rules );

		if ($validation->fails()){
			return Redirect::to('/signup')->with(array('note' => _i('Sorry, there was an error creating your account.'), 'note_type' => 'error', 'messages'))->withErrors($validation)->withInput(\Request::only('username', 'email'));
		}

	    $user = new User($user_data);
	    $user->save();

	    try{
	    	if($settings->free_registration && $settings->activation_email){
	    		
	    		Mail::send('Theme::emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) {
            		$message->to(Input::get('email'), Input::get('username'))->subject('Verify your email address');
       			 });

	    		return Redirect::to('/login')->with(array('note' => _i('Success! One last step, be sure to verify your account by clicking on the activation link sent to your email.'), 'note_type' => 'success'));

	    	} else {
	    		if(!$settings->free_registration){
	    			$user->subscription('monthly')->create($token, ['email' => $user->email]);
	    		}
	    		Auth::loginUsingId($user->id);
	    		return Redirect::to('/')->with(array('note' => _i('Welcome! Your Account has been Successfully Created!'), 'note_type' => 'success'));
	    	}
	    } catch(Exception $e){
	    	Auth::logout();
	    	$user->delete();
	    	return Redirect::to('/signup')->with(array('note' => _i('Sorry, there was an error with your card: %s', $e->getMessage()), 'note_type' => 'error'))->withInput(\Request::only('username', 'email'));
	    }

	}

	public function verify($activation_code){
		if( ! $activation_code)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::where('activation_code', '=', $activation_code)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->active = 1;
        $user->activation_code = null;
        $user->save();

        return Redirect::to('/login')->with(array('note' => _i('You have successfully verified your account. Please login below.'), 'note_type' => 'success'));
	}

	public function logout(){
		Auth::logout();
		return Redirect::back()->with(array('note' => _i('You have been successfully logged out'), 'note_type' => 'success'));
	}


	// ********** RESET PASSWORD ********** //
	public function password_reset()
	{
		$data = array(
			'type' => 'forgot_password',
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'payment_settings' => PaymentSetting::first(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);
		return View::make('Theme::auth', $data);
	}

	// ********** RESET REQUEST ********** //
	public function password_request()
	{

        $user = User::where('email', request()->input('email'))->first();
        $token = Password::getRepository()->create($user);
//dd($user->email);
        Mail::send(['text' => 'emails.password'], ['token' => $token], function (Message $message) use ($user) {
            $message->subject(config('app.name') . ' Password Reset Link');
            $message->to($user->email);
        });
        return Redirect::to('login')->with(array( 'note_type' => 'success'));


//		$credentials = array('email' => Input::get('email'));
//		$response = Password::sendResetLink($credentials, function($message){
//			$message->subject('Password Reset Info');
//		});
//		switch ($response)
//		{
//			case PasswordBroker::RESET_LINK_SENT:
//				return Redirect::to('login')->with(array('note' => trans($response), 'note_type' => 'success'));
//
//			case PasswordBroker::INVALID_USER:
//				return redirect()->back()->with(array('note' => trans($response), 'note_type' => 'error'));
//		}
	}

	// ********** RESET PASSWORD TOKEN ********** //
	public function password_reset_token($token)
	{
		$data = array(
			'type' => 'reset_password',
			'token' => $token,
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'payment_settings' => PaymentSetting::first(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);
	  return View::make('Theme::auth', $data);
	}

	// ********** RESET PASSWORD POST ********** //
	public function password_reset_post(Request $request)
	{

		$credentials = $credentials = array('email' => Input::get('email'), 'password' => Input::get('password'), 'password_confirmation' => Input::get('password_confirmation'), 'token' => Input::get('token'));



		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = \Hash::make($password);

			$user->save();

		});

		switch ($response)
		{
			case PasswordBroker::PASSWORD_RESET:
				return Redirect::to('login')->with(array('note' => _i('Your password has been successfully reset. Please login below'), 'note_type' => 'success'));

			default:
				return redirect()->back()->with(array('note' => trans($response), 'note_type' => 'error'));
		}

	  
	}

}