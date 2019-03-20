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

class UpgradeController extends Controller {


	public function upgrade()
	{
		$upgraded = $this->upgrade105();
		$upgraded = $this->upgrade106();
		if($upgraded){
			return \Redirect::to('/')->with(array('note' => _i('Successfully Updated Your Script'), 'note_type' => 'success') );
		} else {
			return \Redirect::to('/');
		}
	}

	private function upgrade105()
	{
		if( !Schema::hasColumn('settings', 'videos_per_page') ){
			Schema::table('settings', function($table)
			{
			    // Added for V 1.0.5
				$table->integer('videos_per_page')->default(12);
				$table->integer('posts_per_page')->default(12);
			});
			return true;
		} else {
			return false;
		}
	}

	private function upgrade106(){
		$return_value = false;
		
		if( !Schema::hasColumn('settings', 'free_registration') ){
			Schema::table('settings', function($table)
			{
			    // Added for V 1.0.6
				$table->boolean('free_registration')->default(0);
				$table->boolean('activation_email')->default(0);
				$table->boolean('premium_upgrade')->default(1);
			});
			$return_value = true;
		}

		return $return_value;
	}

}
