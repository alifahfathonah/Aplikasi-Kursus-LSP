@extends('master')
@section('mytitle', 'Blog | Abu Properti')
@section('content')
<div class="swiper-container animate__animated animate__fadeIn">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        <?php $data = json_decode($blog->gambar); ?>
        @if (!empty($blog->gambar))
        @for ($i = 0; $i
        < count($data); $i++) <img src="/images/upload/{{$data[$i]}}" class="swiper-slide" />
        @endfor
        @else
        <img src="/images/post.jpg" class="swiper-slide" />
        @endif
    </div>
    @if(!empty($blog->gambar))
    @if(count($data) > 1)
    <div class="swiper-button-next swiper-button-white"></div>
    <div class="swiper-button-prev swiper-button-white"></div>
    <div class="swiper-pagination"></div>
    @endif
    @endif
</div>

<section class="isikonten" id="isikonten">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>{{$blog -> judul}}</h1>
                <p>
                    <?php $mykonten = $blog->konten;
                    echo htmlspecialchars_decode($mykonten);
                    ?>
                </p>
            </div>
        </div>

        <div class="row text-center" style="margin-top: 30px">
            <div class="col-12">
                <h5>Share this page</h5>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}"><i class="lab la-facebook la-3x animate__animated animate__pulse animate__delay-3s" id="share_fb"></i></a>
                <a href="https://api.whatsapp.com/send?text=I%20wanted%20to%20share%20this%20great%20website%20with%20you%20{{Request::url()}}"><i class="lab la-whatsapp la-3x animate__animated animate__pulse animate__delay-3s" id="share_wa"></i></a>
            </div>
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
                delay: 5000,
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