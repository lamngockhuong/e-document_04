<?php

namespace App\Http\Controllers\Outside;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Models\Term;
use App\Models\TermTaxonomy;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status && in_array($request->status, config('setting.document.status')) ?
            $request->status : config('setting.document.status.approved');
        $title = trans('e-document.document.index.title');
        $documents = Document::with([
            'user',
            'termTaxonomys' => function ($query) {
                $query->with('term')->where('taxonomy', config('setting.category.taxonomy'));
            },
        ])
        ->where('document_status', $status)
        ->where('user_id', auth()->user()->id)
        ->orderBy('id', 'DESC')
        ->paginate(config('setting.public.document_management.number_per_page'));
        $documents->appends(request()->only(['status']));

        $approvedCount = Document::ofStatus(config('setting.document.status.approved'))->count();
        $unapprovedCount = Document::ofStatus(config('setting.document.status.unapproved'))->count();
        $incompleteCount = Document::ofStatus(config('setting.document.status.incomplete'))->count();

        return view('e-document.document.index',
            compact('title', 'documents', 'status', 'approvedCount', 'unapprovedCount', 'incompleteCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('e-document.document.create.title');

        return view('e-document.document.create', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $document = Document::where('user_id', auth()->user()->id)->findOrFail($id);
            $title = $document->title;

            // get category
            $subCategory = $this->getCategory($document);
            $category = config('setting.term_taxonomy_default.parent');
            if ($subCategory) {
                $category = $subCategory->parent ? $subCategory->parent : config('setting.term_taxonomy_default.parent');
                $category = $category ? $category : $subCategory->id;
                $subCategory = $category != $subCategory->id ? $subCategory->id : config('setting.term_taxonomy_default.parent');
            }

            // load parent categories
            $categories = $this->getCategories();
            $subCategories = $this->getSubCategoriesArray($category);

            return view('e-document.document.edit', compact('title','document', 'category', 'subCategory', 'categories', 'subCategories'));
        } catch (\Exception $e) {
            return redirect()->route('document-manager.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DocumentRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $document = Document::findOrFail($id);

            if ($document->user_id != auth()->user()->id) {
                return response()->json([
                    'status' => config('setting.status.error'),
                    'message' => trans('e-document.document.edit.message.unauthorized'),
                ], 400);
            }

            $inputs = $request->only('title', 'description', 'coin');
            $categoryId = $request->category;
            $subCategoryId = $request->subcategory;

            $categoryId = $subCategoryId <= config('setting.term_taxonomy_default.parent') ? $categoryId : $subCategoryId;

            // check exists term with parent id
            $category = Term::findOrFail($categoryId);

            $document->document_status = $document->document_status == config('setting.document.status.incomplete') ?
                config('setting.document.status.unapproved') : $document->document_status;
            $document->termTaxonomys()->sync($category);
            $document->update($inputs);

            DB::commit();

            return response()->json([
                'status' => config('setting.status.success'),
                'message' => trans('e-document.document.edit.message.success'),
            ], 200);
        } catch (QueryException $e) {
            DB::rollBack();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return response()->json([
            'status' => config('setting.status.error'),
            'message' => trans('e-document.document.edit.message.error'),
        ], 400);
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
            $document = Document::where('user_id', auth()->user()->id)->findOrFail($id);
            DB::beginTransaction();

            File::removeFile($document->file_real_path);

            $document->termTaxonomys()->detach();
            $document->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->back();
    }

    public function upload(Request $request)
    {
        // check login
        if (auth()->guest()) {
            return response()->json([
                'status' => config('setting.status.error'),
                'message' => trans('e-document.document.create.message.guest'),
            ], 403);
        }

        try {
            $docObject = $this->uploadProcessor($request);
            $document = new Document;
            $document->user_id = auth()->user()->id;
            $document->title = $docObject->name;
            $document->source = $docObject->fileName;
            $document->document_status = config('setting.document.status.incomplete');
            $document->file_type = $docObject->fileType;
            $document->save();

            // load parent categories
            $categories = $this->getCategories();
            $subCategories = [config('setting.category.none') => trans('admin.category.none')];

            $docObject->id = $document->id;
            $docs[] = $docObject;

            return response()->json([
                'status' => config('setting.status.success'),
                'files' => $docs,
                'html' => view('e-document.render.upload-form', compact('docObject', 'categories', 'subCategories'))->render(),
            ], 200);
        } catch (\Exception $e) {
            // remove file
            Storage::delete($docObject->fileName);
            $docs[] = $docObject;

            return response()->json([
                'status' => config('setting.status.error'),
                'files' => $docs,
                'message' => $e->getMessage(),
            ], 403);
        }
    }

    public function save(DocumentRequest $request, $id)
    {
        // check login
        if (auth()->guest()) {
            return response()->json([
                'status' => config('setting.status.error'),
                'message' => trans('e-document.document.create.message.guest'),
            ], 403);
        }

        try {
            DB::beginTransaction();

            $document = Document::findOrFail($id);

            if ($document->user_id != auth()->user()->id) {
                return response()->json([
                    'status' => config('setting.status.error'),
                    'message' => trans('e-document.document.create.message.unauthorized'),
                ], 400);
            }

            $inputs = $request->only('title', 'description', 'coin');
            $categoryId = $request->category;
            $subCategoryId = $request->subcategory;

            $categoryId = $subCategoryId <= config('setting.term_taxonomy_default.parent') ? $categoryId : $subCategoryId;

            // check exists term with parent id
            $category = Term::find($categoryId);
            if (!$category) {
                throw new \Exception();
            }

            $document->document_status = config('setting.document.status.unapproved');
            $document->termTaxonomys()->attach($category);
            $document->update($inputs);

            DB::commit();

            return response()->json([
                'status' => config('setting.status.success'),
                'message' => trans('e-document.document.create.message.success'),
                'html' => view('e-document.render.document-info', compact('document', 'category'))->render(),
            ], 200);
        } catch (QueryException $e) {
            DB::rollBack();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return response()->json([
                'status' => config('setting.status.error'),
                'message' => trans('e-document.document.create.message.error'),
        ], 400);
    }

    private function uploadProcessor(Request $request)
    {
        $fileName = $request->docs->store('docs' . File::mkdirsWithTime(true, false));

        $docObject = new \stdClass();
        $docObject->uid = $request->id;
        $docObject->name = $request->docs->getClientOriginalName();
        $docObject->fileName = $fileName;
        $docObject->fileType = $request->docs->getClientOriginalExtension();
        $docObject->size = $request->docs->getClientSize();

        return $docObject;
    }

    private function getCategory($document)
    {
        return $document->termTaxonomys()->first();
    }

    public function getCategories()
    {
        $items = [config('setting.none') => trans('admin.category.choose')];
        $items += Term::whereHas('termtaxonomy', function ($query) {
            $query->where('taxonomy', 'like', config('setting.category.taxonomy'))
                ->where('parent', '=', config('setting.term_taxonomy_default.parent'));
        })->pluck('name', 'id')->all();

        return $items;
    }

    public function getSubCategories($id)
    {
        $subCategories = [];
        if ($id) {
            $subCategories = Term::subCategories($id)->all();
        }

        return response()->json($subCategories);
    }

    public function getSubCategoriesArray($id)
    {
        $subCategories = [config('setting.category.none') => trans('admin.category.none')];
        if ($id) {
            $terms = Term::subCategories($id)->all();
            foreach ($terms as $term) {
                $subCategories = $subCategories + [$term->id => $term->name];
            }
        }

        return $subCategories;
    }
}
