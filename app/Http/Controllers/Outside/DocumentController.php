<?php

namespace App\Http\Controllers\Outside;

use App\Models\Document;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function detail($slug, $id)
    {
        try {
            $document = Document::with([
                'user',
                'termTaxonomys' => function ($query) {
                    $query->with('term')->where('taxonomy', config('setting.category.taxonomy'));
                },
            ])->findOrFail($id);

            if (str_slug($document->title) != $slug) {
                throw new \Exception();
            }

            $title = $document->title;
            $category = $this->getCategory($document);

            return view('e-document.document.detail', compact('title', 'document', 'category'));
        } catch (\Exception $e) {
            return redirect()->route('public.index');
        }
    }

    private function getCategory($document)
    {
        $category = null;
        foreach ($document->termTaxonomys as $termTaxonomy) {
            $category = $termTaxonomy;
        }

        return $category;
    }
}
