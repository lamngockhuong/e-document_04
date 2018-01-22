<?php

namespace App\Http\Controllers\Outside;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function favorites()
    {
        $title = trans('e-document.user.favorites.title');

        $documents = Document::whereHas('favorites', function ($query) {
                    $query->where('user_id', auth()->user()->id);
        })
        ->paginate(config('setting.public.homepage.number_of_documents'))->all();

        return view('e-document.user.favorites', compact('title', 'documents'));
    }

    public function showPersonalInformation()
    {
        $title = trans('e-document.user.personal_information.title');

        return view('e-document.user.personal-information', compact('title'));
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'oldpassword' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        
    }
}
