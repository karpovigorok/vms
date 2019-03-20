<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<?php namespace Api\v1;

use \Controller as Controller;
use \Response as Response;
use \Input as Input;
use \Post as Post;
use \Auth as Auth;
use \Setting as Setting;
use \PostCategory as PostCategory;

class PostController extends Controller {

	private $default_limit = 50;
	private $public_columns = array('id', 'post_category_id', 'title', 'slug', 'image', 'body_guest', 'access', 'created_at', 'updated_at');
	/**
	 * Show all posts.
	 *
	 * @return Json response
	 */
	public function index()
	{
		$response = Post::where('active', '=', 1);

		if(Input::get('offset')){
			$reponse = $response->skip(Input::get('offset'));
		}

		if( Input::get('filter') && Input::get('order') ){
			$response = $response->orderBy(Input::get('filter'), Input::get('order'));
		} else {
			$response = $response->orderBy('created_at', 'desc');
		}

		if(Input::get('limit')){
			$response = $response->take(Input::get('limit'));
		} else {
			$response = $response->take($this->default_limit);
		}

		return Response::json($response->get($this->public_columns), 200);
	}

	public function post($id)
	{
		$settings = Setting::first();
		$post = Post::find($id);
		
		// If user has access to all the content
		if($post->access == 'guest' ||
            ( ($post->access == 'subscriber' || $post->access == 'registered') && !Auth::guest() && Auth::user()->subscribed('main')) ||
            (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) ||
            (!Auth::guest() && $post->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered')
        ){
			$columns = null;
		// Else we need to restrict the columns we return
		} else {
			$columns = $this->public_columns;
		}
		return Response::json(Post::where('id', '=', $id)->get($columns), 200);
	}

	public function post_categories(){
		return Response::json(PostCategory::orderBy('order')->get(), 200);
	}

	public function post_category($id){
		$post_category = PostCategory::find($id);
		return Response::json($post_category, 200);
	}

}
