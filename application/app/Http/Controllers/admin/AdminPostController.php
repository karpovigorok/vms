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
use App\Models\Post;
use App\Models\Video;
use App\Models\PostCategory;

class AdminPostController extends \AdminBaseController {

    /**
     * Display a listing of videos
     *
     * @return Response
     */
    public function index()
    {

        $search_value = Input::get('s');
        
        if(!empty($search_value)):
            $posts = Post::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(10);
        else:
            $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        endif;

        $user = Auth::user();

        $data = array(
            'posts' => $posts,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View::make('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new video
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'post_route' => URL::to('admin/posts/store'),
            'button_text' => 'Add New Post',
            'admin_user' => Auth::user(),
            'post_categories' => PostCategory::all(),
            );
        return View::make('admin.posts.create_edit', $data);
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

        $image = (isset($data['image'])) ? $data['image'] : '';
        if(!empty($image)){
            $data['image'] = ImageHandler::uploadImage($data['image'], 'images');
        } else {
            $data['image'] = '/application/assets/img/blur-background/2.jpg';
        }

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        $post = Post::create($data);

        return Redirect::to('admin/posts')->with(array('note' => _i('New Post Successfully Added!'), 'note_type' => 'success') );
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> ' . _i('Edit Post'),
            'post' => $post,
            'post_route' => URL::to('admin/posts/update'),
            'button_text' => _i('Update Post'),
            'admin_user' => Auth::user(),
            'post_categories' => PostCategory::all(),
            );

        return View::make('admin.posts.create_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update()
    {
        $data = Input::all();
        $id = $data['id'];
        $post = Post::findOrFail($id);

        $validator = Validator::make($data, Post::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if(empty($data['image'])){
            unset($data['image']);
        } else {
            $data['image'] = ImageHandler::uploadImage($data['image'], 'images');
        }

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        $post->update($data);

        return Redirect::to('admin/posts/edit' . '/' . $id)->with(array('note' => _i('Successfully Updated Post!'), 'note_type' => 'success') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $this->deletePostImages($post);

        Post::destroy($id);

        return Redirect::to('admin/posts')->with(array('note' => _i('Successfully Deleted Post'), 'note_type' => 'success') );
    }

    private function deletePostImages($post){
        $ext = pathinfo($post->image, PATHINFO_EXTENSION);

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . $post->image) && $post->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . $post->image);
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $post->image) ) && $post->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $post->image) );
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $post->image) ) && $post->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $post->image) );
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $post->image) ) && $post->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $post->image) );
        }
    }

}