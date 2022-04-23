@extends('layouts.app')

@section('content')
<style>
  .center-image {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 70%;
    /* width: -webkit-fill-available; */
  }
  
</style>
<div class="container">
    <div class="row">
      <div class="col-md-12">
        <img src="{{ asset('images/logo.jpeg') }}" alt="" class="center-image">
      </div>
    </div>
    
    <div class="row mt-5 mb-5 text-center">
      <div class="col-md-12">
        <strong style="font-size: 30px; font-family: &quot;Source Sans Pro&quot;, sans-serif;">Escolha uma sala perfeita para você.</strong>
      </div>
    </div>
    
    <div class="row mb-2">
      <div class="col-md-6">
        <div class="card">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{ asset('images/salas/sala_01.webp') }}" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/salas/sala_01.webp') }}" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/salas/sala_01.webp') }}" class="d-block w-100" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </button>
          </div>
          <div class="card-body">
            <h5 class="card-title text-primary">Sala 101</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators1" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators1" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators1" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{ asset('images/salas/sala_02.webp') }}" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/salas/sala_02.webp') }}" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/salas/sala_02.webp') }}" class="d-block w-100" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators1" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators1" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </button>
          </div>
          <div class="card-body">
            <h5 class="card-title text-success">Sala 102</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
    </div>
</div>
  <!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted">
  <!-- Section: Social media -->
  <section
    class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom"
  >
    <!-- Left -->
    <div class="me-5 d-none d-lg-block">
      <span>Get connected with us on social networks:</span>
    </div>
    <!-- Left -->

    <!-- Right -->
    <div>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-google"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-linkedin"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-github"></i>
      </a>
    </div>
    <!-- Right -->
  </section>
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="">
    <div class="container text-center text-md-start mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>{{ env('APP_NAME') }}
          </h6>
          <p>
            Here you can use rows and columns to organize your footer content. Lorem ipsum
            dolor sit amet, consectetur adipisicing elit.
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Contato
          </h6>
          <p><i class="fas fa-home me-3"></i> Nova Iguaçu, RJ 10012, US</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            danielamontechiaregentil@gmail.com
          </p>
          <p><i class="fas fa-phone me-3"></i> + 55 21 234 567 88</p>
          <p><i class="fas fa-print me-3"></i> + 55 21 234 567 89</p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © {{ \Carbon\Carbon::now()->format('Y') }} Copyright:
    <a class="text-reset fw-bold" href="#">{{ env('APP_NAME')}}</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->
@endsection