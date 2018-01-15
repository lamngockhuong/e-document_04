<?php

namespace App\Http\Controllers\Outside;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display public index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('e-document.index');
    }
}
