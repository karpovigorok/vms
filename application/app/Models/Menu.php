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

class Menu extends Eloquent {
	protected $guarded = array();

	protected $table = 'menu';

	public static $rules = array();

	public function hasChildren(){
		if(DB::table('menu')->where('parent_id', '=', $this->id)->count() >= 1){
			return true;
		} else {
			return false;
		}
	}

}