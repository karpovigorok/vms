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

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Post;
use App\Models\Setting;
use App\User;

class ThemeCommentController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(__FUNCTION__);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::all();
        if(Auth::check()) {
            $user = Auth::user();
        }
        elseif(Setting::first()->enable_anonymous_comments) {
            $user = User::find(3); //anonymous user
        }

//        $userid = $user->id;
//        $user = App\User::find($userid);

        if($input['commented_type'] == 'video') {
            $article = Video::find($input['id']);
        }
        elseif($input['commented_type'] == 'post') {
            $article = Post::find($input['id']);
        }
        if(isset($article)) {
            $comment_id = $user->comment($article, $input['commentText'], 3)->id;

            $comment = $article->comments->last();
            if($input['parent_id'] > 0) {
                $comment->fill(['parent_id' => $input['parent_id']]);
            }


//        // approve it -- if you are admin or you don't use mustBeApproved option, it is not necessary
            //$article->comments[0]->approve();


            if($user->id == 3) {

                $comment->fill(['anonymous_username' => $input['commentUsername']]);

            }
            $comment->save();

//        // get avg rating -- it calculates approved average rate.
            $article->averageRate();
        }




//
//        // get total comment count -- it calculates approved comments count.
//        $video->totalCommentCount();
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
