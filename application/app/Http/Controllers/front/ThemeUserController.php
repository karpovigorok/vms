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

use App\User as User;
use App\Models\PaymentSetting;
use \Redirect as Redirect;
use App\Models\Video;
use App\Libraries\ThemeHelper;
use App\Models\VideoCategory;
use App\Models\PostCategory;
use App\Models\Favorite;
use App\Models\Page;
use Illuminate\Support\Facades\Log;

class ThemeUserController extends BaseController
{


    public function __construct()
    {
        $this->middleware('secure');
        parent::__construct();
    }

    public static $rules = array(
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed'
    );

    public function favorite($username)
    {

        $user = User::where('username', '=', $username)->first();
        $favorites = Favorite::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();

        $data = array(
            'user' => $user,
            'type' => 'profile',
            //'menu' => Menu::orderBy('order', 'ASC')->get(),
            //'video_categories' => VideoCategory::all(),
            //'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            //'pages' => Page::where('active', '=', 1)->get(),
        );
        $data['content_block'] = View::make('Theme::partials.user-favorite-videos', ['favorites' => $favorites])->render();
        return View::make('Theme::user', $data);
    }

    //show uploaded videos
    public function index($username)
    {

        $user = User::where('username', '=', $username)->first();

        $videos = Video::where('user_id', $user->id)->take(9)->get();

        $data = array(
            'user' => $user,
            'theme_settings' => ThemeHelper::getThemeSettings(),

        );
        $data['content_block'] = View::make('Theme::partials.user-uploaded-videos', ['videos' => $videos])->render();
        return View::make('Theme::user', $data);
    }

    //show comments
    public function comments($username)
    {
        $user = User::where('username', '=', $username)->first();
        $comments = App\Models\Comment::where('approved', '=', '1')->where('commented_id', $user->id)->orderBy('created_at', 'desc')->take(9)->get();

        $data = array(
            'user' => $user,
            'theme_settings' => ThemeHelper::getThemeSettings(),
        );
        $data['content_block'] = View::make('Theme::partials.user-comments', ['comments' => $comments])->render();
        return View::make('Theme::user', $data);
    }


    public function edit($username)
    {
        if (!Auth::guest() && Auth::user()->username == $username) {

            $user = User::where('username', '=', $username)->first();

            $data = array(
                'user' => $user,
                'post_route' => URL::to('user') . '/' . $user->username . '/update',
                'type' => 'edit',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'video_categories' => VideoCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
            );
            $data['content_block'] = View::make('Theme::partials.user-edit')->render();
            return View::make('Theme::user', $data);

        } else {
            return Redirect::to('/');
        }
    }

    public function update($username)
    {

        $input = array_except(Input::all(), '_method');
        $input['username'] = str_replace('.', '-', $input['username']);

        $user = User::where('username', '=', $username)->first();

        if (Auth::user()->id == $user->id) {

            if (Input::hasFile('avatar')) {
                $input['avatar'] = ImageHandler::uploadImage(Input::file('avatar'), 'avatars');
            } else {
                $input['avatar'] = $user->avatar;
            }

            if ($input['password'] == '') {
                $input['password'] = $user->password;
            } else {
                $input['password'] = Hash::make($input['password']);
            }

            if ($user->username != $input['username']) {
                $username_exist = User::where('username', '=', $input['username'])->first();
                if ($username_exist) {
                    return Redirect::to('user/' . $user->username . '/edit')->with(array('note' => _i('Sorry That Username is already in Use'), 'note_type' => 'error'));
                }
            }

            $user->update($input);

            return Redirect::to('user/' . $user->username . '/edit')->with(array('note' => _i('Successfully Updated User Info'), 'note_type' => 'success'));
        }

        return Redirect::to('user/' . Auth::user()->username . '/edit ')->with(array('note' => _i('Sorry, there seems to have been an error when updating the user info'), 'note_type' => 'error'));

    }


    public function billing($username)
    {
        if (Auth::guest()):
            return Redirect::to('/');
        endif;

        if (Auth::user()->username == $username) {

            if (Auth::user()->role == 'admin' || Auth::user()->role == 'admin') {
                return Redirect::to('/user/' . $username . '/edit')->with(array('note' => _i('This user type does not have billing info associated with their account.'), 'note_type' => 'warning'));
            }

            $user = User::where('username', '=', $username)->first();
            $payment_settings = PaymentSetting::first();

            if ($payment_settings->live_mode) {
                User::setStripeKey($payment_settings->live_secret_key);
            } else {
                User::setStripeKey($payment_settings->test_secret_key);
            }

            //dd($user->asStripeCustomer());
            $invoices = [];
            if($user->role == 'subscriber') {
                $invoices = $user->invoices();
            }


            $data = array(
                'user' => $user,
                'post_route' => URL::to('user') . '/' . $user->username . '/update',
                'type' => 'billing',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'video_categories' => VideoCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'payment_settings' => $payment_settings,
                //'invoices' => $invoices,
                'pages' => Page::where('active', '=', 1)->get(),
            );
            $data['content_block'] = View::make('Theme::partials.user-billing', ['invoices' => $invoices, 'user' => $user,])->render();
            return View::make('Theme::user', $data);

        } else {
            return Redirect::to('/');
        }
    }

    public function cancel_account($username)
    {
        if (Auth::guest()):
            return Redirect::to('/');
        endif;

        if (Auth::user()->username == $username) {

            $payment_settings = PaymentSetting::first();

            if ($payment_settings->live_mode) {
                User::setStripeKey($payment_settings->live_secret_key);
            } else {
                User::setStripeKey($payment_settings->test_secret_key);
            }

            $user = Auth::user();
            $user->subscription('main')->cancel();

            return Redirect::to('user/' . $username . '/billing')->with(array('note' => _i('Your account has been cancelled.'), 'note_type' => 'success'));
        }
    }

    public function resume_account($username)
    {
        if (Auth::guest()):
            return Redirect::to('/');
        endif;

        if (Auth::user()->username == $username) {

            $payment_settings = PaymentSetting::first();

            if ($payment_settings->live_mode) {
                User::setStripeKey($payment_settings->live_secret_key);
            } else {
                User::setStripeKey($payment_settings->test_secret_key);
            }

            $user = Auth::user();
            $user->subscription('main')->resume();

            return Redirect::to('user/' . $username . '/billing')->with(array('note' => _i('Welcome back, your account has been successfully re-activated.'), 'note_type' => 'success'));
        }

    }

    public function update_cc_store($username)
    {
        if (Auth::guest()):
            return Redirect::to('/');
        endif;

        $payment_settings = PaymentSetting::first();

        if ($payment_settings->live_mode) {
            User::setStripeKey($payment_settings->live_secret_key);
        } else {
            User::setStripeKey($payment_settings->test_secret_key);
        }

        $user = Auth::user();

        if (Auth::user()->username == $username) {

            $token = Input::get('stripeToken');

            try {

                $user->subscription('main')->resume($token);
                return Redirect::to('user/' . $username . '/billing')->with(array('note' => _i('Your Credit Card Info has been successfully updated.'), 'note_type' => 'success'));

            } catch (Exception $e) {
                return Redirect::to('/user/' . $username . '/update_cc')->with(array('note' => _i('Sorry, there was an error with your card: %s', $e->getMessage()), 'note_type' => 'error'));
            }

        } else {
            return Redirect::to('user/' . $username);
        }

    }

    public function update_cc($username)
    {
        if (Auth::guest()):
            return Redirect::to('/');
        endif;

        $payment_settings = PaymentSetting::first();

        if ($payment_settings->live_mode) {
            User::setStripeKey($payment_settings->live_secret_key);
        } else {
            User::setStripeKey($payment_settings->test_secret_key);
        }

        $user = Auth::user();

        if (Auth::user()->username == $username && $user->subscribed('main')) {

            $data = array(
                'user' => $user,
                'post_route' => URL::to('user') . '/' . $user->username . '/update',
                'type' => 'update_credit_card',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'payment_settings' => $payment_settings,
                'video_categories' => VideoCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
            );

            $data['content_block'] = View::make('Theme::partials.user-update-billing', ['user' => $user, 'payment_settings' => PaymentSetting::first() ])->render();
            return View::make('Theme::user', $data);
        } else {
            return Redirect::to('user/' . $username);
        }

    }

    public function renew($username)
    {
        if (Auth::guest()):
            return Redirect::to('/');
        endif;

        $user = User::where('username', '=', $username)->first();

        $payment_settings = PaymentSetting::first();

        if ($payment_settings->live_mode) {
            User::setStripeKey($payment_settings->live_secret_key);
        } else {
            User::setStripeKey($payment_settings->test_secret_key);
        }

        if (Auth::user()->username == $username) {

            $data = array(
                'user' => $user,
                'post_route' => URL::to('user') . '/' . $user->username . '/update',
                'type' => 'renew_subscription',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'payment_settings' => $payment_settings,
                'video_categories' => VideoCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
            );

            return View::make('Theme::user', $data);
        } else {
            return Redirect::to('/');
        }
    }

    public function upgrade($username)
    {
        if (Auth::guest()):
            return Redirect::to('/');
        endif;

        $user = User::where('username', '=', $username)->first();

        $payment_settings = PaymentSetting::first();
        if ($payment_settings) {
            $stripe_subscription_plans = false;
            if (!$payment_settings->live_mode && $payment_settings->test_secret_key != '') {
                \Stripe\Stripe::setApiKey($payment_settings->test_secret_key);
                $stripe_subscription_plans = \Stripe\Plan::all();
                User::setStripeKey($payment_settings->test_secret_key);
            } else if ($payment_settings->live_mode && $payment_settings->live_secret_key != '') {
                \Stripe\Stripe::setApiKey($payment_settings->live_secret_key);
                $stripe_subscription_plans = \Stripe\Plan::all();
                User::setStripeKey($payment_settings->live_secret_key);
            }
        }

//dd($stripe_subscription_plans);

        if (Auth::user()->username == $username) {

            $data = array(
                'user' => $user,
                'post_route' => URL::to('user') . '/' . $user->username . '/update',
                'type' => 'upgrade_subscription',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'payment_settings' => $payment_settings,
                'video_categories' => VideoCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
                'stripe_subscription_plans' => $stripe_subscription_plans,
            );

            return View::make('Theme::user-subscription', $data);
        } else {
            return Redirect::to('/');
        }
    }

    public function upgrade_cc_store($username)
    {

        Log::debug($username);

        $payment_settings = PaymentSetting::first();
        Log::debug('Payment mode is live: ' . $payment_settings->live_mode);
        if (Auth::guest()):
            return Redirect::to('/');
        endif;



        if ($payment_settings->live_mode) {
            User::setStripeKey($payment_settings->live_secret_key);
        } else {
            User::setStripeKey($payment_settings->test_secret_key);
        }



        $user = User::find(Auth::user()->id);
        if (Auth::user()->username == $username) {
            $token = Input::get('stripeToken');
            try {

                $user->newSubscription('main', Input::get('stripe_subscription_plan'))->create($token);
                $user->role = 'subscriber';
                $user->stripe_active = 1;

                $user->save();
                Log::debug('User subscribed successfully.');
                return Redirect::to('user/' . $username . '/billing')->with(array('note' => _i('You have been successfully signed up for a subscriber membership!'), 'note_type' => 'success'));

            } catch (Exception $e) {
                Log::debug($e->getMessage());
                return Redirect::to('/user/' . $username . '/upgrade_subscription')->with(array('note' => _i('Sorry, there was an error with your card: %s', $e->getMessage()), 'note_type' => 'error'));
            }

        } else {
            return Redirect::to('user/' . $username);
        }
    }
}