@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Documentation</div>
    <div class="card-body">
    <h5 class="card-title">Edit Documentation</h5>
        <div class="container">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        </div>
        <form method="post" action="/dashboard/admin/document/{{$document -> id}}" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="form-group">
                <label for="=judul">Judul</label>
                <input type="text" class="form-control" id="judul" placeholder="Masukan Judul" name="judul" value="{{$document->judul}}">
            </div>
            @if(!empty($dataGambar))
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <div class="row" id="tune-edit-img">
                    @for($i = 0; $i < count($dataGambar); $i++) 
                    <div class="card" id="img_{{$i}}">
                        <img src="/images/upload/{{$dataGambar[$i]}}" alt="image" class="card-img-top">
                        <div class="card-body">
                            <a href="javascript:void(0);" class="btn btn-danger tune-ico" onclick=" deleteImageDoc('{{$document -> id}}', '{{$dataGambar[$i]}}', $(this).parent().parent().prop('id'))"><i class="las la-trash la-lg"></i>Delete</a>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            @endif
            @if(!empty($dataVideo))
            <div class="form-group">
                <label for="video">Video</label>
                <div class="row" id="tune-edit-vid">
                    @for($i = 0; $i < count($dataVideo); $i++) 
                    <div class="card" id="vid_{{$i}}">
                        <video src="/videos/upload/{{$dataVideo[$i]}}#t=1" controls="controls" preload="metadata" onclick="this.play()"></video>
                        <div class="card-body">
                            <a href="javascript:void(0);" class="btn btn-danger tune-ico" onclick=" deleteVideo('{{$document -> id}}', '{{$dataVideo[$i]}}', $(this).parent().parent().prop('id'))"><i class="las la-trash la-lg"></i>Delete</a>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            @endif
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Gambar atau Video</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input form-control" name="file[]" id="file" multiple="multiple" aria-describedby="fileHelp">
                    <label class="custom-file-label" for="file">Choose file</label>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary tune-ico"><i class="las la-save la-lg"></i>Save</button>
            </div>
        </form>
    </div>
</div>
@endsection