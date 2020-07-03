@extends('master')
@section('mytitle', 'Home | Abu Properti')
@section('content')
<!-- Jumbotron -->
<div class="jumbotron jumbotron-fluid animate__animated animate__fadeIn" id="jb_home">
    <div class="container"></div>
</div>
<!-- Akhir Jumbotron -->

<!-- About Us -->
<section class="about" id="about">
    <div class="container">
        <div class="row animate__animated animate__fadeIn">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center">About Us</h1>
                <p class="text-center">Abu Properti merupakan Solusi Properti Impian anda. Kami menyediakan dan menjual berbagai macam aset properti dari segala kebutuhan, baik untuk hunian maupun Investasi.</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4 offset-md-2" id="btn_about">
                <a href="{{url('/about')}}" class="btn btn-lg btn_saya">About Us</a>
            </div>
            <div class="col-md-4" id="btn_contact">
                <a href="{{url('/contact')}}" class="btn btn-lg btn_saya">Contact Us</a>
            </div>
        </div>
    </div>
</section>
<!-- Akhir About Us -->

<!-- Deskripsi hunian -->
<section class="cluster" id="cluster">
    <div class="container">
        <div class="row animate__animated animate__fadeIn">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center">Asset</h1>
                <p class="text-center">Kami menyediakan berbagai aset yang sedang anda cari di berbagai daerah. Mulai dari lahan, kavling, cluster, dan masih banyak yang lagi.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" id="img_cluster1">
                <img src="/images/asset2.jpg" class="img-fluid" alt="Responsive image">
            </div>
            <div class="col-md-8" id="img_cluster2">
                <img src="/images/asset1.jpg" class="img-fluid" alt="Responsive image">
                <a href="{{url('asset')}}" class="btn btn-lg btn_saya">View All</a>
            </div>
        </div>
    </div>
</section>
<!-- Akhir  Deskripso-->

<!-- News & About -->

<section class="news" id="news">
    <div class="container text-center">
        <div class="row animate__animated animate__fadeIn">
            <div class="col-md-12">
                <h1>News & Update</h1>
            </div>
        </div>
        <div class="row" id="all_news">
            <?php $count = 0; ?>
            @for ($i = 0; $i <= count($blogs); $i++) @if(empty($blogs[$i]->id) == true)
                <?php continue; ?>
                @endif
                <?php $count++;
                $imageThumb =  json_decode($blogs[$i]->gambar);
                ?>
                <div class="col-md-4" id="update_news{{$count}}">
                    <div class="card animate__animated animate__fadeIn">
                        <a href="/blog/{{$blogs[$i]->id}}">
                            <img class="card-img-top" @if(!empty($imageThumb)) src="/images/upload/{{last($imageThumb)}}" @else src="/images/noimage.png" @endif alt="Image Thumbnail" id="update_news{{$count}}">
                            <div class="card-body">
                                <h5 class="card-title">{{substr($blogs[$i]->judul,0,30).'...'}}</h5>
                        </a>
                        <?php $mykonten = $blogs[$i]->konten;
                        $kontennya =  htmlspecialchars_decode($mykonten);
                        ?>
                        <p class="card-text" id="mynews"><?php echo substr(strip_tags($kontennya), 0, 100) . '...'; ?></p>
                    </div>
                </div>
        </div>
        @if ($count == 3) <?php break; ?> @endif
        @endfor
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{url('/blog')}}" class="btn btn-lg btn_saya">Show more</a>
        </div>
    </div>
</section>
@endsection
<!-- Akhir news -->