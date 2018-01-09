<?php

namespace App\Http\Controllers\Admin;

use App\Models\Document;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('admin.document.index.title');
        $documents = Document::with([
            'user',
            'termTaxonomys' => function ($query) {
                $query->with('term')->where('taxonomy', config('setting.category.taxonomy'));
            },
        ])->orderBy('id', 'DESC')->paginate(config('setting.pagination.number_per_page'));

        return view('admin.document.index', compact('title', 'documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
            $document = Document::findOrFail($id);

            DB::beginTransaction();

            $document->termTaxonomys()->detach();
            $document->delete();

            DB::commit();
            $message = trans('admin.document.message.delete-success');
            $notification = [
                'message' => $message,
                'alert-type' => 'success',
            ];

            return redirect()->route('documents.index')->with($notification);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
        } catch (QueryException $e) {
            DB::rollBack();
        }
        $message = trans('admin.tag.message.delete-error');
        $notification = [
            'message' => $message,
            'alert-type' => 'error',
        ];

        return redirect()->route('documents.index')->with($notification);
    }
}
