@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Profile</div>
    <div class="card-body">
        <h5 class="card-title">Edit Profile</h5>
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
        <div class="text-center">
            <img src="@if (!empty($user -> photo)) /images/upload/profile/{{$user->photo}} @else /images/default_user.png @endif" alt="image" class="displayPicture">
        </div>
        <form action="/dashboard/user/profile/{{$user -> id}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-3 tune-profile-pict">
                <div class="input-group-prepend">
                    <span class="input-group-text">Profile Picture</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input form-control-file" id="image" name="image[]">
                    <label class="custom-file-label" for="image">Choose file</label>
                </div>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username @error('username') 
                            is-invalid @enderror" name="username" value="{{$user -> username}}" disabled>
                @error('username')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <label for="nama">Nama *</label>
                <input type="text" class="form-control" id="nama @error('nama') 
                            is-invalid @enderror" placeholder="Masukan Nama" name="nama" value="{{$user -> nama}}" required>
                @error('nama')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="text" class="form-control" id="email @error('email') 
                            is-invalid @enderror" placeholder="Masukan email" name="email" value="{{$user -> email}}" required>
                @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <label for="alamat">Alamat *</label>
                <input type="text" class="form-control" id="alamat @error('alamat') 
                            is-invalid @enderror" placeholder="Masukan alamat" name="alamat" value="{{$user -> alamat}}" required>
                @error('alamat')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <label for="telp">No Handphone *</label>
                <input type="tel" class="form-control" id="telp @error('telp') 
                            is-invalid @enderror" placeholder="Masukan telp" name="telp" value="{{$user -> telp}}" required>
                @error('telp')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <label for="instagram">Instagram</label>
                <input type="text" class="form-control" id="instagram @error('instagram') 
                            is-invalid @enderror" placeholder="Masukan ID instagram" name="instagram" value="<?php if (!is_null($social)) {
                                                                                                                    if (!empty($social->instagram)) {
                                                                                                                        echo $social->instagram;
                                                                                                                    } else echo '';
                                                                                                                } ?>">
                @error('instagram')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <label for="facebook">Facebook</label>
                <input type="text" class="form-control" id="facebook @error('facebook') 
                            is-invalid @enderror" placeholder="Masukan ID facebook" name="facebook" value="<?php if (!is_null($social)) {
                                                                                                                if (!empty($social->facebook)) {
                                                                                                                    echo $social->facebook;
                                                                                                                } else echo '';
                                                                                                            } ?>">
                @error('facebook')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary tune-ico"><i class="las la-save la-lg"></i>Save</button>
            </div>

        </form>
    </div>
</div>
@endsection