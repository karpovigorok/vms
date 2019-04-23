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
class PluginData extends Eloquent 
{
	protected $table = 'plugin_data';
	protected $guarded = array();
	public static $rules = array();
}