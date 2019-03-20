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

use App\Http\Controllers\Controller as Controller;
use App\Models\Setting;

class BaseController extends Controller {

    public function __construct() {
        LaravelGettext::setDomain("theme");
//        LaravelGettext::setDomain("messages");
        $settings = Setting::first();
        if(!is_null($settings->locale)) {
            LaravelGettext::setLocale($settings->locale);
            setlocale(LC_ALL, $settings->locale . '.utf8');
        }
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}