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

class Favorite extends Eloquent {

	protected $table = 'favorites';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array('user_id', 'video_id');

	public function user() {
		return $this->belongsTo('User')->first();
	}

	public function video() {
		return $this->belongsTo('App\Models\Video')->first();
	}
}