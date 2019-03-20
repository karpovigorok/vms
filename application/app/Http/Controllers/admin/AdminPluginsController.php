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


class AdminPluginsController extends \AdminBaseController {

	public function index()
	{

		$plugins = $this->get_plugins();

		$data = array(
			'admin_user' => Auth::user(),
			'plugins' => $plugins,
			);
		return View::make('admin.plugins.index', $data);
	}

	public function get_plugins() {
		$plugins = array();
		$plugin_folder = 'content/plugins';
		$plugins_dir = @ opendir( $plugin_folder);
		$plugin_files = array();

		if ( $plugins_dir ) {
			
			while (($folder = readdir( $plugins_dir ) ) !== false ) {
				if( @is_readable("$plugin_folder/$folder/info.json") ){
					$plugin_info = file_get_contents("$plugin_folder/$folder/info.json");
					$plugin_info = json_decode($plugin_info, true);
					$plugin_info['slug'] = $folder;
					array_push($plugins, $plugin_info);
				}
			}
			closedir( $plugins_dir );
		}
		return $plugins;
	}

	private function get_plugin($slug){
		$plugin_folder = 'content/plugins';
		if( @is_readable("$plugin_folder/$slug/info.json") ){
			$plugin_info = file_get_contents("$plugin_folder/$slug/info.json");
			$plugin_info = json_decode($plugin_info, true);
			$plugin_info['slug'] = $slug;
            return $plugin_info;
		}
        else {
            return false;
        }

	}

	public function activate($slug){
		
		$plugin = Plugin::where('slug', '=', $slug)->first();
		$plugin_data = $this->get_plugin($slug);
		if(!empty($plugin->slug)){
			$plugin->active = 1;
			$plugin->save();
		} else {
			$new_plugin = new Plugin();
			$new_plugin->name = $plugin_data['name'];
			$new_plugin->description = $plugin_data['description'];
			$new_plugin->version = $plugin_data['version'];
			$new_plugin->slug = $slug;
			$new_plugin->active = 1;
			$new_plugin->save();
		}
		return Redirect::to('admin/plugins')->with(array('note' => _i('Successfully Activated') . ' ' . $plugin_data['name'], 'note_type' => 'success'));
	}

	public function deactivate($slug){
		$plugin_data = $this->get_plugin($slug);
		$plugin = Plugin::where('slug', '=', $slug)->first();
		$plugin->active = 0;
		$plugin->save();
		return Redirect::to('admin/plugins')->with(array('note' => _i('Successfully De-activated') . ' ' . $plugin_data['name'], 'note_type' => 'success'));
	}

}