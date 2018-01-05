<?php

/*
|--------------------------------------------------------------------------
| Backpack\Meta Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\Meta package.
|
*/

Route::group([
  'namespace' => 'AbbyJanke\BackpackMeta\app\Http\Controllers\Admin',
  'prefix' => config('backpack.base.route_prefix', 'admin'),
  'middleware' => ['web', 'admin'],
], function () {
  \CRUD::resource('meta', 'MetaCrudController');
});
