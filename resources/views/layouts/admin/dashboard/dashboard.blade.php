@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Dashboard</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-header">Member yang terdaftar</div>
                    <div class="card-body">
                        <h2><b>{{$count}}</b></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-header">Pesan yang belum dibaca</div>
                    <div class="card-body">
                        <h2><b>{{$countMessages}}</b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection