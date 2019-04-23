<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use \App\Libraries\ThemeHelper;

/**
 * Secure
 * Redirects any non-secure requests to their secure counterparts.
 * 
 * @param request The request object.
 * @param $next The next closure.
 * @return redirects to the secure counterpart of the requested uri.
*/
class Secure {
	protected $app;
	
	public function __construct(Application $app)
	{
		$this->app = $app;
	}
	
	public function handle($request, Closure $next)
	{
		$settings = ThemeHelper::getSystemSettings();

		if (!$request->secure() && $settings->enable_https) {
			if($request->header('x-forwarded-proto') <> 'https'){
        		return redirect()->secure($request->getRequestUri());
	    	}
		}
	
		return $next($request);
	}
	
}