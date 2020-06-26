@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Asset Management</div>
    <div class="card-body">
        <div class="upper-line">
        <a href="{{url('dashboard/admin/asset/add')}}" class="btn btn-success tune-ico" style="margin-bottom: 10px"><i class="las la-plus-circle la-lg"></i>New Post</a>
            <form action="{{url('dashboard/admin/asset/filter')}}" method="get" class="text-right">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" id="judulSearch" placeholder="Search.." name="judulSearch">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit"><i class="la la-search "></i></button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover">
            <thead class="table table-hover">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Provinsi</th>
                    <th scope="col">Kota</th>
                    <th scope="col">Tipe</th>
                    <th class="text-center" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assets as $key => $asset)
                <?php
                $kota = "";
                $provinsi = "";
                $lokasi = explode(",", $asset->lokasi);
                foreach ($cities as $city) {
                    if ($lokasi[0] == $city->id) {
                        $kota = $city->kota;
                    }
                }
                foreach ($provinces as $province) {
                    if ($lokasi[1] == $province->id) {
                        $provinsi = $province->provinsi;
                    }
                }
                ?>
                <tr>
                    <th scope="row">{{$assets -> firstItem() + $key }}</th>
                    <td>
                        @if (strlen($asset->judul) <= 30)
                        {{$asset -> judul}}
                        @else
                        <?php echo substr(($asset->judul), 0, 30). ' ...';?>
                        @endif
                    </td>
                    <td>{{$provinsi}}</td>
                    <td>{{$kota}}</td>
                    <td>{{$asset->tipe}}</td>
                    <td class="text-center">
                        <a href="/dashboard/admin/asset/{{$asset->id}}"><i class="las la-pen-square la-2x"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination" style="justify-content: center">
        {{$assets->appends($_GET)->links()}}
        </div>
    </div>
</div>
@endsection