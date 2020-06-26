@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">User Management</div>
    <div class="card-body">
        <div class="upper-line" style="justify-content: flex-end !important;">
            <form action="{{url('dashboard/admin/manage/filter')}}" method="get" class="text-right">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control mb-2" id="judulSearch" placeholder="Search.." name="judulSearch">
                    <div class="input-group-append">
                        <button class="btn btn-success mb-2" type="submit"><i class="la la-search "></i></button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover">
            <thead class="table">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Jabatan</th>
                    <th class="text-center" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                <tr>
                    <th scope="row">{{$users->firstItem() + $key}}</th>
                    <td>{{$user -> nama}}</td>
                    <td>{{$user -> email}}</td>
                    <td>{{$user -> jabatan}}</td>
                    <td class="text-center">
                        <a href="/dashboard/admin/manage/{{$user->id}}"><i class="las la-pen-square la-2x"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination" style="justify-content: center">
            {{$users->appends($_GET)->links()}}
        </div>
    </div>
</div>
@endsection