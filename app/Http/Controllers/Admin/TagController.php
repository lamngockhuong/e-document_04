<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagRequest;
use App\Models\Term;
use App\Models\TermTaxonomy;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('admin.tag.index.title');
        $tags = Term::whereHas('termtaxonomy', function ($query) {
            $query->where('taxonomy', 'like', config('setting.tag.taxonomy'));
        })->with('termtaxonomy')->orderBy('id', 'desc')->paginate(config('setting.pagination.number_per_page'));

        return view('admin.tag.index', compact('title', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin.tag.create.title');

        return view('admin.tag.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        try {
            DB::beginTransaction();

            $inputs = $request->only('name', 'slug');
            $term = Term::create($inputs);
            $term->termTaxonomy()->create([
                'taxonomy' => config('setting.tag.taxonomy'),
                'description' => $request->description,
            ]);

            DB::commit();

            $message = trans('admin.tag.message.create-success');
            $notification = [
                'message' => $message,
                'alert-type' => 'success',
            ];

            return redirect()->route('tags.index')->with($notification);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = trans('admin.tag.message.create-error');
            $notification = [
                'message' => $message,
                'alert-type' => 'error',
            ];

            return redirect()->route('tags.create')->withInput()->with($notification);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = trans('admin.tag.edit.title');
        $term = Term::find($id);

        if ($term) {
            return view('admin.tag.edit', compact('title', 'term'));
        }

        $message = trans('admin.tag.message.show-edit-error');
        $notification = [
            'message' => $message,
            'alert-type' => 'error',
        ];

        return redirect()->route('tags.index')->with($notification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $inputs = $request->only('name', 'slug');
            $term = Term::findOrFail($id);
            $term->update($inputs);
            $term->termTaxonomy()->update([
                'taxonomy' => config('setting.tag.taxonomy'),
                'description' => $request->description,
            ]);

            DB::commit();

            $message = trans('admin.tag.message.edit-success');
            $notification = [
                'message' => $message,
                'alert-type' => 'success',
            ];

            return redirect()->route('tags.index')->with($notification);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = trans('admin.tag.message.edit-error');
            $notification = [
                'message' => $message,
                'alert-type' => 'error',
            ];

            return redirect()->route('tags.edit')->withInput()->with($notification);
        }
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
            $term->termtaxonomy()->delete();
            $term->delete();

            DB::commit();
            $message = trans('admin.tag.message.delete-success');
            $notification = [
                'message' => $message,
                'alert-type' => 'success',
            ];
        } catch (QueryException $e) {
            DB::rollBack();
            $message = trans('admin.tag.message.delete-error');
            $notification = [
                'message' => $message,
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('tags.index')->with($notification);
    }
}
