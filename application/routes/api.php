<?php
Route::group(['prefix' => 'api/v1', 'namespace' => 'App\Api\Controllers'], function () {
    Route::resource('users', 'UserController');
    Route::resource('videos', 'VideoController');
    Route::resource('video_categories', 'VideoCategoryController');
    Route::resource('tags', 'TagController');
    Route::resource('video_tags', 'VideoTagController');
    Route::resource('comments', 'CommentController');
    Route::resource('favorites', 'FavoriteController');
});
