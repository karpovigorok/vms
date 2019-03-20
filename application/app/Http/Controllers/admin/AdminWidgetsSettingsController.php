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

use Illuminate\Http\Request;
use App\Models\ThemeSetting;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

//use App\Hel

class AdminWidgetsSettingsController extends \AdminBaseController {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //  @TODO: add phpDoc params parser

//        $settings = Setting::first();
//        $widgets_dir = THEME_DIR . "/widgets";
//        if ($handle = opendir($widgets_dir)) {
//            while (false !== ($entry = readdir($handle))) {
//                if ($entry != "." && $entry != "..") {
//                    echo "$entry\n";
//                }
//            }
//            closedir($handle);
//        }
        $data = array(
            'widgets' => [],
        );
        return View::make('admin.widgets.index', $data);
    }
}