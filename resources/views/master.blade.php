<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('mytitle')</title>
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/slick-theme.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top ">
        <div class="container">
            <a class="navbar-brand animate__animated animate__fadeIn" href="{{url('/')}}" style="font-weight: bold;"><img src="/images/logo.png" class="mb-2" width="40px" height="40px" alt=""> AbuProperti</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto disabled">
                    <li class="nav-item"><a class="nav-link" href="@if (!empty($pages) == 1) /{{$pages->username}}/ @else {{ url('/')}} @endif">Home <span class="sr-only">(current)</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="@if (!empty($pages) == 1) /{{$pages->username}}/about @else {{ url('/about')}} @endif">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Projects</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="@if (!empty($pages) == 1) /{{$pages->username}}/asset @else {{ url('/asset')}} @endif">Asset</a>
                            <a class="dropdown-item" href="@if (!empty($pages) == 1) /{{$pages->username}}/service @else {{ url('/service')}} @endif">Construction Services</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="@if (!empty($pages) == 1) /{{$pages->username}}/documentation @else {{ url('/documentation')}} @endif">Documentation</a></li>
                    <li class="nav-item"><a class="nav-link" href="@if (!empty($pages) == 1) /{{$pages->username}}/blog @else {{ url('/blog')}} @endif">News & Updates</a></li>
                    <li class="nav-item"><a class="nav-link" href="@if (!empty($pages) == 1) /{{$pages->username}}/contact @else {{ url('/contact')}} @endif">Contacts & Location</a></li>
                    <li class="nav-item"><a class="nav-link" href="@if (!empty($pages) == 1) /{{$pages->username}}/testimony @else {{ url('/testimony')}} @endif">Testimony</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->

    @yield('content')


    <footer>
        <section class="myfooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 offset-md-4 text-center">
                        <img id="footer_picture" src="@if (!empty($pages -> photo)) /images/upload/profile/{{$pages->photo}} @elseif (!empty($adminPages->photo)) /images/upload/profile/{{$adminPages->photo}} @else /images/default_user.png @endif" alt="Contact Picture">
                    </div>
                    <div class="col-md-6" id="footer_identity">
                        <p id="footer_nama"><b>
                                @if(!empty($pages))
                                {{$pages->nama}}
                                @else
                                {{$adminPages->nama}}
                                @endif
                            </b>
                        </p>
                        <p id="footer_alamat">
                            <b>
                                @if(!empty($pages))
                                {{$pages->alamat}}
                                @else
                                {{$adminPages->alamat}}
                                @endif
                            </b>
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row text-center" id="footer_contact">
                    <div class="col-md-4">
                        <i class="la la-whatsapp la-4x"></i>
                        <p>
                            @if(!empty($pages))
                            {{$pages->telp}}
                            @else
                            {{$adminPages->telp}}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <i class="la la-phone-volume la-4x"></i>
                        <p>
                            @if(!empty($pages))
                            {{$pages->telp}}
                            @else
                            {{$adminPages->telp}}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <i class="la la-envelope la-4x"></i>
                        <p>
                            @if(!empty($pages))
                            {{$pages->email}}
                            @else
                            {{$adminPages->email}}
                            @endif
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-md-12">
                        <h2>ABU PROPERTI</h2>
                        <p>Jl. Kampung Sumur, Jakarta, 13470
                            <br>
                            <sub>Copyright @2020. Abu Properti.</sub>
                            <br>
                            <!-- <sub>All Right Reserved.</sub> -->
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section id="contactfloat">
            <div class="row">
                <div class="col">
                    <a href="@if (!empty($pages) == 1) tel:{{$pages->telp}} @else tel:{{$adminPages->telp}} @endif"><i class="las la-phone la-2x animate__animated animate__jello" style="color: white; background-color: rgb(30, 136, 229); border-radius:40px; filter: drop-shadow(3px 3px 3px rgba(0, 0, 0, 0.25)); padding: 10px" id="float_telp"></i></a>
                </div>
            </div>
            <div class="row" style="margin-top: 5px">
                <div class="col">
                    <a href="@if (!empty($pages) == 1) https://api.whatsapp.com/send?phone={{$pages->telp}}&text= @else https://api.whatsapp.com/send?phone={{$adminPages->telp}}&text= @endif "><i class="lab la-whatsapp la-2x animate__animated animate__jello" style="color: white; background-color: rgb(102, 187, 106); border-radius:40px; filter: drop-shadow(3px 3px 3px rgba(0, 0, 0, 0.25)); padding: 10px " id="float_whatsapp"></i></a>
                </div>
            </div>
            <div class="row" style="margin-top: 5px">
                <div class="col">
                    <a href="@if (!empty($pages) == 1) mailto:{{$pages->email}} @else mailto:{{$adminPages->email}} @endif "><i class="la la-envelope la-2x animate__animated animate__jello" style="color: white; background-color: rgb(244, 67, 54); border-radius:40px; filter: drop-shadow(3px 3px 3px rgba(0, 0, 0, 0.25)); padding: 10px;" id="float_email"></i></a>
                </div>
            </div>
        </section>
    </footer>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('/js/slick.js') }}"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript">
    $(function() {
        $(document).scroll(function() {
            var $nav = $(".navbar");
            $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
        });
    });

    $(document).ready(function() {
        $("select#province").change(function() {
            var selectedProvince = $("#province option:selected").val();
            var sel = document.getElementById('city')
            for (i = sel.length - 1; i >= 0; i--) {
                sel.remove(i);
            }
            sel.length = 0;


            if (selectedProvince == "Select Province") {
                $.post("{{url('/getAllCities')}}", {
                    "_token": "{{ csrf_token() }}",

                }, function(resp) {
                    var opt = document.createElement('option');
                    opt.selected = 'false';
                    opt.text = 'Select City';
                    sel.appendChild(opt);
                    $(resp).each(function() {
                        var opt = document.createElement('option');
                        opt.value = this.id;
                        opt.text = this.kota;
                        sel.appendChild(opt);
                    });
                });
            } else {
                $.post("{{url('/getCities')}}", {
                    "_token": "{{ csrf_token() }}",
                    'province': selectedProvince,

                }, function(resp) {
                    $(resp).each(function() {
                        var opt = document.createElement('option');
                        opt.value = this.id;
                        opt.text = this.kota;
                        sel.appendChild(opt);
                    });
                });
            }
        });

    });
</script>


</html>