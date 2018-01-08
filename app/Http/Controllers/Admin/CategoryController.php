<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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
        })->with('termtaxonomy')->orderBy('id', 'desc')->paginate(config('setting.pagination.number_per_page'));

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
        $categories = [config('setting.category.none') => trans('admin.category.none')];
        $categories += Term::whereHas('termtaxonomy', function ($query) {
            $query->where('taxonomy', 'like', config('setting.category.taxonomy'))
                ->where('parent', '=', config('setting.term_taxonomy_default.parent'));
        })->pluck('name', 'id')->all();

        return view('admin.category.create', compact('title', 'categories', 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $inputs = $request->only('name', 'slug');

            $parent = $request->category;
            // check exists term with parent id
            if (!Term::find($parent)) {
                throw new \Exception();
            }

            $term = Term::create($inputs);
            $term->termTaxonomy()->create([
                'taxonomy' => config('setting.category.taxonomy'),
                'description' => $request->description,
                'parent' => $parent,
            ]);

            DB::commit();

            $message = trans('admin.category.message.create-success');
            $notification = [
                'message' => $message,
                'alert-type' => 'success',
            ];

            return redirect()->route('categories.index')->with($notification);
        } catch (QueryException $e) {
            DB::rollBack();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        $message = trans('admin.category.message.create-error');
        $notification = [
            'message' => $message,
            'alert-type' => 'error',
        ];

        return redirect()->route('categories.create')->withInput()->with($notification);
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
        $title = trans('admin.category.edit.title');
        try {
            $term = Term::findOrFail($id);
            $categories = [config('setting.category.none') => trans('admin.category.none')];
            $categories += Term::whereHas('termtaxonomy', function ($query) {
                $query->where('taxonomy', 'like', config('setting.category.taxonomy'))
                    ->where('parent', '=', config('setting.term_taxonomy_default.parent'));
            })->pluck('name', 'id')->all();

            return view('admin.category.edit', compact('title', 'term', 'categories', 'subCategories'));
        } catch (QueryException $e) {
            $message = trans('admin.category.message.show-edit-error');
            $notification = [
                'message' => $message,
                'alert-type' => 'error',
            ];

            return redirect()->route('categories.index')->with($notification);
        }
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
        try {
            DB::beginTransaction();

            $term = Term::findOrFail($id);
            $inputs = $request->only('name', 'slug');
            $parent = $request->category;
            // check exists term with parent id
            if (!Term::find($parent)) {
                throw new \Exception();
            }
            $term->update($inputs);
            $term->termTaxonomy()->update([
                'taxonomy' => config('setting.category.taxonomy'),
                'description' => $request->description,
                'parent' => $parent,
            ]);

            DB::commit();

            $message = trans('admin.category.message.edit-success');
            $notification = [
                'message' => $message,
                'alert-type' => 'success',
            ];

            return redirect()->route('categories.index')->with($notification);
        } catch (QueryException $e) {
            DB::rollBack();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        $message = trans('admin.category.message.edit-error');
        $notification = [
            'message' => $message,
            'alert-type' => 'error',
        ];

        return redirect()->route('categories.edit')->withInput()->with($notification);
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
            $term->termTaxonomy->children()->update(['parent' => config('setting.term_taxonomy_default.parent')]);
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
}
