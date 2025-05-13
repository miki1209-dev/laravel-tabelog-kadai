<?php

use Illuminate\Routing\Router;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\ShopController;

Admin::routes();

Route::group([
	'prefix'        => config('admin.route.prefix'),
	'namespace'     => config('admin.route.namespace'),
	'middleware'    => config('admin.route.middleware'),
	'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

	$router->get('/', function () {
		return redirect('/admin/shops');
	});
	$router->resource('categories', CategoryController::class);
	$router->resource('shops', ShopController::class);
});
