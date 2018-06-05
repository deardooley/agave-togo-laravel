<?php

namespace App\Http\Controllers\ToGo\App;

use App\Http\Controllers\Controller;

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
        return view('togo.app.index');
    }
}
