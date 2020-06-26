@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Blog Management</div>
    <div class="card-body">
        <h5 class="card-title">Detail Blog</h5>
        <form>
            <div class="form-group">
                <label for="judul">Judul</label>
                <input class="form-control" type="text" placeholder="{{$blog -> judul}}" readonly>
            </div>
            <div class="form-group">
                <label for="deskripsi">Konten</label>
                <textarea class="form-control" id="deskripsi-read" rows="5" name="deskripsi">{{$blog->konten}}</textarea>
            </div>
            @if(!empty($data))
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <div class="row">
                    @for($i = 0; $i < count($data); $i++) <img src="/images/upload/{{$data[$i]}}" alt="image" class="img-thumbnail" id="tune-img-thumb">
                        @endfor
                </div>
            </div>
            @endif
        </form>
        <div class="text-right">
        <a href="{{ $blog->id}}/edit" class="btn btn-warning tune-ico"><i class="las la-edit la-lg"></i>Edit</a>
        <form action="{{$blog -> id}}" method="POST" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger tune-ico" id="delete-data"><i class="las la-trash la-lg"></i>Delete</button>
        </form>
        </div>
    </div>
</div>
@endsection