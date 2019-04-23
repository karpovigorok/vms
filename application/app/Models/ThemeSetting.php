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
namespace App\Models;

use Eloquent;


class ThemeSetting extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	protected $fillable = array('theme_slug', 'key', 'value');
}