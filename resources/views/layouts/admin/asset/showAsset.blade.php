@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Asset Management</div>
    <div class="card-body">
        <h5 class="card-title">Detail Asset</h5>
        <form>
            <div class="form-group">
                <label for="judul">Judul</label>
                <input class="form-control" type="text" placeholder="{{$asset -> judul}}" readonly>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi-read" rows="5" name="deskripsi">{{$asset->deskripsi}}</textarea>
            </div>
            <div class="form-group">
                <label for="tipe">Tipe</label>
                <input class="form-control" type="text" placeholder="{{$asset -> tipe}}" readonly>
            </div>
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input class="form-control" type="text" placeholder="{{$provinsi}}" readonly>
            </div>
            <div class="form-group">
                <label for="kota">Kota</label>
                <input class="form-control" type="text" placeholder="{{$kota}}" readonly>
            </div>
            <?php $gambar = json_decode($asset->gambar); ?>
            @if(!empty($gambar))
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <div class="row">
                    @for($i = 0; $i < count($gambar); $i++) <img src="/images/upload/{{$gambar[$i]}}" alt="image" class="img-thumbnail" id="tune-img-thumb">
                        @endfor
                </div>
            </div>
            @endif
        </form>
        <div class="text-right">
            <a href="{{$asset->id}}/edit" class="btn btn-warning tune-ico"><i class="las la-edit la-lg"></i>Edit</a>
            <form action="{{$asset -> id}}" method="POST" class="d-inline">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger tune-ico" id="delete-data"><i class="las la-trash la-lg"></i>Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection