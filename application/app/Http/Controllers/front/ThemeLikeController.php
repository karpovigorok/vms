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

//namespace App\Http\Controllers;

class ThemeLikeController extends \BaseController
{
    public function __construct()
    {
        $this->middleware('secure');
        parent::__construct();
    }


    // Add article Like
    public function like(){

        if(Auth::check()) {
            $article_id = Input::get('article_id');
            $article_type = Input::get('article_type');
            $article = $article_type::find($article_id);
            if($article->isLikedBy()) {
                $article->unlikeBy();
            }
            else {
                $article->likeBy();
            }
            return Response::json([
                'id' => $article->id,
                'likesCount' => $article->likesCount,
                'dislikesCount' => $article->dislikesCount,
            ], 200); // Status code here
        }
        else {
            return Response::json([], 401); // Status code here
        }


    }

    public function dislike() {
        if(Auth::check()) {
            $article_id = Input::get('article_id');
            $article_type = Input::get('article_type');
            $article = $article_type::find($article_id);
            if($article->isDislikedBy()) {
                $article->undislikeBy();
            }
            else {
                $article->dislikeBy();
            }
            return Response::json([
                'id' => $article->id,
                'likesCount' => $article->likesCount,
                'dislikesCount' => $article->dislikesCount,
            ], 200); // Status code here
        }
        else {
            return Response::json([], 401); // Status code here
        }
    }
}
