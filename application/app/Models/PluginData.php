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
namespace App\Models;
use Eloquent;
class PluginData extends Eloquent 
{
	protected $table = 'plugin_data';
	protected $guarded = array();
	public static $rules = array();
}