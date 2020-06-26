@extends('master')
@section('mytitle', 'Jasa')

<div class="swiper-container tipe">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        @for ($i = 0; $i
        < count($data["Foto"]); $i++) <img src="/images/{{$data['Foto'][$i]}}" class="swiper-slide" />
        @endfor
    </div>

    <div class="swiper-button-next swiper-button-white"></div>
    <div class="swiper-button-prev swiper-button-white"></div>
    <div class="swiper-pagination"></div>
</div>

<section class="isi_tipe" id="isi_tipe">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Tipe </h1>
            </div>
        </div>
        <div class="row" id="konten_tipe">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Facts and Features</h4>
                        <div class="row">
                            <div class="col-md-12 text-center" id="list_icon">
                                <ul>
                                    @if (!empty($data["Bedrooms"]))
                                    <li><i class="las la-bed la-4x tipe_icon"></i><br>{{$data["Bedrooms"]}} Bedrooms</li>
                                    @endif
                                    @if (!empty($data["Livingrooms"]))
                                    <li><i class="las la-couch la-4x tipe_icon"></i><br>{{$data["Livingrooms"]}} Livingroom</li>
                                    @endif
                                    @if (!empty($data["Bathrooms"]))
                                    <li><i class="las la-bath la-4x tipe_icon"></i><br>{{$data["Bathrooms"]}} Bathroom</li>
                                    @endif
                                    @if (!empty($data["Diningrooms"]))
                                    <li><i class="las la-utensils la-4x tipe_icon"></i><br>{{$data["Diningrooms"]}} Diningroom</li>
                                    @endif
                                    @if (!empty($data["Kitchen"]))
                                    <li><i class="las la-concierge-bell la-4x tipe_icon"></i></i><br>{{$data["Kitchen"]}} Kitchen</li>
                                    @endif
                                    @if (!empty($data["Carport"]))
                                    <li><i class="las la-car la-4x tipe_icon"></i></i><br>{{$data["Carport"]}} Carport</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Floor Plan</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 contact2">
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
                    <button type="submit" class="btn btn_saya">Submit</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 other_image">
                <h4>Others</h4>
                <ul>
                    <li><a href="@if (!empty($pages) == 1) /{{$pages->username}}/jasa/jasa1 @else {{url('/jasa/jasa1')}} @endif"><img src="/images/house2.jpg" alt="Image"></a></li>
                    <li><a href="@if (!empty($pages) == 1) /{{$pages->username}}/jasa/jasa2 @else {{url('/jasa/jasa2')}} @endif"><img src="/images/house2.jpg" alt="Image"></a></li>
                    <li><a href="@if (!empty($pages) == 1) /{{$pages->username}}/jasa/jasa3 @else {{url('/jasa/jasa3')}} @endif"><img src="/images/house2.jpg" alt="Image"></a></li>
                    <li><a href="@if (!empty($pages) == 1) /{{$pages->username}}/jasa/jasa4 @else {{url('/jasa/jasa4')}} @endif"><img src="/images/house2.jpg" alt="Image"></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

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