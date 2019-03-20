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

class PaymentSetting extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public $timestamps = false;

	protected $fillable = array('live_mode', 'test_secret_key', 'test_publishable_key', 'live_secret_key', 'live_publishable_key');
}