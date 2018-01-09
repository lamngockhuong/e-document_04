<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display admin index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('admin.dashboard.title');

        return view('admin.index', compact('title'));
    }
}
