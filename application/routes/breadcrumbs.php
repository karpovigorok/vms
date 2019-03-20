<?php
//use DaveJamesMiller\Breadcrumbs as Breadcrumbs;
// Home

Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});
//// Home > Videos
//Breadcrumbs::register('videos', function ($breadcrumbs) {
//    $breadcrumbs->parent('home');
//    $breadcrumbs->push('Videos', route('videos'));
//});


Breadcrumbs::register('videos', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Videos', route('videos'));

});
Breadcrumbs::register('favorites', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Favorites', route('favorites'));

});
Breadcrumbs::register('signup', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Create Account', route('signup'));
});
Breadcrumbs::register('login', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Login', route('login'));
});
Breadcrumbs::register('password.remind', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Password Reset', route('login'));
});

Breadcrumbs::register('password.reset', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Password Reset', route('login'));
});

Breadcrumbs::register('posts', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Posts', route('posts'));
});
Breadcrumbs::register('search', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Search results', route('search'));
});
Breadcrumbs::register('pages', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pages', route('pages'));
});

// Home > Videos > [Category] > [Video]
Breadcrumbs::register('video', function ($breadcrumbs, $id) {
    $video = App\Models\Video::find($id);
    if(!is_null($video)) {
        if(!is_null($video->category)) {
            $breadcrumbs->parent('category', $video->category->slug);
        }
        else {
            $breadcrumbs->parent('videos');
        }
        $breadcrumbs->push($video->title, route('video', $video));
    }
});


// Home > [Post]
Breadcrumbs::register('post', function ($trail, $slug) {
    $post = \App\Models\Post::where('slug', '=', $slug)->first();
    $trail->parent('posts');
    $trail->push($post->title, route('post', $post));
});
// Home > [Page]
Breadcrumbs::register('page', function ($trail, $slug) {
    $page = \App\Models\Page::where('slug', '=', $slug)->first();
    $trail->parent('pages');
    $trail->push($page->title, route('page', $page));
});
// Home > [Category]
Breadcrumbs::register('category', function ($trail, $slug) {
    $cat = \App\Models\VideoCategory::where('slug', '=', $slug)->first();
    if(!is_null($cat)) {
        $trail->parent('videos');
        $trail->push($cat->name, url('videos/category/' . $cat->slug));
    }
});
// Home > [Post Category]
Breadcrumbs::register('post-category', function ($trail, $slug) {
    $cat = \App\Models\PostCategory::where('slug', '=', $slug)->first();
    if(!is_null($cat)) {
        //$parent_cat = VideoCategory::where('parent_id', '=', $cat->id)->first();
        $trail->parent('posts');
        $trail->push($cat->name, route('post-category', $cat));
    }
});

// Home > [Tag]
Breadcrumbs::register('tag', function ($trail, $tag) {
    $tag = App\Models\Tag::where('name', '=', $tag)->first();
    if(!is_null($tag)) {
        $trail->parent('videos');
        $trail->push($tag->name, route('tag', $tag));
    }
});
// Home > [User]
Breadcrumbs::register('user', function ($trail, $username) {
    $user = App\User::where('username', '=', $username)->first();
    $trail->parent('home');
    $trail->push($user->username, route('user', $user));
});// Home > [User]

//Breadcrumbs::register('user-videos', function ($trail) {
//    //$user = App\User::where('username', '=', $username)->first();
//
//    $trail->parent('home');
//    $trail->push('Videos', route('user-videos'));
//});
Breadcrumbs::register('user-favorite', function ($breadcrumbs, $username) {
    $user = App\User::where('username', '=', $username)->first();
    $breadcrumbs->parent('user', $user->username);
    $breadcrumbs->push('Favorite Videos', route('user-favorite', $user));
});
Breadcrumbs::register('user-comments', function ($breadcrumbs, $username) {
    $user = App\User::where('username', '=', $username)->first();
    $breadcrumbs->parent('user', $user->username);
    $breadcrumbs->push('Comments', route('user-comments', $user));
});
Breadcrumbs::register('user-edit', function ($breadcrumbs, $username) {
    $user = App\User::where('username', '=', $username)->first();
    $breadcrumbs->parent('user', $user->username);
    $breadcrumbs->push('Settings', route('user-edit', $user));
});
Breadcrumbs::register('user-upgrade-subscription', function ($breadcrumbs, $username) {
    $user = App\User::where('username', '=', $username)->first();
    $breadcrumbs->parent('user', $user->username);
    $breadcrumbs->push('Upgrade Subscription', route('user-upgrade-subscription', $user));
});
Breadcrumbs::register('user-billing', function ($breadcrumbs, $username) {
    $user = App\User::where('username', '=', $username)->first();
    $breadcrumbs->parent('user', $user->username);
    $breadcrumbs->push('Billing', route('user-billing', $user));
});
Breadcrumbs::register('user-renew-subscription', function ($breadcrumbs, $username) {
    $user = App\User::where('username', '=', $username)->first();
    $breadcrumbs->parent('user', $user->username);
    $breadcrumbs->push('Billing', route('user-renew-subscription', $user));
});

// Error 404
Breadcrumbs::register('errors.404', function ($trail) {
    $trail->parent('home');
    $trail->push('Page Not Found');
});