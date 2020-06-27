<?php

namespace App\Http\Controllers;

use File;
use App\Blog;
use Illuminate\Http\Request;
use App\Pages;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pages $pages)
    {
        if ($pages->exists == false) {
            $pages = '';
        }

        $blogs = Blog::latest()->paginate(6);
        return view('blog.index')
            ->with(compact('blogs'))
            ->with(compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.admin.blog.createblog');
    }

    public function list()
    {

        $blogs = Blog::paginate(10);
        return view('layouts.admin.blog.listblog', compact('blogs'));
    }


    public function filter_list(Request $request)
    {
        $blogs = Blog::where('judul',  'like', '%'.$request->judulSearch.'%')->paginate(10);
        return view('layouts.admin.blog.listblog', compact('blogs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump($request);die;

        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $blog = new Blog();
        $blog->gambar = '';
        if ($request->hasfile('image')) {

            foreach ($request->file('image') as $image) {
                $name = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path() . '/images/upload/', $name);
                $data[] = $name;
            }
            $blog->gambar = json_encode($data);
        }

        $blog->judul = $request->judul;
        $blog->konten = $request->konten;
        $blog->created_at = date('Y-m-d H:i:s');

        $blog->save();
        return redirect('dashboard/admin/blog/')->with('status', 'Your post has been successfully posted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog , Pages $pages)
    {
        if ($pages->exists == false) {
            $pages = '';
        }

        return view('blog.content')
            ->with(compact('blog'))
            ->with(compact('pages'));
    }


    public function show_detail(Blog $blog)
    {
        $data = json_decode($blog->gambar);

        // dump($data);die;
        return view('layouts.admin.blog.showblog')
            ->with(compact('data'))
            ->with(compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $data =  json_decode($blog->gambar);
        return view('layouts.admin.blog.editblog')
            ->with(compact('blog'))
            ->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = Blog::select('gambar')->where('id', $blog->id)->get();
        $mygambar =  json_decode($data[0]["gambar"], true);

        if ($request->hasfile('image')) {
            foreach ($request->file('image') as $image) {
                $name = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path() . '/images/upload/', $name);
                $mygambar[] = $name;
                $myArray = array_values($mygambar);
            }
            Blog::where('id', $blog->id)
                ->update([
                    'judul' => $request->judul,
                    'konten' => $request->konten,
                    'gambar' => json_encode($myArray),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]); 
            
            return redirect('dashboard/admin/blog/')->with('status', 'Your post has been updated successfully');
        }


        Blog::where('id', $blog->id)
            ->update([
                'judul' => $request->judul,
                'konten' => $request->konten,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        return redirect('dashboard/admin/blog/')->with('status', 'Your post has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {

        $gambar = json_decode($blog->gambar);
        if (!empty($gambar)) {
            for ($i = 0; $i < sizeof($gambar); $i++) {
                File::delete('images/upload/' . $gambar[$i]);
            }
        }
        Blog::destroy($blog->id);

        return redirect('dashboard/admin/blog')->with('status', 'Your post has been successfully deleted');
    }

    public function deleteImage(Request $request, Blog $blog)
    {
        $data = Blog::select('gambar')->where('id', $request->id)->get();
        $mygambar =  json_decode($data[0]["gambar"], true);
        $gambar = $request->namafile;

        for ($i = 0; $i < count($mygambar); $i++) {
            if ($mygambar[$i] == $gambar) {

                // Mengahaspus Gambar dari folder
                File::delete('images/upload/' . $gambar);
                // Menghapus gambar dari array
                unset($mygambar[$i]);
                // Reindex
                $myArray = array_values($mygambar);

                // update gambar ke db
                Blog::where('id', $request->id)
                    ->update([
                        'gambar' => json_encode($myArray),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                return 'ok';
            }
        }

        return 'err';
    }
}
