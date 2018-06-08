<?php

namespace App\Http\Controllers\ToGo\App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController.
 */
class AppController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        app('debugbar')->disable();
        return view('togo.app.index')->withUser(Auth::getUser());
    }
}
