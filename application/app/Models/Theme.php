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

class Theme extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public $timestamps = false;

	protected $fillable = array('name', 'description', 'version', 'slug', 'active');
}