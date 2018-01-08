<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('admin.user.index.title');
        $users = User::orderBy('id', 'DESC')
            ->paginate(config('setting.pagination.number_per_page'), ['id', 'username', 'email', 'firstname', 'lastname']);

        return view('admin.user.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin.user.create.title');

        return view('admin.user.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $inputs = $request->except('role', 'avatar');
        $user = new User($inputs);

        // get status
        $user->status = $request->status ? config('setting.user.status_active') : config('setting.user.status_deactive');
        // get avatar
        $user->avatar = $request->hasFile('avatar') ? File::uploadFile($request->file('avatar'), config('setting.avatar_folder'), $request->username, false, true) : config('setting.users_default.avatar');
        // user role TODO
        $user->role = serialize(config('setting.users_default.role'));

        if ($user->save()) {
            $message = trans('admin.user.message.create-success');
            $notification = [
                'message' => $message,
                'alert-type' => 'success',
            ];

            return redirect()->route('users.index')->with($notification);
        }

        $message = trans('admin.user.message.create-error');
        $notification = [
            'message' => $message,
            'alert-type' => 'error',
        ];

        return redirect()->route('users.create')->withInput()->with($notification);
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
        $title = trans('admin.user.edit.title');
        try {
            $user = User::findOrFail($id);

            return view('admin.user.edit', compact('title', 'user'));
        } catch (ModelNotFoundException $e) {
            $message = trans('admin.user.message.edit-error');
            $notification = [
                'message' => $message,
                'alert-type' => 'error',
            ];

            return redirect()->route('users.index')->with($notification);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $inputs = $request->except('role', 'avatar', 'password');
        $user->fill($inputs);
        // get status
        $user->status = $request->status ? config('setting.user.status_active') : config('setting.user.status_deactive');
        // delete old avatar
        File::removePublicFile($user->avatar, config('setting.avatar_folder'));
        // get avatar
        $user->avatar = $request->hasFile('avatar') ? File::uploadFile($request->file('avatar'), config('setting.avatar_folder'), $request->username, false, true) : $user->avatar;
        // user role TODO
        $user->role = serialize(config('setting.users_default.role'));

        if ($request->password) {
            $user->password = $request->password;
        }

        if ($user->save()) {
            $message = trans('admin.user.message.edit-success');
            $notification = [
                'message' => $message,
                'alert-type' => 'success',
            ];

            return redirect()->route('users.index')->with($notification);
        }

        $message = trans('admin.user.message.edit-error');
        $notification = [
            'message' => $message,
            'alert-type' => 'error',
        ];

        return redirect()->route('users.create')->withInput()->with($notification);
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
            $user = User::findOrFail($id);
            File::removePublicFile($user->avatar, config('setting.avatar_folder'));

            if ($user->delete()) {
                $message = trans('admin.user.message.delete-success');
                $notification = [
                    'message' => $message,
                    'alert-type' => 'success',
                ];
            } else {
                $message = trans('admin.user.message.delete-error');
                $notification = [
                    'message' => $message,
                    'alert-type' => 'error',
                ];
            }
        } catch (ModelNotFoundException $e) {
            $message = trans('admin.user.message.delete-error');
            $notification = [
                'message' => $message,
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('users.index')->with($notification);
    }
}
