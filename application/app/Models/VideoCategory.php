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
use Arcanedev\LaravelSeo\Traits\Seoable;


class VideoCategory extends Eloquent {

    use Seoable;



	protected $guarded = array();

	protected $table = 'video_categories';

	public static $rules = array();

	public function videos(){
		return $this->hasMany('Video');
	}

	public function hasChildren(){
		if(\DB::table('video_categories')->where('parent_id', '=', $this->id)->count() >= 1){
			return true;
		} else {
			return false;
		}
	}
}