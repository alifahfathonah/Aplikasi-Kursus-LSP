<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Message();
        $message->nama = $request->inputName;
        $message->email = $request->inputEmail;
        $message->phone = $request->inputPhone;
        $message->pesan = $request->inputMessage;
        $message->user = $request->user;
        $message->created_at = date('Y-m-d H:i:s');

        $message->save();
        return redirect()->back()->with('success', 'Your message has been sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */

    public function list()
    {
        $jabatan = Auth::user()->jabatan;
        $username = Auth::user()->username;
        $messages = Message::where('user', $username)->latest()->paginate(10);
        $skipped = ($messages->currentPage() * $messages->perPage()) - $messages->perPage();
        if ($jabatan == 'admin') {
            return view('layouts.admin.message.listMessage', compact('messages', 'skipped'));
        } else {
            return view('layouts.user.message', compact('messages', 'skipped'));
        }
    }

    public function show(Message $message)
    {
        $jabatan = Auth::user()->jabatan;

        Message::where('id', $message->id)
            ->update([
                'read' => 1,
            ]);

        if ($jabatan == 'admin') {
            return view('layouts.admin.message.showMessage', compact('message'));
        } else {
            return view('layouts.user.showMessage', compact('message'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $jabatan = Auth::user()->jabatan;

        $message->delete();

        if ($jabatan == 'admin') {
            return redirect('dashboard/admin/message')->with('status', 'The message has been deleted');
        } else {
            return redirect('dashboard/user/message')->with('status', 'The message has been deleted');
        }
        
    }
}
