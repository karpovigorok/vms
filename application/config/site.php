<?php
/**
 * Developed by Igor Karpov and Sergey Karpov on 07.02.19 22:08
 * Last modified 07.02.19 0:15
 * Website: https://noxls.net
 * Email: mail@noxls.net
 * Copyright (c) 2019.
 *
 */

return array(

	/*
	|--------------------------------------------------------------------------
	| Number of results to show per page
	|--------------------------------------------------------------------------
	|
	| To Use, simply call Config::get('site.num_results_per_page');
	|
	*/

	'uploads_url' => '/content/uploads/',
	'uploads_dir' => '/content/uploads/',
	'media_upload_function' => 'ImageHandler::upload',
	'num_results_per_page' => 15,
    'video' => [
        'convert' => false,
        'keep_original' => true,
        'dimensions' => []
    ],
    'version' => '1.0'

);