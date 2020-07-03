@extends('master')
@section('mytitle', 'Asset | Abu Properti')
@section('content')
<div class="swiper-container tipe">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        @if(!empty($assets->gambar))
        <?php $dataImage = json_decode($assets->gambar) ?>
        @for ($i = 0; $i
        < count($dataImage); $i++) <img src="/images/upload/{{$dataImage[$i]}}" class="swiper-slide" />
        @endfor
        @else
        <img src="/images/noimage.png" class="swiper-slide" />
        @endif
    </div>

    <div class="swiper-button-next swiper-button-white"></div>
    <div class="swiper-button-prev swiper-button-white"></div>
    <div class="swiper-pagination"></div>
</div>

<section class="isi_tipe" id="isi_tipe">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{$assets->judul}}</h3>
                    </div>
                </div>
                <div class="row" id="desc_aset">
                    <div class="col-md-12">
                        <h4>Description</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                echo htmlspecialchars_decode($assets->deskripsi);
                                ?>
                                <p><b>Tipe: {{$assets->tipe}}
                                        <br>
                                        Kota: {{$assets->namaKota}}
                                        <br>
                                        Provinsi: {{$assets->namaProvinsi}}
                                    </b>
                                </p>
                                <div class="row" style="margin-top: 30px">
                                    <div class="col-12">
                                        <h5>Share</h5>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}"><i class="lab la-facebook la-3x animate__animated animate__tada animate__delay-3s" id="contact_fb"></i></a>
                                        <a href="https://api.whatsapp.com/send?text=I%20wanted%20to%20share%20this%20great%20website%20with%20you%20{{Request::url()}}"><i class="la la-whatsapp la-3x animate__animated animate__tada animate__delay-3s" id="contact_wa"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 contact2 animate__animated animate__fadeIn">
                <h4>Contact Us</h4>
                <form action="/pesan/add" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="text" class="form-control" id="inputName" name="inputName" required>
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">Phone</label>
                        <input type="tel" class="form-control" id="inputPhone" name="inputPhone" required>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="inputMessage">Message</label><br>
                        <textarea name="inputMessage" placeholder="" id="inputMessage" style="width: 100%" required></textarea>
                    </div>
                    <input type="hidden" id="user" name="user" value="@if (empty($pages) == true) admin @else {{$pages -> username}} @endif">
                    <div class="form-group">
                        <button type="submit" class="btn btn_saya">Send</button>
                    </div>
                </form>
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p><b>{!! \Session::get('success') !!}</b></p>
                </div>
                @endif  
            </div>
        </div>
        <div class="row text-center" id="title_others">
            <div class="col-md-12">
                <h4>Others</h4>
            </div>
        </div>
        <div class="row" id="other_asset">
            @for ($i = 0; $i < count($otherAssets); $i++) <?php $thumbImage = json_decode($otherAssets[$i]->gambar); ?> <div class="card">
                <a href="@if (!empty($pages) == 1) /{{$pages->username}}/asset/{{$otherAssets[$i] -> id}} @else /asset/{{$otherAssets[$i] -> id}} @endif">
                    <img class="card-img-top" @if(!empty($thumbImage)) src="/images/upload/{{last($thumbImage)}}" @else src="/images/noimage.png" @endif alt="Image Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">
                            @if(strlen($otherAssets[$i]->judul) <= 30) {{$otherAssets[$i] -> judul}} @else <?php echo substr($otherAssets[$i]->judul, 0, 60) . '...' ?> @endif </h5> </a> <div class="card-info">
                                <p><i class="card-text las la-chevron-circle-right la-1x"></i> {{$otherAssets[$i]->tipe}}</p>
                                <p><i class="card-text las la-map-marker la-1x"></i>{{$otherAssets[$i]->namaKota}}</p>
                    </div>
        </div>
    </div>
    <?php if ($i == 4) {
        break;
    } ?>
    @endfor
    </div>
    </div>
</section>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        //initialize swiper when document ready
        var mySwiper = new Swiper('.swiper-container', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 3000,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: { // menampilkan pagination
                el: '.swiper-pagination', // class swiper-pagination sebagai target pagination 
                clickable: true, // pagination bisa diclick untuk menuju slide tertentu
            },

        })
    });
</script>