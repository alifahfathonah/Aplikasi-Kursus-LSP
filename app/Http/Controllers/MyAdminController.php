<?php

namespace App\Http\Controllers;

use File;
use App\Message;
use App\MyAdmin;
use App\Social;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyAdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $user = Auth::user();
        $count = User::all()->count();
        $countMessages = Message::whereNull('read')->where('user', $user->username)->count();

        if ($user->jabatan == 'admin') {
            return view('layouts.admin.dashboard.dashboard')
                ->with(compact('user'))
                ->with(compact('count'))
                ->with(compact('countMessages'));
        } else {
            return view('layouts.user.dashboard')
                ->with(compact('user'))
                ->with(compact('countMessages'));
        }
    }

    public function manage()
    {
        $users = User::paginate(10);
        return view('layouts.admin.user_management.user', compact('users'));
    }

    public function filter_manage(Request $request)
    {
        $users = User::where('nama',  'like', '%' . $request->judulSearch . '%')->orWhere('email',  'like', '%' . $request->judulSearch . '%')->paginate(10);
        return view('layouts.admin.user_management.user', compact('users'));
    }


    public function showProfile()
    {

        $user = Auth::user();
        $jabatan = Auth::user()->jabatan;
        $social = Social::where('user_id', $user->id)->first();

        if ($jabatan == 'admin') {
            return view('layouts.admin.profile.profile', compact('user', 'social'));
        } else {
            return view('layouts.user.profile', compact('user', 'social'));
        }
    }

    public function updateProfile(Request $request, MyAdmin $myAdmin)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $jabatan = Auth::user()->jabatan;
        $idSocial = $myAdmin->id;
        $findSocial = Social::where('user_id', $idSocial)->exists();
        $ig = '';
        $fb = '';

        if (!empty($request->instagram)) {
            $ig = $request->instagram;
        }
        if (!empty($request->facebook)) {
            $fb = $request->facebook;
        }

        if ($findSocial == true) {
            Social::where('user_id', $idSocial)
                ->update([
                    'instagram' => $ig,
                    'facebook' => $fb,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
        } else {
            $social = new Social();
            $social->user_id = $idSocial;
            $social->instagram = $ig;
            $social->facebook = $fb;
            $social->created_at = date('Y-m-d H:i:s');
            $social->save();
        }

        if ($request->hasfile('image')) {
            if (!empty($myAdmin->photo)) {
                $deleteImage = $myAdmin->photo;
                File::delete('images/upload/profile/' . $deleteImage);
            }
            foreach ($request->file('image') as $image) {
                $nameImage = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path() . '/images/upload/profile/', $nameImage);
            }

            MyAdmin::where('id', $myAdmin->id)
                ->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'alamat' => $request->alamat,
                    'telp' => $request->telp,
                    'photo' => $nameImage,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            if ($jabatan == 'admin') {
                return redirect('dashboard/admin/profile')->with('status', 'Your profile has been updated successfully');
            } else {
                return redirect('dashboard/user/profile')->with('status', 'Your profile has been updated successfully');
            }
        }

        MyAdmin::where('id', $myAdmin->id)
            ->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if ($jabatan == 'admin') {
            return redirect('dashboard/admin/profile')->with('status', 'Your profile has been updated successfully');
        } else {
            return redirect('dashboard/user/profile')->with('status', 'Your profile has been updated successfully');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MyAdmin  $myAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(MyAdmin $myAdmin)
    {
        return view('layouts.admin.user_management.showuser', compact('myAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MyAdmin  $myAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(MyAdmin $myAdmin)
    {
        return view('layouts.admin.user_management.edituser', compact('myAdmin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MyAdmin  $myAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyAdmin $myAdmin)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'email' => 'required',
        ]);

        User::where('id', $myAdmin->id)
            ->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'email' => $request->email,
                'jabatan' => $request->jabatan
            ]);
        return redirect('dashboard/admin/manage')->with('status', 'User data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MyAdmin  $myAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyAdmin $myAdmin)
    {
        Social::destroy($myAdmin->id);
        User::destroy($myAdmin->id);
        return redirect('dashboard/admin/manage')->with('status', 'User data successfully deleted');
    }
}
