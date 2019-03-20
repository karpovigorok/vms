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

class PostCategory extends Eloquent {
	protected $guarded = array();

	protected $table = 'post_categories';

	public static $rules = array();

	public function posts(){
		return $this->hasMany('Post');
	}

	public function hasChildren(){
		if(\DB::table('post_categories')->where('parent_id', '=', $this->id)->count() >= 1){
			return true;
		} else {
			return false;
		}
	}

}