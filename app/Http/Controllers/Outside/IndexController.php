<?php

namespace App\Http\Controllers\Outside;

use App\Models\Document;
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
        $title = trans('e-document.index.title');

        $documents = Document::with([
            'user',
            'termTaxonomys' => function ($query) {
                $query->with('term')->where('taxonomy', config('setting.category.taxonomy'));
            },
        ])->orderBy('id', 'DESC')->paginate(config('setting.public.homepage.number_of_documents'));

        return view('e-document.index', compact('title', 'documents'));
    }
}
