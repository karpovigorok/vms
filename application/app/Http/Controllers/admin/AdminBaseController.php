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

//namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Libraries\ThemeHelper;

class AdminBaseController extends Controller {
    public function __construct() {
        LaravelGettext::setDomain("admin");
//        LaravelGettext::setDomain("messages");
        $settings = ThemeHelper::getSystemSettings();

        if(!is_null($settings->locale)) {
            LaravelGettext::setLocale($settings->locale);
            setlocale(LC_ALL, $settings->locale . '.utf8');
        }

        //parent::__construct();
    }
}