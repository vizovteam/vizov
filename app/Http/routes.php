<?php


// Pages
Route::get('p/{page}', ['uses' => 'PagesController@page']);

// Board
Route::get('/', ['as' => 'index', 'uses' => 'BoardController@getServices']);
Route::get('uslugi', ['as' => 'services', 'uses' => 'BoardController@getServices']);
Route::get('uslugi/{category}', ['as' => 'show-services', 'uses' => 'BoardController@showServices']);
Route::get('1/{post}/{id}', ['as' => 'show-post-service', 'uses' => 'BoardController@showPostService']);

// Search tools
Route::get('search/posts', ['uses' => 'BoardController@searchPosts']);
Route::get('filter/posts', ['uses' => 'BoardController@filterPosts']);

// Profiles
Route::get('profile/{id}', ['uses' => 'ProfileController@getProfile']);
Route::get('profiles', ['uses' => 'ProfileController@getProfiles']);

// Favorites
Route::get('profiles/add-favorite', ['uses' => 'ProfileController@addFavorite']);
Route::get('profiles/delete-favorite', ['uses' => 'ProfileController@deleteFavorite']);
Route::get('favorites', ['as' => 'get-favorites', 'uses' => 'ProfileController@showMyFavorites']);

// Comment
Route::post('review', ['uses' => 'CommentController@saveReview']);
Route::post('comment', ['uses' => 'CommentController@saveComment']);

// For Authenticated User
Route::group(['middleware' => 'auth'], function() {

	Route::resource('posts', 'PostsController');

	Route::get('my_profile', ['uses' => 'ProfileController@getMyProfile']);
	Route::get('my_profile/edit', ['uses' => 'ProfileController@editMyProfile']);
	Route::post('my_profile/{id}', ['uses' => 'ProfileController@updateMyProfile']);

	Route::get('my_posts', ['uses' => 'ProfileController@getMyPosts']);
	Route::get('my_reviews', ['uses' => 'ProfileController@getMyReviews']);
	Route::get('my_setting', ['uses' => 'ProfileController@getMySetting']);

	Route::post('update_password', ['uses' => 'ProfileController@updatePassword']);
	Route::post('delete_account', ['uses' => 'ProfileController@deleteAccount']);
});

// For Administrator
Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function() {
    Route::resource('users', 'AdminUsersController');
    Route::resource('services', 'AdminServicesController');
    Route::resource('section', 'AdminSectionController');
    Route::resource('categories', 'AdminCategoriesController');
    Route::resource('tags', 'AdminTagsController');
    Route::resource('posts', 'AdminPostsController');
    Route::resource('pages', 'AdminPagesController');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\CustomAuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\CustomAuthController@postRegister');
Route::get('auth/confirm/{token}', 'Auth\CustomAuthController@confirm');

// Repeat confirm
Route::get('auth/repeat_confirm', 'Auth\CustomAuthController@getRepeat');
Route::post('auth/repeat_confirm', 'Auth\CustomAuthController@postRepeat');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
