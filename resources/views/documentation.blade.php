@extends('master')
@section('mytitle', 'Documentation | Abu Properti')

<section class="documentation" id="documentation">
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-12">
                <h1>Documentation</h1>
            </div>
        </div>
        <div class="row">
            @foreach ($documents as $document)
            <?php
            $dataGambar = json_decode($document->gambar);
            $dataVideo = json_decode($document->video);
            ?>

            <div class="swiper-container">
                <h5>{{$document->judul}}</h5>
                <div class="swiper-wrapper animate__animated animate__fadeIn">
                    @if(!empty($dataGambar))
                    @foreach($dataGambar as $gambar)
                    <div class="swiper-slide">
                        <div class="swiper-zoom-container">
                            <img src="/images/upload/{{$gambar}}" alt="gambar{{$loop->iteration}}">
                        </div>
                    </div>
                    @endforeach
                    @endif
                    @if(!empty($dataVideo))
                    @foreach($dataVideo as $video)
                    <div class="swiper-slide video">
                        <video width="400px" height="300px" src="/videos/upload/{{$video}}#t=1" controls="controls" preload="metadata" onclick="this.play()"></video>
                    </div>
                    @endforeach
                    @endif
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="container">
<div class="row" style="margin-top: 30px">
    <div class="col-md-12">
        <div class="pagination" style="justify-content: center ">
            {{ $documents->links() }}
        </div>
    </div>
</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        //initialize swiper when document ready
        var mySwiper = new Swiper('.swiper-container', {
            // Optional parameters
            pagination: {
                el: '.swiper-pagination',
                dynamicBullets: true,
            },
            zoom: true,
        })
    });
</script>