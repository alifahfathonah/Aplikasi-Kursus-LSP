@extends('master')
@section('mytitle', 'Jasa | Abu Properti')

<div class="jumbotron jumbotron-fluid text-center animate__animated animate__fadeIn" id="jb_tipe" style="background: url('/images/konstruksi.jpg');">
  <div class="container">
  </div>
</div>

<section class="projects" id="projects">
  <div class="container text-center">
    <div class="row">
      <div class="col-md-12">
        <h1>Jasa</h1>
        <h5>Jasa Konstruksi Terpercaya </h5>
        <p>Selain menjual asset properti, kami juga menyediakan jasa konstruksi untuk membangun rumah anda. Orang-orang kami sangat terampil, handal, dan sudah bekerja dibanyak konstruksi bangunan</p>
      </div>
    </div>
  </div>
</section>

<section class="all_nav" id="nav_jasa">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <ul class="nav justify-content-center">
          <li class="nav-item aktif" id="item1">
            <a class="nav-link">Konstruksi 1</a>
          </li>
          <li class="nav-item" id="item2">
            <a class="nav-link">Konstruksi 2</a>
          </li>
          <li class="nav-item" id="item3">
            <a class="nav-link">Konstruksi 3</a>
          </li>
          <li class="nav-item" id="item4">
            <a class="nav-link">Konstruksi 4</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="row" id="nav_content">
      <div class="col-md-4 offset-md-2" id="nav_desc">
        <h1>Konstruksi 1</h1>
        <p>Pembangunan Kenanga Residence, Pondok Rangon, Jakarta</p>
      </div>
      <div class="col-md-4">
        <img id="nav_image" src="/images/konstruksi1.jpg" alt="gambar" class="animate__animated animate__fadeIn">
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script type="text/javascript">

  $(function() {
    $('#item1').click(function() {
      $("#item1").addClass('aktif');$("#item2").removeClass('aktif');$("#item3").removeClass('aktif');$("#item4").removeClass('aktif');
      $("#nav_desc").children("h1").text('Konstruksi 1');
      $("#nav_desc").children("p").text('Pembangunan Kenanga Residence, Pondok Rangon, Jakarta');
      $("#nav_image").attr('src', "/images/konstruksi1.jpg").addClass("animate__animated animate__fadeIn");
      return false;
    });

    $('#item2').click(function() {
      $("#item1").removeClass('aktif');$("#item2").addClass('aktif');$("#item3").removeClass('aktif');$("#item4").removeClass('aktif');
      $("#nav_desc").children("h1").text('Konstruksi 2');
      $("#nav_desc").children("p").text('Pembangunan Kenanga Residence, Pondok Rangon, Jakarta');
      $("#nav_image").attr('src', "/images/konstruksi2.jpg");
      return false;
    });

    $('#item3').click(function() {
      $("#item1").removeClass('aktif');$("#item2").removeClass('aktif');$("#item3").addClass('aktif');$("#item4").removeClass('aktif');
      $("#nav_desc").children("h1").text('Konstruksi 3');
      $("#nav_desc").children("p").text('Pembangunan Kenanga Residence, Pondok Rangon, Jakarta');
      $("#nav_image").attr('src', "/images/konstruksi3.jpg");
      return false;
    });

    $('#item4').click(function() {
      $("#item1").removeClass('aktif');$("#item2").removeClass('aktif');$("#item3").removeClass('aktif');$("#item4").addClass('aktif');
      $("#nav_desc").children("h1").text('Konstruksi 4');
      $("#nav_desc").children("p").text('Pembangunan Kenanga Residence, Pondok Rangon, Jakarta');
      $("#nav_image").attr('src', "/images/konstruksi4.jpg");
      return false;
    });
  });
</script>