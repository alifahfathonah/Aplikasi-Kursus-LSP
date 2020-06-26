@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="list-group">
                    <a href="{{url('dashboard')}}" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="dashboard/user/profile" class="list-group-item list-group-item-action disabled">Profile</a>
                    <a href="dashboard/user/message" class="list-group-item list-group-item-action active">Messages</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Affiliate</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card text-center">
                                <div class="card-header">Member yang mendaftar</div>
                                <div class="card-body"><h2><b>{{$referred}}</b></h2></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center">
                                <div class="card-header">User yang menghubungi </div>
                                <div class="card-body"><h2><b>{{$referred}}</b></h2></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    @auth
                    <p>Your referral code</p>
                    <input type="text" readonly="readonly" value="{{url('/').'/?ref='.Auth::user()->affiliate_id}}">
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection