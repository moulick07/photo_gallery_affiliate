<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class Authenticate extends Middleware
{
  /**
   * Get the path the user should be redirected to when they are not authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return string|null
   */
  protected function redirectTo(Request $request)
  {

    if (Auth::user()->isAdmin() == 1) {
      return view('home'); // admin dashboard path
    } elseif(Auth::user()==null) {
      return view('welcomee'); // member dashboard path
    }
  }
}