@extends('master')
@section('mytitle', 'Asset | Abu Properti')
<div class="jumbotron jumbotron-fluid animate__animated animate__fadeIn" id="jb_aset" style="background: url('/images/asset.jpg');">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-12" id="jb_contact_isi">
                <h1>Asset</h1>
                <p>Place to look for the assets you are looking for</p>
            </div>
        </div>
        <section class="filter_aset" id="filter_aset">

            <div class="row">
                <form action="/asset/filter" class="form-inline" method="POST">
                    @csrf
                    <select name="province" class="selectpicker form-control" data-live-search="true" id="province">
                        <option selected="false">Select Province</option>
                        @foreach ($provinces as $province)
                        <option value="{{$province->id}}">{{$province->provinsi}}</option>
                        @endforeach
                    </select>

                    <select name="city" class="selectpicker form-control" data-live-search="true" id="city">
                        <option selected="false">Select City</option>
                        @foreach ($cities as $city)
                        <option value="{{$city->id}}">{{$city->kota}}</option>
                        @endforeach
                    </select>

                    <select name="tipe" class="selectpicker form-control" data-live-search="true" id="tipe">
                        <option selected="false">Select Asset Type</option>
                        @foreach ($asset_types as $asset_type)
                        <option value="{{$asset_type->id}}">{{$asset_type->tipe}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn_saya">Search</button>
                </form>
            </div>
        </section>
    </div>
</div>


<section class="list_aset" id="list_aset">
    <div class="container">
        <div class="row" id="assetnya">
            @if ($assets->isEmpty())
            <h1 style="text-align: center;">Whoops, looks like assets don't exist</h1>
            @else
            @foreach ($assets as $asset)
            <?php $dataImage = json_decode($asset->gambar); ?>
            <div class="card animate__animated animate__fadeIn">
                <a href="@if (!empty($pages) == 1) /{{$pages->username}}/asset/{{$asset -> id}} @else /asset/{{$asset -> id}} @endif">
                    <img class="card-img-top" @if(!empty($dataImage)) src="/images/upload/{{last($dataImage)}}" @else src="/images/noimage.png" @endif alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">
                            @if(strlen($asset->judul) <= 40) 
                            {{$asset -> judul}} 
                            @else 
                            <?php echo substr($asset->judul, 0, 40) . '...' ?> 
                            @endif
                        </h5></a> 
                        <div class="card-info">
                            <p><i class="card-text las la-chevron-circle-right la-1x"></i> {{$asset->tipe}}</p>
                            <p><i class="card-text las la-map-marker la-1x"></i> {{$asset->namaKota}}</p>
                        </div>
                    </div>
            </div>
            @endforeach
            @endif
        </div>
        <div class="row" style="margin-top: 30px">
            <div class="col-md-12">
                <div class="pagination" style="justify-content: center ">
                    {{ $assets->links() }}
                </div>
            </div>
        </div>
    </div>
</section>