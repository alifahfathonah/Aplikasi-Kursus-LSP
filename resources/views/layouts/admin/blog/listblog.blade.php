@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Blog Management</div>
    <div class="card-body">
        <div class="upper-line">
            <a href="{{url('dashboard/admin/blog/add')}}" class="btn btn-success tune-ico lilbit-bottom"><i class="las la-plus-circle la-lg"></i>New Post</a>
            <form action="{{url('dashboard/admin/blog/filter')}}" method="get" class="text-right">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" id="judulSearch" placeholder="Search.." name="judulSearch">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit"><i class="la la-search "></i></button>
                    </div>
                </div>
            </form>
        </div>
        <ul class="list-group">
            @foreach($blogs as $blog)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @if(strlen($blog->judul) <= 80) {{$blog -> judul}} @else <?php echo substr($blog->judul, 0, 80) . ' ...' ?> @endif <a href="/dashboard/admin/blog/{{$blog->id}}"><i class="las la-pen-square la-2x"></i></a>
            </li>
            @endforeach
        </ul>
        <div class="pagination" style="justify-content: center">
            {{$blogs->appends($_GET)->links()}}
        </div>
    </div>
</div>
@endsection