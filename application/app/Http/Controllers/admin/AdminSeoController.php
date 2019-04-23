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
use \Redirect as Redirect;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\Post;
use App\Libraries\ThemeHelper;

class AdminSeoController extends \AdminBaseController
{

    public function edit($article_type, $article_id)
    {
        $settings = ThemeHelper::getSystemSettings();
        $user = Auth::user();

        //dd($article_id);

        switch ($article_type) {
            case 'videos':
                $article = Video::find($article_id);
                $seoble_article_title = $article->title;
                break;
            case 'video-categories':
                $article = VideoCategory::find($article_id);
                $seoble_article_title = $article->name;
                break;
            case 'posts':
                $article = Post::find($article_id);
                $seoble_article_title = $article->title;
        }
        //dd($article->hasSeo());

        $data = array(
            'settings' => $settings,
            'admin_user' => $user,
            'seoble_article' => $article,
            'post_route' => URL::to('admin/' . $article_type . '/seo/store'),
            'button_text' => _i('Save'),
            'article_type' => $article_type,
            'seoble_article_title' => $seoble_article_title
        );

        return View::make('admin.seo.edit', $data);
    }

    public function store() {
        $input = Input::all();
        $id = $input['id'];

        switch ($input['article_type']) {
            case 'videos':
                $article = Video::find($id);
                break;
            case 'video-categories':
                $article = VideoCategory::find($id);
                break;
            case 'posts':
                $article = Post::find($id);
                break;
        }

        $seo_data = $input['seo'];
        //dd($seo_data);
        if(empty($seo_data['noindex'])){
            $seo_data['noindex'] = 0;
        }

        if(trim($seo_data['keywords']) != '') {
            $seo_data['keywords'] = array_map('trim', explode(',', $seo_data['keywords']));
        }
        else {
            $seo_data['keywords'] = null;
        }
//        if(isset($seo_data['extras'])) {
//            if($seo_data['extras'] != '') {
//                $seo_data['extras'] = array_map('trim', explode(',', $seo_data['extras']));
//            }
//        }
        //dd($seo_data);

        if(!$article->hasSeo()) {
            $article->createSeo($seo_data);
        }
        else {
            $article->updateSeo($seo_data
//            [
//                'title' => $seo_data['title'],
//                'description' => $seo_data,
//                'keywords' => ['test keyword'],
//                'noindex' => false,
//                'extras' => ['test_key' => 'test_val']
//            ]
            );
        }
        return Redirect::to('admin/' . $input['article_type'] . '/seo' . '/' . $id)->with(array('note' => _i('Successfully Updated SEO Meta!'), 'note_type' => 'success') );

    }
}