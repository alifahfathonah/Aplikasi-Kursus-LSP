@extends('master')
@section('mytitle', 'Contact Us | Abu Properti')

<div class="jumbotron jumbotron-fluid animate__animated animate__fadeIn" id="jb_contact">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-12" id="jb_contact_isi">
                <h1>CONTACT US</h1>
                <p>For more information, fill in your contact details and we’ll get back to you. </p>
            </div>
        </div>
    </div>
</div>

<!-- Contact-us -->
<section class="isi_contact text-center" id="isi_contact">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-1" id="isi_contact_kiri">
                <div class="row">
                    <div class="col-sm-12" id="isi_contact_judul">
                        <h4>Contact Us</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" id="contact_picture">
                        <img src="@if (!empty($pages -> photo)) /images/upload/profile/{{$pages->photo}} @elseif (!empty($adminPages->photo)) /images/upload/profile/{{$adminPages->photo}} @else /images/default_user.png @endif" alt="image">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" id="isi_contact_hubungi">
                        <p>
                            @if(!empty($pages))
                            {{$pages->telp}}
                            <br>
                            {{$pages->email}}
                            @else
                            {{$adminPages->telp}}
                            <br>
                            {{$adminPages->email}}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" id="isi_contact_alamat">
                        <p>
                            @if(!empty($pages))
                            {{$pages->alamat}}
                            @else
                            {{$adminPages->alamat}}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" id="isi_contact_icon">
                        <a href="@if (!empty($social) && !empty($social->facebook)) https://www.facebook.com/{{$social->facebook}} @else https://www.facebook.com/abuproperti @endif"><i class="lab la-facebook la-3x animate__animated animate__tada animate__delay-3s" id="contact_fb"></i></a>
                        <a href="@if (!empty($pages)) https://web.whatsapp.com/send?phone={{$pages->telp}} @else https://web.whatsapp.com/send?phone={{$adminPages->telp}} @endif"><i class="la la-whatsapp la-3x animate__animated animate__tada animate__delay-3s" id="contact_wa"></i></a>
                        <a href="@if (!empty($social) && !empty($social->instagram)) https://www.instagram.com/{{$social->instagram}} @else https://www.instagram.com/abuproperti @endif "><i class="la la-instagram la-3x animate__animated animate__tada animate__delay-3s" id="contact_ig"></i></a>
                    </div>
                </div>
                <a href="https://www.google.com/maps/place/National+Monument/@-6.1753871,106.8249641,17z/data=!3m1!4b1!4m5!3m4!1s0x2e69f5d2e764b12d:0x3d2ad6e1e0e9bcc8!8m2!3d-6.1753924!4d106.8271528?shorturl=1" class="btn btn_saya">Direction</a>
            </div>
            <div class="col-md-6 animate__animated animate__fadeInRight" id="isi_contact_kanan">
                <form action="/pesan/add" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputName">Name</label>
                            <input type="text" class="form-control" id="inputName" name="inputName" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Phone</label>
                            <input type="tel" class="form-control" id="inputPhone" name="inputPhone" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="inputMessage">Message</label>
                        <textarea name="inputMessage" placeholder="" id="inputMessage" required></textarea>
                    </div>
                    <input type="hidden" id="user" name="user" value="@if (empty($pages) == true) admin @else {{$pages -> username}} @endif">
                    <button type="submit" class="btn btn_saya">Send</button>
                </form>
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p><b>{!! \Session::get('success') !!}</b></p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <section class="animate__animated animate__fadeIn animate__delay-2s" id="google_map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.66642700975!2d106.82496411518467!3d-6.17539239552917!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sNational%20Monument!5e0!3m2!1sen!2sid!4v1593204445889!5m2!1sen!2sid" class="mt-5" frameborder="0" style="border:0; width: 100%; height: 800px;" allowfullscreen="" aria-hidden="false" tabindex="0">
        </iframe>
    </section>
</section>