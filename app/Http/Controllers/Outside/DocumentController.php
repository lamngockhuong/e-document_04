<?php

namespace App\Http\Controllers\Outside;

use App\Models\Document;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;

class DocumentController extends Controller
{
    public function detail($slug, $id)
    {
        try {
            $document = Document::with([
                'user',
                'favorites' => function ($query) {
                    $query->where('user_id', auth()->guest() ? config('setting.user.guest_id') : auth()->user()->id);
                },
                'termTaxonomys' => function ($query) {
                    $query->with('term')->where('taxonomy', config('setting.category.taxonomy'));
                },
            ])->findOrFail($id);

            if (str_slug($document->title) !== $slug) {
                throw new \Exception();
            }

            $title = $document->title;
            $category = $this->getCategory($document);

            return view('e-document.document.detail', compact('title', 'document', 'category'));
        } catch (\Exception $e) {
            return redirect()->route('public.index');
        }
    }

    public function showDownload($token, $id)
    {
        try {
            $document = Document::findOrFail($id);

            $title = $document->title;

            if (session()->pull(config('setting.document.session_download_key') . $id) !== $token) {
                return redirect($document->detail_url);
            }

            return view('e-document.document.download', compact('title', 'document'));
        } catch (\Exception $e) {
            return redirect($document->detail_url);
        }
    }

    public function forceDownload($token, $id)
    {
        try {
            $document = Document::findOrFail($id);

            if (session()->pull(config('setting.document.session_force_download_key') . $id) !== $token) {
                return redirect($document->detail_url);
            }

            $path = $document->file_real_path;
            $name = $document->download_file_name;
            $file = new File($path);
            $headers = [config('setting.content_type') . $file->getMimeType()];

            return response()->download($path, $name, $headers);
        } catch (FileNotFoundException $e) {
            return redirect($document->detail_url);
        } catch (\Exception $e) {
            return redirect($document->detail_url);
        }
    }

    public function checkDownload(Request $request)
    {
        try {
            $document = Document::findOrFail($request->id);

            // generate token
            $token = uniqid();
            $sessionKey = $request->type === config('setting.document.download_type') ? config('setting.document.session_download_key') : config('setting.document.session_force_download_key');
            session([$sessionKey . $request->id => $token]);

            $routeName = $request->type === config('setting.document.download_type') ? 'document.download' : 'document.forceDownload';

            return response()->json([
                'status' => config('setting.status.success'),
                'url' => route($routeName, [
                    'token' => $token,
                    'id' => $document->id,
                ]),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => config('setting.status.error'),
                'message' => trans('e-document.document.download.message.error'),
            ], 400);
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

    public function addToFavorites(Request $request)
    {
        try {
            $document = Document::findOrFail($request->id);

            if ($request->status) {
                Favorite::where('document_id', $document->id)->where('user_id', auth()->user()->id)->delete();
            } else {
                $favorite = Favorite::create([
                    'user_id' => auth()->user()->id,
                    'document_id' => $document->id,
                ]);
                $document->favorites()->save($favorite);
            }

            return response()->json([
                'status' => config('setting.status.success'),
                'message' => trans('e-document.document.detail.message.success'),
                'html' => view('e-document.render.favorite-button', compact('document'))->render(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => config('setting.status.error'),
                'message' => trans('e-document.document.detail.message.error'),
            ], 400);
        }
    }
}
