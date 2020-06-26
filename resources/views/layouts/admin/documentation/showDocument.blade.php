@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Documentation</div>
    <div class="card-body">
        <h5 class="card-title">Detail Documentation</h5>
        <form>
            <div class="form-group">
                <label for="judul">Judul</label>
                <input class="form-control" type="text" placeholder="{{$document -> judul}}" readonly>
            </div>
            @if(!empty($dataImage))
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <div class="row">
                    @for($i = 0; $i < count($dataImage); $i++) <img src="/images/upload/{{$dataImage[$i]}}" alt="image" class="img-thumbnail" id="tune-img-thumb">
                        @endfor
                </div>
            </div>
            @endif
            @if(!empty($dataVideo))
            <div class="form-group">
                <label for="video">Video</label>
                <div class="row">
                    @for($i = 0; $i < count($dataVideo); $i++) <video width="100" height="100" src="/videos/upload/{{$dataVideo[$i]}}#t=1" id="tune-vid-thumb" controls="controls" preload="metadata" onclick="this.play()"></video>
                        @endfor
                </div>
            </div>
            @endif
        </form>
        <div class="text-right">
            <a href="{{ $document->id}}/edit" class="btn btn-warning tune-ico"><i class="las la-edit la-lg"></i>Edit</a>
            <form action="{{$document -> id}}" method="POST" class="d-inline">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger tune-ico" id="delete-data"><i class="las la-trash la-lg"></i>Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection