@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">User Management</div>
    <div class="card-body">
        <h5 class="card-title">Edit User</h5>
        <form action="/dashboard/admin/manage/{{$myAdmin -> id}}" method="post">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="exampleInputEmail1 @error('nama') 
                            is-invalid @enderror" id="nama" placeholder="Masukan Nama" name="nama" value="{{$myAdmin -> nama}}">
                @error('nama')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="exampleInputEmail1 @error('alamat') 
                            is-invalid @enderror" id="alamat" placeholder="Masukan Alamat" name="alamat" value="{{$myAdmin -> alamat}}">
                @error('alamat')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <label for="telp">Nomor HP</label>
                <input type="text" class="form-control" id="exampleInputEmail1 @error('telp') 
                            is-invalid @enderror" id="telp" placeholder="Masukan Nomor HP" name="telp" value="{{$myAdmin -> telp}}">
                @error('telp')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <label for="=email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Masukan Email" name="email" value="{{$myAdmin -> email}}">
            </div>
            <?php $jabatan = $myAdmin->jabatan;?>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" value="admin" @if ($jabatan=='admin' ) checked @endif>
                    <label class="form-check-label">
                        Admin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" value="user" @if ($jabatan=='user' ) checked @endif>
                    <label class="form-check-label">
                        User
                    </label>
                </div>
            </div>
            <div class="text-right">
            <button type="submit" class="btn btn-primary tune-ico"><i class="las la-save la-lg"></i>Save</button>
            </div>
        </form>
    </div>
</div>
@endsection