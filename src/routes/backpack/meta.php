<?php

/*
|--------------------------------------------------------------------------
| Backpack\Blog Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\Blog package.
|
*/

Route::group([
  'namespace' => 'Backpack\Meta\app\Http\Controllers\Admin',
  'prefix' => config('backpack.base.route_prefix', 'admin'),
  'middleware' => ['web', 'admin'],
], function () {
  \CRUD::resource('meta', 'MetaCrudController');
});
