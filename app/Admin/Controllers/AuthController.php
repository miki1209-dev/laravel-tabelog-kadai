<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseAuthController
{
	public function getLogout(\Illuminate\Http\Request $request)
	{
		Auth::guard('admin')->logout();
		return redirect(config('admin.auth.redirect_to'));
	}
}
