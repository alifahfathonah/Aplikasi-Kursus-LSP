<?php

namespace App\Http\Controllers;

use File;
use App\Pages;
use App\Document;
use App\User;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pages $pages)
    {
        $adminPages = '';
        if ($pages->exists == false) {
            $pages = '';
            $adminPages = User::where('username', 'admin')->first();
        }
        
        $documents = Document::latest()->paginate(9);
        return view('documentation')
            ->with(compact('documents'))
            ->with(compact('adminPages'))
            ->with(compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.admin.documentation.createDocument');
    }

    public function list()
    {

        $documents = Document::paginate(10);
        
        return view('layouts.admin.documentation.listDocument', compact('documents'));
    }


    public function filter_list(Request $request)
    {
        $documents = Document::where('judul',  'like', '%'.$request->judulSearch.'%')->paginate(10);
        return view('layouts.admin.documentation.listDocument', compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'file.*' => 'mimes:jpeg,png,jpg,gif,svg,mp4,3gp,mkv|required',
        ]);

        $document = new Document();
        $document->gambar = '';
        $document->video = '';


        $image_extensions = array('jpg', 'png', 'jpeg', 'gif', 'svg');
        $video_extensions = array('mp4', '3gp', 'mkv');


        if ($request->hasfile('file')) {

            foreach ($request->file('file') as $file) {

                $file_parts = pathinfo($file->getClientOriginalName());
                if (in_array($file_parts['extension'], $image_extensions)) {
                    $nameImage = time() . '.' . $file->getClientOriginalName();
                    $file->move(public_path() . '/images/upload/', $nameImage);
                    $dataImage[] = $nameImage;
                } elseif (in_array($file_parts['extension'], $video_extensions)) {
                    $nameVideo = time() . '.' . $file->getClientOriginalName();
                    $file->move(public_path() . '/videos/upload/', $nameVideo);
                    $dataVideo[] = $nameVideo;
                }
            }
            if (!empty($dataImage)) {
                $document->gambar = json_encode($dataImage);
            }

            if (!empty($dataVideo)) {
                $document->video = json_encode($dataVideo);
            }
        }

        $document->judul = $request->judul;
        $document->created_at = date('Y-m-d H:i:s');
        $document->save();

        return redirect('dashboard/admin/document/')->with('status', 'Your post has been successfully posted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        $dataImage = json_decode($document->gambar);
        $dataVideo = json_decode($document->video);

        return view('layouts.admin.documentation.showDocument')
            ->with(compact('dataImage'))
            ->with(compact('dataVideo'))
            ->with(compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        $dataGambar =  json_decode($document->gambar);
        $dataVideo =  json_decode($document->video);
        return view('layouts.admin.documentation.editDocument')
            ->with(compact('document'))
            ->with(compact('dataGambar'))
            ->with(compact('dataVideo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'judul' => 'required',
            'file.*' => 'mimes:jpeg,png,jpg,gif,svg,mp4,3gp,mkv',
        ]);

        $dataGambar = Document::select('gambar')->where('id', $document->id)->get();
        $dataVideo = Document::select('video')->where('id', $document->id)->get();
        $myGambar =  json_decode($dataGambar[0]["gambar"], true);
        $myVideo =  json_decode($dataVideo[0]["video"], true);
        $image_extensions = array('jpg', 'png', 'jpeg', 'gif', 'svg');
        $video_extensions = array('mp4', '3gp', 'mkv');

        if ($request->hasfile('file')) {
            foreach ($request->file('file') as $file) {
                $file_parts = pathinfo($file->getClientOriginalName());
                if (in_array($file_parts['extension'], $image_extensions)) {
                    $nameImage = time() . '.' . $file->getClientOriginalName();
                    $file->move(public_path() . '/images/upload/', $nameImage);
                    $myGambar[] = $nameImage;
                    $ArrayGambar = array_values($myGambar);
                } elseif (in_array($file_parts['extension'], $video_extensions)) {
                    $nameVideo = time() . '.' . $file->getClientOriginalName();
                    $file->move(public_path() . '/videos/upload/', $nameVideo);
                    $myVideo[] = $nameVideo;
                    $ArrayVideo = array_values($myVideo);
                }
            }

            if (!empty($ArrayGambar) && !empty($ArrayVideo)) {
                Document::where('id', $document->id)
                    ->update([
                        'judul' => $request->judul,
                        'gambar' => json_encode($ArrayGambar),
                        'video' => json_encode($ArrayVideo),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            } elseif (!empty($ArrayGambar)) {
                Document::where('id', $document->id)
                    ->update([
                        'judul' => $request->judul,
                        'gambar' => json_encode($ArrayGambar),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            } elseif (!empty($ArrayVideo)) {
                Document::where('id', $document->id)
                    ->update([
                        'judul' => $request->judul,
                        'video' => json_encode($ArrayVideo),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
            return redirect('dashboard/admin/document/')->with('status', 'Your post has been updated successfully');
        }


        Document::where('id', $document->id)
            ->update([
                'judul' => $request->judul,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        return redirect('dashboard/admin/document/')->with('status', 'Your post has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $gambar = json_decode($document->gambar);
        $video = json_decode($document->video);
        // dump($video);die;
        if (!empty($gambar)) {
            for ($i = 0; $i < sizeof($gambar); $i++) {
                File::delete('images/upload/' . $gambar[$i]);
            }
        }
        if (!empty($video)) {
            for ($i = 0; $i < sizeof($video); $i++) {
                File::delete('videos/upload/' . $video[$i]);
            }
        }
        Document::destroy($document->id);

        return redirect('dashboard/admin/document')->with('status', 'Your post has been deleted');
    }

    public function deleteImage(Request $request, Document $document)
    {
        $data = Document::select('gambar')->where('id', $request->id)->get();
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
                Document::where('id', $request->id)
                    ->update([
                        'gambar' => json_encode($myArray),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                return 'ok';
            }
        }

        return 'err';
    }


    public function deleteVideo(Request $request, Document $document)
    {
        $data = Document::select('video')->where('id', $request->id)->get();
        $myVideo =  json_decode($data[0]["video"], true);
        $video = $request->namafile;

        for ($i = 0; $i < count($myVideo); $i++) {
            if ($myVideo[$i] == $video) {

                // Mengahaspus video dari folder
                File::delete('videos/upload/' . $video);
                // Menghapus video dari array
                unset($myVideo[$i]);
                // Reindex
                $myArray = array_values($myVideo);


                // update video ke db
                Document::where('id', $request->id)
                    ->update([
                        'video' => json_encode($myArray),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                return 'ok';
            }
        }

        return 'err';
    }
}
