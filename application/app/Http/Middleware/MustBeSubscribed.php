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

namespace App\Http\Middleware;

use Closure;
use \Auth as Auth;

class MustBeSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd(Auth::guest());
            if (!Auth::guest()){
				$settings = \App\Libraries\ThemeHelper::getSystemSettings();
				$free_registration = $settings->free_registration;

				if( (!Auth::user()->subscribed('main') && Auth::user()->role == 'subscriber') || (!$free_registration && Auth::user()->role == 'registered') ){
					$username = Auth::user()->username;
			    	return \Redirect::to('user/' . $username . '/renew_subscription')->with(array('note' => _i('Uh oh, looks like you don\'t have an active subscription, please renew to gain access to all content'), 'note_type' => 'error'));
				}
			}

        return $next($request);
    }
}
