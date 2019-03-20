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

use \App\Models\Setting;
use \App\Libraries\ThemeHelper;

class ImageHandler {

	public static function uploadImage($image, $folder, $filename = '', $type = 'upload'){
		return call_user_func (
            Config::get('site.media_upload_function'),
            array('image' => $image, 'folder' => $folder, 'filename' => $filename, 'type' => $type) );
	}

	public static function getImage($image, $size = ''){
		$img = ''; // placeholder image

		$image_url = '';// Config::get('site.uploads_dir') . 'images/';

		if($size == ''){
			$img = $image;
		} else {

            $img = str_replace('.' . pathinfo($image, PATHINFO_EXTENSION), '-' . $size . '.' . pathinfo($image, PATHINFO_EXTENSION), $image);
		}

		return $image_url . $img;

	}

	public static function uploadImg($image, $filename){
		// Lets get all these Arguments and assign them!
		$image = $image;
		$filename = $filename; 
		$month_year = date('FY').'/';

		// Check it out! This is the upload folder
		$upload_folder = 'content/uploads/images/'.$month_year;

		if ( @getimagesize($image) ){

			// if the folder doesn't exist then create it.
			if (!file_exists($upload_folder)) {
				mkdir($upload_folder, 0777, true);
			}

			$filename =  $image->getClientOriginalName();

			// if the file exists give it a unique name
			while (file_exists($upload_folder.$filename)) {
				$filename =  uniqid() . '-' . $filename;
			}

			$uploadSuccess = $image->move($upload_folder, $filename);
		
			$settings = Setting::first();

			$img = Image::make($upload_folder . $filename);

			$img->save($upload_folder . $filename);
			
			return $month_year . $filename;

		} else {
			return false;
		}
	}

	public static function upload($args){

		// Lets get all these Arguments and assign them!
		$image = $args['image'];
		$folder = $args['folder'];
		$filename = $args['filename']; 
		$type = $args['type'];

		// Hey if the folder we want to put them in is images. Let's give them a month and year folder
		if($folder == 'images'){
			$month_year = date('FY').'/';
		} else {
			$month_year = '';
		}

		// Check it out! This is the upload folder
		$upload_folder = 'content/uploads/' . $folder . '/'.$month_year;
        //$upload_folder = __DIR__ . Config::get('site.uploads_dir') . $folder . '/'.$month_year;
        //Config::get('site.uploads_url');
		//$upload_folder = 'content/uploads/video/' . $folder . '/';


		if ( $image_info = @getimagesize($image) ){ //check if image uploaded



			// if the folder doesn't exist then create it.
			if (!file_exists($upload_folder)) {
				mkdir($upload_folder, 0777, true);
			}

			if($type =='upload'){

				$filename =  $image->getClientOriginalName();

				// if the file exists give it a unique name
				while (file_exists($upload_folder.$filename)) {
					$filename =  uniqid() . '-' . $filename;
				}


				$uploadSuccess = $image->move($upload_folder, $filename);

				if(strpos($filename, '.gif') > 0){
					$new_filename = str_replace('.gif', '-animation.gif', $filename);
					copy($upload_folder . $filename, $upload_folder . $new_filename);
				}

			} else if($type = 'url'){
				
				$file = file_get_contents($image);

				if(strpos($image, '.gif') > 0){
					$extension = '-animation.gif';
				} else {
					$extension = '.jpg';
				}


				$filename = $filename . $extension;

				if (file_exists($upload_folder.$filename)) {
					$filename =  uniqid() . '-' . $filename;
				}

			    if(strpos($image, '.gif') > 0){
					file_put_contents($upload_folder.$filename, $file);
					$filename = str_replace('-animation.gif', '.gif', $filename);
				}

			    file_put_contents($upload_folder.$filename, $file);

			}
            //ignore ICO, resize other
            if($image_info[2] != IMAGETYPE_ICO) {
                $settings = Setting::first();
                $img = Image::make($upload_folder . $filename);
                $theme_config = ThemeHelper::get_theme_config($settings->theme);

                foreach($theme_config['image'] as $destination => $dimensions) {
                    if(strpos($folder, $destination) === 0) {
                        foreach($dimensions as $dimension_key => $dimension) {
                            Image::make($upload_folder . $filename)->resize($dimension['width'], $dimension['height'], function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($upload_folder . pathinfo($filename, PATHINFO_FILENAME) . "-" . $dimension_key . '.' . pathinfo($filename, PATHINFO_EXTENSION));
                        }
                    }
                }
                $img->save($upload_folder . $filename);
            }

			return "/" . $upload_folder . $filename;

		} else {
			return false;
		}
	}

}