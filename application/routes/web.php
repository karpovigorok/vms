<?php
Route::middleware(['mustBeSubscribed'])->group(function () {

//Route::group(array('before' => 'if_logged_in_must_be_subscribed'), function () {

    /*
    |--------------------------------------------------------------------------
    | Home Page Routes
    |--------------------------------------------------------------------------
    */

    Route::name('home')->get('/', 'ThemeHomeController@index');

    /*
     *
     * Comments Route
     *
     */
    Route::resource('comment', 'ThemeCommentController');

    /*
    |--------------------------------------------------------------------------
    | Video Page Routes
    |--------------------------------------------------------------------------
    */

    Route::name('videos')->get('videos', array('uses' => 'ThemeVideoController@videos', 'as' => 'videos'));
    Route::name('category')->get('videos/category/{category}', 'ThemeVideoController@category');
    Route::name('tag')->get('videos/tag/{tag}', 'ThemeVideoController@tag');
    Route::name('video')->get('video/{id}', 'ThemeVideoController@index');



    /*
    |--------------------------------------------------------------------------
    | Post Page Routes
    |--------------------------------------------------------------------------
    */

    Route::name('posts')->get('posts', array('uses' => 'ThemePostController@posts', 'as' => 'posts'));
    Route::name('post-category')->get('posts/category/{category}', 'ThemePostController@category');
    Route::name('post')->get('post/{slug}', 'ThemePostController@index');


    /*
    |--------------------------------------------------------------------------
    | Page Routes
    |--------------------------------------------------------------------------
    */

    Route::name('pages')->get('pages', 'ThemePageController@pages');
    Route::name('page')->get('page/{slug}', 'ThemePageController@index');


    /*
    |--------------------------------------------------------------------------
    | Search Routes
    |--------------------------------------------------------------------------
    */

    Route::name('search')->get('search', 'ThemeSearchController@index');

    /*
    |--------------------------------------------------------------------------
    | Auth and Password Reset Routes
    |--------------------------------------------------------------------------
    */

    Route::name('login')->get('login', 'ThemeAuthController@login_form');
    Route::name('signup')->get('signup', 'ThemeAuthController@signup_form');
    Route::post('login', 'ThemeAuthController@login');
    Route::post('signup', 'ThemeAuthController@signup');

    Route::name('password.remind')->get('password/reset', array('before' => 'demo', 'uses' => 'ThemeAuthController@password_reset', 'as' => 'password.remind'));
    Route::post('password/reset', array('before' => 'demo', 'uses' => 'ThemeAuthController@password_request', 'as' => 'password.request'));
    Route::name('password-reset')->get('password/reset/{token}', array('before' => 'demo', 'uses' => 'ThemeAuthController@password_reset_token', 'as' => 'password.reset'));
    Route::post('password/reset/{token}', array('before' => 'demo', 'uses' => 'ThemeAuthController@password_reset_post', 'as' => 'password.update'));

    Route::get('verify/{activation_code}', 'ThemeAuthController@verify');

    /*
    |--------------------------------------------------------------------------
    | User and User Edit Routes
    |--------------------------------------------------------------------------
    */

    Route::name('user')->get('user/{username}', 'ThemeUserController@favorite');
    Route::name('user-favorite')->get('user/{username}/favorite', 'ThemeUserController@favorite');
    Route::name('user-comments')->get('user/{username}/comments', 'ThemeUserController@comments');
    Route::name('user-edit')->get('user/{username}/edit', 'ThemeUserController@edit');
    Route::post('user/{username}/update', array('before' => 'demo', 'uses' => 'ThemeUserController@update'));
    Route::name('user-billing')->get('user/{username}/billing', array('before' => 'demo', 'uses' => 'ThemeUserController@billing'));
    Route::name('user-cancel')->get('user/{username}/cancel', array('before' => 'demo', 'uses' => 'ThemeUserController@cancel_account'));
    Route::name('user-resume')->get('user/{username}/resume', array('before' => 'demo', 'uses' => 'ThemeUserController@resume_account'));
    Route::name('user-update_cc')->get('user/{username}/update_cc', 'ThemeUserController@update_cc');

}); // End if_logged_in_must_be_subscribed route

Route::middleware(['auth'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Favorite Routes
    |--------------------------------------------------------------------------
    */

    Route::post('favorite', 'ThemeFavoriteController@favorite');
    Route::name('favorites')->get('favorites', 'ThemeFavoriteController@show_favorites');

    /*
    |--------------------------------------------------------------------------
    | Like Routes
    |--------------------------------------------------------------------------
    */
    Route::post('like', 'ThemeLikeController@like');
    Route::post('dislike', 'ThemeLikeController@dislike');

});



Route::name('user-renew-subscription')->get('user/{username}/renew_subscription', 'ThemeUserController@renew');
Route::post('user/{username}/update_cc', array('before' => 'demo', 'uses' => 'ThemeUserController@update_cc_store'));

Route::name('user-upgrade-subscription')->get('user/{username}/upgrade_subscription', 'ThemeUserController@upgrade');
Route::post('user/{username}/upgrade_cc', array('before' => 'demo', 'uses' => 'ThemeUserController@upgrade_cc_store'));

Route::get('logout', 'ThemeAuthController@logout');

Route::get('upload_dir', function () {
    echo Config::get('site.uploads_dir');
});

Route::post('upload-advanced', 'UploadController@upload');
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'isAdmin'])->group(function () {

//Route::group(array('before' => 'admin'), function () {

    Route::name('upgrade')->get('upgrade', 'UpgradeController@upgrade');

    // Admin Dashboard
    Route::get('admin', 'AdminController@index');

    // Admin SEO functionality
    Route::get('admin/{type}/seo/{id}', 'AdminSeoController@edit');
    Route::post('admin/{type}/seo/store', array('before' => 'demo', 'uses' => 'AdminSeoController@store'));

    // Admin Video Functionality
    Route::get('admin/videos', 'AdminVideosController@index');
    Route::get('admin/videos/edit/{id}', 'AdminVideosController@edit');
    Route::post('admin/videos/update', array('before' => 'demo', 'uses' => 'AdminVideosController@update'));
    Route::post('admin/videos/thumb_update', array('before' => 'demo', 'uses' => 'AdminVideosController@thumb_update'));
    Route::get('admin/videos/delete/{id}', array('before' => 'demo', 'uses' => 'AdminVideosController@destroy'));
    Route::get('admin/videos/create', 'AdminVideosController@create');
    Route::post('admin/videos/store', array('before' => 'demo', 'uses' => 'AdminVideosController@store'));
    Route::get('admin/videos/categories', 'AdminVideoCategoriesController@index');
    Route::post('admin/videos/categories/store', array('before' => 'demo', 'uses' => 'AdminVideoCategoriesController@store'));
    Route::post('admin/videos/categories/order', array('before' => 'demo', 'uses' => 'AdminVideoCategoriesController@order'));
    Route::get('admin/videos/categories/edit/{id}', 'AdminVideoCategoriesController@edit');
    Route::post('admin/videos/categories/update', array('before' => 'demo', 'uses' => 'AdminVideoCategoriesController@update'));
    Route::get('admin/videos/categories/delete/{id}', array('before' => 'demo', 'uses' => 'AdminVideoCategoriesController@destroy'));

    // Admin Comments
    Route::get('admin/comments', 'AdminCommentsController@index');
    Route::get('admin/comments/delete/{id}', array('before' => 'demo', 'uses' => 'AdminCommentsController@destroy'));

    //Admin Widgets
    Route::get('admin/widgets_settings', 'AdminWidgetsSettingsController@index');


    Route::get('admin/posts', 'AdminPostController@index');
    Route::get('admin/posts/create', 'AdminPostController@create');
    Route::post('admin/posts/store', array('before' => 'demo', 'uses' => 'AdminPostController@store'));
    Route::get('admin/posts/edit/{id}', 'AdminPostController@edit');
    Route::post('admin/posts/update', array('before' => 'demo', 'uses' => 'AdminPostController@update'));
    Route::get('admin/posts/delete/{id}', array('before' => 'demo', 'uses' => 'AdminPostController@destroy'));
    Route::get('admin/posts/categories', 'AdminPostCategoriesController@index');
    Route::post('admin/posts/categories/store', array('before' => 'demo', 'uses' => 'AdminPostCategoriesController@store'));
    Route::post('admin/posts/categories/order', array('before' => 'demo', 'uses' => 'AdminPostCategoriesController@order'));
    Route::get('admin/posts/categories/edit/{id}', 'AdminPostCategoriesController@edit');
    Route::get('admin/posts/categories/delete/{id}', array('before' => 'demo', 'uses' => 'AdminPostCategoriesController@destroy'));
    Route::post('admin/posts/categories/update', array('before' => 'demo', 'uses' => 'AdminPostCategoriesController@update'));

    Route::get('admin/media', 'AdminMediaController@index');
    Route::post('admin/media/files', 'AdminMediaController@files');
    Route::post('admin/media/new_folder', 'AdminMediaController@new_folder');
    Route::post('admin/media/delete_file_folder', 'AdminMediaController@delete_file_folder');
    Route::get('admin/media/directories', 'AdminMediaController@get_all_dirs');
    Route::post('admin/media/move_file', 'AdminMediaController@move_file');
    Route::post('admin/media/upload', 'AdminMediaController@upload');
//    Route::get('file_upload', function () {
//        echo phpinfo();
//    });

    Route::get('admin/pages', 'AdminPageController@index');
    Route::get('admin/pages/create', 'AdminPageController@create');
    Route::post('admin/pages/store', array('before' => 'demo', 'uses' => 'AdminPageController@store'));
    Route::get('admin/pages/edit/{id}', 'AdminPageController@edit');
    Route::post('admin/pages/update', array('before' => 'demo', 'uses' => 'AdminPageController@update'));
    Route::get('admin/pages/delete/{id}', array('before' => 'demo', 'uses' => 'AdminPageController@destroy'));


    Route::get('admin/users', 'AdminUsersController@index');
    Route::get('admin/user/create', 'AdminUsersController@create');
    Route::post('admin/user/store', array('before' => 'demo', 'uses' => 'AdminUsersController@store'));
    Route::get('admin/user/edit/{id}', 'AdminUsersController@edit');
    Route::post('admin/user/update', array('before' => 'demo', 'uses' => 'AdminUsersController@update'));
    Route::get('admin/user/delete/{id}', array('before' => 'demo', 'uses' => 'AdminUsersController@destroy'));

    Route::get('admin/menu', 'AdminMenuController@index');
    Route::post('admin/menu/store', array('before' => 'demo', 'uses' => 'AdminMenuController@store'));
    Route::get('admin/menu/edit/{id}', 'AdminMenuController@edit');
    Route::post('admin/menu/update', array('before' => 'demo', 'uses' => 'AdminMenuController@update'));
    Route::post('admin/menu/order', array('before' => 'demo', 'uses' => 'AdminMenuController@order'));
    Route::get('admin/menu/delete/{id}', array('before' => 'demo', 'uses' => 'AdminMenuController@destroy'));

    Route::get('admin/plugins', 'AdminPluginsController@index');
    Route::get('admin/plugin/deactivate/{plugin_name}', 'AdminPluginsController@deactivate');
    Route::get('admin/plugin/activate/{plugin_name}', 'AdminPluginsController@activate');

    Route::get('admin/themes', 'AdminThemesController@index');
    Route::get('admin/theme/activate/{slug}', array('before' => 'demo', 'uses' => 'AdminThemesController@activate'));

    Route::get('admin/settings', 'AdminSettingsController@index');
    Route::post('admin/settings', array('before' => 'demo', 'uses' => 'AdminSettingsController@save_settings'));

    Route::get('admin/payment_settings', 'AdminPaymentSettingsController@index');
    Route::post('admin/payment_settings', array('before' => 'demo', 'uses' => 'AdminPaymentSettingsController@save_payment_settings'));

    Route::get('admin/theme_settings_form', 'AdminThemeSettingsController@theme_settings_form');
    Route::get('admin/theme_settings', 'AdminThemeSettingsController@theme_settings');
    Route::post('admin/theme_settings', array('before' => 'demo', 'uses' => 'AdminThemeSettingsController@update_theme_settings'));
    Route::get('admin/theme_settings/delete/logo', array('before' => 'demo', 'uses' => 'AdminThemeSettingsController@delete_logo'));
    Route::get('admin/theme_settings/delete/favicon', array('before' => 'demo', 'uses' => 'AdminThemeSettingsController@delete_favicon'));
});

/*
|--------------------------------------------------------------------------
| Payment Webhooks
|--------------------------------------------------------------------------
*/

Route::post('stripe/webhook', 'Laravel\Cashier\WebhookController@handleWebhook');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


Route::group(array('prefix' => 'api/v1'), function () {
    Route::get('/', 'Api\v1\ApiController@index');

    Route::get('videos', 'Api\v1\VideoController@index');
    Route::get('video/{id}', 'Api\v1\VideoController@video');
    Route::get('video_categories', 'Api\v1\VideoController@video_categories');
    Route::get('video_category/{id}', 'Api\v1\VideoController@video_category');
    Route::get('video_file_status/{id}', 'Api\v1\VideoController@video_file_status');
    Route::get('generate_thumbs/{id}', 'Api\v1\VideoController@generate_thumbs');

    Route::get('posts', 'Api\v1\PostController@index');
    Route::get('post/{id}', 'Api\v1\PostController@post');
    Route::get('post_categories', 'Api\v1\PostController@post_categories');
    Route::get('post_category/{id}', 'Api\v1\PostController@post_category');
});


