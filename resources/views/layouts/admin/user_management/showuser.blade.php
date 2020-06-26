@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">User Management</div>
    <div class="card-body">
        <h5 class="card-title">Detail User</h5>
        <form>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input class="form-control" type="text" placeholder="{{$myAdmin -> nama}}" readonly>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input class="form-control" type="text" placeholder="{{$myAdmin -> alamat}}" readonly>
            </div>
            <div class="form-group">
                <label for="telp">Nomor HP</label>
                <input class="form-control" type="text" placeholder="{{$myAdmin -> telp}}" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="text" placeholder="{{$myAdmin -> email}}" readonly>
            </div>
            <?php $jabatan = $myAdmin->jabatan; ?>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" value="admin" @if ($jabatan=='admin' ) checked @endif disabled>
                    <label class="form-check-label">
                        Admin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jabatan" value="user" @if ($jabatan=='user' ) checked @endif disabled>
                    <label class="form-check-label">
                        User
                    </label>
                </div>
            </div>
        </form>
        <div class="text-right">
            <a href="{{$myAdmin->id}}/edit" class="btn btn-warning tune-ico"><i class="las la-edit la-lg"></i>Edit</a>
            <form action="{{$myAdmin->id}}" method="POST" class="d-inline">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger tune-ico" id="delete-data"><i class="las la-trash la-lg"></i>Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection