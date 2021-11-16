<?php

Route::get('blog-list', 'Api\V1\Admin\NewsApiController@list');


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // News
    Route::post('news/media', 'NewsApiController@storeMedia')->name('news.storeMedia');
    Route::apiResource('news', 'NewsApiController');

    // Push Notification
    Route::apiResource('push-notifications', 'PushNotificationApiController');

    // Category
    Route::apiResource('categories', 'CategoryApiController');
});
