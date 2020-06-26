@extends('layouts.user.panel')

@section('konten')
<div class="card">
    <div class="card-header">Dashboard</div>
    <div class="card-body">
        <div class="row">
            @auth
            <div class="col-md-6">
                
                <div class="card">
                    <div class="card-header text-center">Bagikan link anda</div>
                    <div class="card-body">
                        <p class="card-text">Saat membagikan link, pastikan anda memasukan username ke bagian akhir url. <br>
                            contoh:
                            <br>
                            {{url('/').'/asset/1/'.Auth::user()->username}}</p>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" value="{{Auth::user()->username}}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-header">Pesan yang belum dibaca</div>
                    <div class="card-body">
                        <h2><b>{{$countMessages}}</b></h2>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection