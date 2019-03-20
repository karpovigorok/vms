<?php 
use App\Models\Post;
use App\Models\Video;
use App\Models\Page;
use App\Models\VideoCategory;
use App\Models\PostCategory;
use App\Models\PluginData;

$sitemap_articles_per_page = PluginData::where('plugin_slug', '=', 'sitemap')->where('key', '=', 'sitemap_$sitemap_articles_per_page')->first();

if(!is_null($sitemap_articles_per_page)) {
    $sitemap_articles_per_page = $sitemap_articles_per_page->value;
}
else {
    $sitemap_articles_per_page = 500;
}
define('ARTICLES_PER_PAGE', $sitemap_articles_per_page);


Route::name('plugin-sitemap-index')->get('sitemap.xml', function() {


    $sitemap = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/><!--?xml version="1.0" encoding="UTF-8"?-->');
    $date = new DateTime();

    $articleSitemap = $sitemap->addChild("sitemap");
    $articleSitemap->addChild("loc", url("sitemap-main.xml"));
    $articleSitemap->addChild("lastmod", $date->format('c'));

    $num_posts = Post::where('active', '=', '1')->count();
    $post_pages = ceil($num_posts / ARTICLES_PER_PAGE);
    for($i = 0; $i < $post_pages; $i++) {
        $articleSitemap = $sitemap->addChild("sitemap");
        $articleSitemap->addChild("loc", url("sitemap-posts-$i.xml"));
        $articleSitemap->addChild("lastmod", $date->format('c'));
    }

    $num_videos = Video::where('active', '=', '1')->count();
    $video_pages = ceil($num_videos / ARTICLES_PER_PAGE);
    for($i = 0; $i < $video_pages; $i++) {
        $articleSitemap = $sitemap->addChild("sitemap");
        $articleSitemap->addChild("loc", url("sitemap-videos-$i.xml"));
        $articleSitemap->addChild("lastmod", $date->format('c'));
    }

    $num_pages = Page::where('active', '=', '1')->count();
    $page_pages = ceil($num_pages / ARTICLES_PER_PAGE);
    for($i = 0; $i < $page_pages; $i++) {
        $articleSitemap = $sitemap->addChild("sitemap");
        $articleSitemap->addChild("loc", url("sitemap-pages-$i.xml"));
        $articleSitemap->addChild("lastmod", $date->format('c'));
    }

    return response($sitemap->asXml())
        ->header('Content-Type', 'application/xml;charset=utf8');
});
/**
 * Generate main links
 */
Route::name('plugin-sitemap-main')->get('sitemap-main.xml', function() {

    $menus = Menu::orderBy('order', 'ASC')->get();

    $sitemap = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/><!--?xml version="1.0" encoding="UTF-8"?-->');
    if($menus->count()) {
        foreach ($menus as $menu) {
            $articleUri = $sitemap->addChild("url");
            $articleUri->addChild("loc", url(($menu->type == 'none' ? '' : $menu->type . "/") . $menu->url));
            $articleUri->addChild("priority", "1");
        }
    }
    $video_categories = VideoCategory::all();
    if($video_categories->count()) {
        foreach ($video_categories as $video_category) {
            $articleUri = $sitemap->addChild("url");
            $articleUri->addChild("loc", url('videos/category/' . $video_category->slug));
            $articleUri->addChild("priority", "1");
        }
    }
    $post_categories = PostCategory::all();
    if($post_categories->count()) {
        foreach ($post_categories as $post_category) {
            $articleUri = $sitemap->addChild("url");
            $articleUri->addChild("loc", url('posts/category/' . $post_category->slug));
            $articleUri->addChild("priority", "1");
        }
    }

    return response($sitemap->asXml())
        ->header('Content-Type', 'application/xml;charset=utf8');
});


/**
 * Generate post sitemap
 */
Route::name('plugin-sitemap-posts')->get('sitemap-posts-{id}.xml', function($id) {
    $sitemap = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/><!--?xml version="1.0" encoding="UTF-8"?-->');
    $posts = Post::where('active', '=', '1')->orderBy('created_at', 'DESC')->skip(ARTICLES_PER_PAGE * $id)->take(ARTICLES_PER_PAGE)->get();
    if($posts->count()) {
        foreach ($posts as $post) {
            $articleUri = $sitemap->addChild("url");
            $articleUri->addChild("loc", url("post/" . $post->slug));
            $date = new DateTime($post->updated_at);
            $articleUri->addChild("lastmod", $date->format('c'));
            $articleUri->addChild("priority", "0.9");
        }
        return response($sitemap->asXml())
            ->header('Content-Type', 'application/xml;charset=utf8');
    }
    else {
        abort(404);
    }
});
/**
 * Generate video sitemap
 */
Route::name('plugin-sitemap-videos')->get('sitemap-videos-{id}.xml', function($id) {
    $sitemap = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/><!--?xml version="1.0" encoding="UTF-8"?-->');
    $videos = Video::where('active', '=', '1')->orderBy('created_at', 'DESC')->skip(ARTICLES_PER_PAGE * $id)->take(ARTICLES_PER_PAGE)->get();
    if($videos->count()) {
        foreach ($videos as $video) {
            $articleUri = $sitemap->addChild("url");
            $articleUri->addChild("loc", url("video/" . $video->id));
            $date = new DateTime($video->updated_at);
            $articleUri->addChild("lastmod", $date->format('c'));
            $articleUri->addChild("priority", "0.8");
        }
        return response($sitemap->asXml())
            ->header('Content-Type', 'application/xml;charset=utf8');
    }
    else {
        abort(404);
    }
});
/**
 * Generate page sitemap
 */
Route::name('plugin-sitemap-pages')->get('sitemap-pages-{id}.xml', function($id) {
    $sitemap = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/><!--?xml version="1.0" encoding="UTF-8"?-->');
    $pages = Page::where('active', '=', '1')->orderBy('created_at', 'DESC')->skip(ARTICLES_PER_PAGE * $id)->take(ARTICLES_PER_PAGE)->get();
    if($pages->count()) {
        foreach ($pages as $page) {
            $articleUri = $sitemap->addChild("url");
            $articleUri->addChild("loc", url("page/" . $page->slug));
            $date = new DateTime($page->updated_at);
            $articleUri->addChild("lastmod", $date->format('c'));
            $articleUri->addChild("priority", "0.7");
        }
        return response($sitemap->asXml())
            ->header('Content-Type', 'application/xml;charset=utf8');
    }
    else {
        abort(404);
    }
});
