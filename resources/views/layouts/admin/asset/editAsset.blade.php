@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Asset Management</div>
    <div class="card-body">
        <h5 class="card-title">Edit Asset</h5>    
        <div class="container">
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

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        </div>
        <form method="post" action="/dashboard/admin/asset/{{$asset -> id}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label for="=judul">Judul</label>
                    <input type="text" class="form-control" id="judul" placeholder="Masukan Judul" name="judul" value="{{$asset->judul}}">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi">{{$asset->deskripsi}}</textarea>
                </div>
                <div class="form-group">
                    <label for="tipe">Tipe</label>
                    <select name="tipe" class="selectpicker form-control" data-live-search="true" id="tipe">
                        <option selected="false">Pilih Tipe Aset</option>
                        @foreach ($asset_types as $asset_type)
                        @if($asset_type -> id == $asset -> tipe_id )
                        <option selected="true" value="{{$asset_type->id}}">{{$asset_type->tipe}}</option>
                        @else
                        <option value="{{$asset_type->id}}">{{$asset_type->tipe}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="provinsi">Provinsi</label>
                    <select name="provinsi" class="selectpicker form-control" data-live-search="true" id="provinsi">
                        <option selected="false">Pilih Provinsi</option>
                        @foreach ($provinces as $province)
                        @if($province -> provinsi == $asset -> namaProvinsi)
                        <option selected="true" value="{{$province->id}}">{{$province->provinsi}}</option>
                        @else
                        <option value="{{$province->id}}">{{$province->provinsi}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="listKota">
                    <label for="kota">Kota</label>
                    <select name="kota" class="selectpicker form-control" data-live-search="true" id="kota">
                        <option selected="false">Pilih Kota</option>
                        @foreach ($cities as $city)
                        @if($city -> provinsi_id == $asset -> provinsiId)
                        @if($city -> kota == $asset -> namaKota)
                        <option selected="true" value="{{$city->id}}">{{$city->kota}}</option>
                        @else
                        <option value="{{$city->id}}">{{$city->kota}}</option>
                        @endif
                        @endif
                        @endforeach
                    </select>
                </div>
                <?php $data = json_decode($asset->gambar); ?>
                @if(!empty($data))
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <div class="row" id="tune-edit-img">
                        @for($i = 0; $i < count($data); $i++)
                            <div class="card" id="img_{{$i}}">
                                <img src="/images/upload/{{$data[$i]}}" alt="image" class="card-img-top">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="btn btn-danger tune-ico" onclick=" deleteImageAsset('{{$asset -> id}}', '{{$data[$i]}}', $(this).parent().parent().prop('id'))"><i class="las la-trash la-lg"></i>Delete</a>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                @endif
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Upload Gambar</span>
                    </div>
                    <div class="custom-file">
                    <input type="file" class="custom-file-input form-control" name="image[]" id="file" multiple="multiple" aria-describedby="fileHelp">
                    <label class="custom-file-label" for="file">Choose file</label>
                    </div>
                </div>
                <div class="text-right">
                <button type="submit" class="btn btn-primary tune-ico"><i class="las la-save la-lg"></i>Save</button>
                </div>
                
            </form>
    </div>
</div>
@endsection