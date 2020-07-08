@extends('master')
@section('mytitle', 'News & Update | Abu Properti')
@section('content')
<div class="jumbotron jumbotron-fluid animate__animated animate__fadeIn" id="jb_blog">
    <div class="container"></div>
</div>

<section class="myblog" id="myblog" style="margin-bottom: 50px">
    <div class="container">
        <div class="row text-center animate__animated animate__fadeIn">
            <div class="col-md-12">
                <h1>News & Update</h1>
            </div>
        </div>
        <div class="row">
            @foreach($blogs as $blog )
            <?php $data = json_decode($blog->gambar); ?>
            <div class="card animate__animated animate__slideInUp">
            <a href="@if (!empty($pages) == 1) /{{$pages->username}}/blog/{{$blog -> id}} @else /blog/{{$blog -> id}} @endif">
                @if(!empty($data))
                <img class="card-img-top" src="/images/upload/{{last($data)}}" alt="Card image cap">
                @else
                <img class="card-img-top" src="/images/noimage.png" alt="Card image cap">
                @endif
                <div class="card-body">
                        <h5 class="card-title">
                        @if(strlen($blog->judul) <= 40)
                        {{$blog -> judul}}
                        @else
                        <?php echo substr($blog->judul,0,40).'...'?>
                        @endif
                        </h5>
                    </a>
                    <p class="card-text" id="beritasaya">
                        <?php $mykonten = $blog->konten;
                        $kontennya =  htmlspecialchars_decode($mykonten);
                        if (strlen($kontennya) <= 70){
                            echo strip_tags($kontennya);
                        }else{
                            echo substr(strip_tags($kontennya),0,100).'...';
                        }
                        ?>
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row" style="margin-top: 30px">
            <div class="col-md-12">
                <div class="pagination" style="justify-content: center ">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection