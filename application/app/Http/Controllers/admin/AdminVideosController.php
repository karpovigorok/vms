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

use \Redirect as Redirect;
use \App\Models\Video;
use \App\Models\Setting;
use \App\Models\AllowedMime;
use \App\Models\VideoCategory;
use \App\Models\Tag;
use \App\Libraries\ThemeHelper;
use \App\Libraries\VMSHelper;

class AdminVideosController extends \AdminBaseController {

    /**
     * Display a listing of videos
     *
     * @return Response
     */
    public function index()
    {
        //dd(Config::get('site.uploads_dir'));

        $search_value = Input::get('s');
        
        if(!empty($search_value)):
            $videos = Video::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $videos = Video::orderBy('created_at', 'DESC')->paginate(9);
        endif;
        
        $user = Auth::user();

        $data = array(
            'videos' => $videos,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View::make('admin.videos.index', $data);
    }

    /**
     * Show the form for creating a new video
     *
     * @return Response
     */
    public function create()
    {
        $allowed_mime = AllowedMime::select('mime','extension')->where('active', '=', 1)->where('type', '=', 'video')->get()->toArray();
        $allowed_extensions = AllowedMime::select('extension')->where('active', '=', 1)->where('type', '=', 'video')->groupBy('extension')->get()->toArray();
        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> ' . _i('New Video'),
            'post_route' => URL::to('admin/videos/store'),
            'button_text' => _i('Add New Video'),
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            'allowed_mime_string' => VMSHelper::convert_multi_array($allowed_mime),
            'allowed_extensions_string' => VMSHelper::convert_multi_array($allowed_extensions),
            );
        return View::make('admin.videos.create_edit', $data);
    }

    /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), Video::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $tags = $data['tags'];
        unset($data['tags']);
        
        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
        if(isset($data['duration']) && strlen($data['duration']) > 0){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }
        else {
            unset($data['duration']);
        }
        if(isset($data['id']) && $data['id'] > 0) {

            $video = Video::findOrFail($data['id']);
            $video->update($data);
        }
        else {
            $video = Video::create($data);
        }


        $image = (isset($data['image'])) ? $data['image'] : '';
        if(!empty($image)){
            $data['image'] = ImageHandler::uploadImage($data['image'], 'video/'. $video->get_dir_path() . "/thumbs/");
            $video->image = $data['image'];//thumbs generated
        } else if($video->image == '') {
            $data['image'] = '/application/assets/img/blur-background/2.jpg';
            $video->image = $data['image'];//thumbs generated
        }
        $video->save();
        $this->addUpdateVideoTags($video, $tags);

        return Redirect::to('admin/videos')->with(array('note' => _i('New Video Successfully Added!'), 'note_type' => 'success') );
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $video = Video::find($id);
        $allowed_mime = AllowedMime::select('mime','extension')->where('active', '=', 1)->where('type', '=', 'video')->get()->toArray();
        $allowed_extensions = AllowedMime::select('extension')->where('active', '=', 1)->where('type', '=', 'video')->groupBy('extension')->get()->toArray();

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> ' . _i('Edit Video'),
            'video' => $video,
            'post_route' => URL::to('admin/videos/update'),
            'button_text' => _i('Update Video'),
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            'allowed_mime_string' => VMSHelper::convert_multi_array($allowed_mime),
            'allowed_extensions_string' => VMSHelper::convert_multi_array($allowed_extensions),
            );

        return View::make('admin.videos.create_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update()
    {
        $input = Input::all();
        $id = $input['id'];
        $video = Video::findOrFail($id);

        $validator = Validator::make($data = $input, Video::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $tags = $data['tags'];
        unset($data['tags']);
        $this->addUpdateVideoTags($video, $tags);

        if(isset($data['duration']) && strlen($data['duration']) > 0){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }
        else {
            unset($data['duration']);
        }




        if(empty($data['image'])){
            unset($data['image']);
        } else {
            $image_name = ImageHandler::uploadImage($data['image'], 'video/'. $video->get_dir_path() . "/thumbs/");

            $data['image'] = $image_name;
        }

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }

        $video->update($data);

        return Redirect::to('admin/videos/edit' . '/' . $id)->with(array('note' => _i('Successfully Updated Video!'), 'note_type' => 'success') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $video = Video::find($id);

        // Detach and delete any unused tags
        foreach($video->tags as $tag){
            $this->detachTagFromVideo($video, $tag->id);
            if(!$this->isTagContainedInAnyVideos($tag->name)){
                $tag->delete();
            }
        }

        $this->deleteVideoImages($video);
        Video::destroy($id);
        return Redirect::to('admin/videos')->with(array('note' => _i('Successfully Deleted Video'), 'note_type' => 'success') );
    }

    private function addUpdateVideoTags($video, $tags){
        $tags = array_map('trim', explode(',', $tags));
        foreach($tags as $tag) {
            if($tag != '') {
                $tag_id = $this->addTag($tag);
                $this->attachTagToVideo($video, $tag_id);
            }
        }

        // Remove any tags that were removed from video
        foreach($video->tags as $tag){
            if(!in_array($tag->name, $tags)){
                $this->detachTagFromVideo($video, $tag->id);
                if(!$this->isTagContainedInAnyVideos($tag->name)){
                    $tag->delete();
                }
            }
        }
    }

    /**************************************************
    /*
    /*  PRIVATE FUNCTION
    /*  addTag( tag_name )
    /*
    /*  ADD NEW TAG if Tag does not exist
    /*  returns tag id
    /*
    /**************************************************/

    private function addTag($tag){
        $tag_exists = Tag::where('name', '=', $tag)->first();
            
        if($tag_exists){ 
            return $tag_exists->id; 
        } else {
            $new_tag = new Tag;
            $new_tag->name = strtolower($tag);
            $new_tag->save();
            return $new_tag->id;
        }
    }

    /**************************************************
    /*
    /*  PRIVATE FUNCTION
    /*  attachTagToVideo( video object, tag id )
    /*
    /*  Attach a Tag to a Video
    /*
    /**************************************************/

    private function attachTagToVideo($video, $tag_id){
        // Add New Tags to video
        if (!$video->tags->contains($tag_id)) {
            $video->tags()->attach($tag_id);
        }
    }

    private function detachTagFromVideo($video, $tag_id){
        // Detach the pivot table
        $video->tags()->detach($tag_id);
    }

    public function isTagContainedInAnyVideos($tag_name){
        // Check if a tag is associated with any videos
        $tag = Tag::where('name', '=', $tag_name)->first();
        return (!empty($tag) && $tag->videos->count() > 0) ? true : false;
    }

    private function deleteVideoImages($video){
        $ext = pathinfo($video->image, PATHINFO_EXTENSION);
        if(file_exists(Config::get('site.uploads_dir') . 'images/' . $video->image) && $video->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . $video->image);
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $video->image) )  && $video->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $video->image) );
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $video->image) )  && $video->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $video->image) );
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $video->image) )  && $video->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $video->image) );
        }
    }

    public function thumb_update() {
        $input = Input::all();
        $id = $input['id'];

        $video = Video::findOrFail($id);
        $video->image = $input['thumb'];

        $upload_folder = 'content/uploads/video/' . $video->get_dir_path() . "/thumbs/";

        $filename = basename($input['thumb']);

        $img = Image::make($upload_folder . $filename);
        //$img->resize(1280, 720);
        $settings = Setting::first();
        $theme_config = ThemeHelper::get_theme_config($settings->theme);


        foreach($theme_config['image'] as $destination => $dimensions) {
            if(strpos('video', $destination) === 0) {
                foreach($dimensions as $dimension_key => $dimension) {
                    $img->resize($dimension['width'], $dimension['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($upload_folder . pathinfo($filename, PATHINFO_FILENAME) . "-" . $dimension_key . '.' . pathinfo($filename, PATHINFO_EXTENSION));
                }
            }
        }

//        Image::make($upload_folder . $filename)->resize(960, null, function ($constraint) {
//            $constraint->aspectRatio();
//        })->save($upload_folder . pathinfo($filename, PATHINFO_FILENAME) . '-large.' . pathinfo($filename, PATHINFO_EXTENSION));
//
//        Image::make($upload_folder . $filename)->resize(640, null, function ($constraint) {
//            $constraint->aspectRatio();
//        })->save($upload_folder . pathinfo($filename, PATHINFO_FILENAME) . '-medium.' . pathinfo($filename, PATHINFO_EXTENSION));
//
//        Image::make($upload_folder . $filename)->resize(320, null, function ($constraint) {
//            $constraint->aspectRatio();
//        })->save($upload_folder . pathinfo($filename, PATHINFO_FILENAME) . '-small.' . pathinfo($filename, PATHINFO_EXTENSION));

        $video->save();
        return;

    }

}