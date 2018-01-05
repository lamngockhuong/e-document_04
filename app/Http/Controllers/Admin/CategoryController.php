<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('admin.category.index.title');
        $categories = Term::whereHas('termtaxonomy', function ($query) {
            $query->where('taxonomy', 'like', config('setting.category.taxonomy'));
        })->with('termtaxonomy')->paginate(config('setting.pagination.number_per_page'));

        return view('admin.category.index', compact('title', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin.category.create.title');
        $categories = Term::whereHas('termtaxonomy', function ($query) {
            $query->where('taxonomy', 'like', config('setting.category.taxonomy'))
                ->where('parent', '=', config('setting.term_taxonomy_default.parent'));
        })->pluck('name', 'id');
        $subCategories = [config('setting.category.none') => trans('admin.category.none')];

        return view('admin.category.create', compact('title', 'categories', 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $term = Term::findOrFail($id);
            $term->termTaxonomy()->delete();
            $term->delete();

            DB::commit();
            $message = trans('admin.category.message.delete-success');
            $notification = [
                'message' => $message,
                'alert-type' => 'success',
            ];
        } catch (QueryException $e) {
            DB::rollBack();
            $message = trans('admin.category.message.delete-error');
            $notification = [
                'message' => $message,
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('categories.index')->with($notification);
    }

    public function getSubCategory($id)
    {
        $subCategories = Term::whereHas('termtaxonomy', function ($query) use ($id) {
            $query->where('taxonomy', 'like', config('setting.category.taxonomy'))
                ->where('parent', '=', $id);
        })->get(['name', 'id']);
        
        return response()->json($subCategories);
    }
}
