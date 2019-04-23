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

class Page extends Eloquent {
	protected $guarded = array();


	public static $rules = array();

	protected $table = 'pages';

	protected $fillable = array('user_id', 'title', 'slug', 'image', 'body', 'active', 'created_at');

}