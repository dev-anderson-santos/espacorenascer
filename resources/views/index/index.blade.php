<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ config('app.name') }}</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-theme py-3" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#page-top">{{ config('app.name') }}</a>
                {{-- <img src="{{ asset('images/logo-sem-fundo.png') }}" alt="Logo"> --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#about">Sobre nós</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services">Salas</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="#portfolio">Localização</a></li> --}}
                        <li class="nav-item"><a class="nav-link" href="#localizacao">Localização</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contato</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Área do Cliente</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        {{-- <h1 class="text-white font-weight-bold">Your Favorite Place for Free Bootstrap Themes</h1> --}}
                        <img class="img-fluid" src="{{ asset('images/logo-2.png') }}" alt="Logo">
                        {{-- <hr class="divider" /> --}}
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white mb-5"><b>Planejando sublocar um lugar aconchegante para realizar seu trabalho? <br>O ESPAÇO JUNTOS pensou e organizou esse local para você.</b></p>
                        <a class="btn btn-theme btn-xl" href="#about">Saiba mais</a>
                    </div>
                </div>
            </div>
        </header>
        <!-- About-->
        <section class="page-section bg-theme" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="text-white mt-0">O Espaço que você precisa do jeito que você quer</h2>
                        <hr class="divider divider-light" />
                        <p class="text-white mb-4"><b>Você terapeuta está procurando um lugar para sublocar e desempenhar seu trabalho sem maiores preocupações? Venha conhecer o Espaço Juntos.</b></p>
                        <a class="btn btn-light btn-xl" href="#services">Conheça nossas salas</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services-->
        <section class="page-section" id="services">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0">Nossas salas</h2>
                <hr class="divider" />
                {{-- <div class="row gx-4 gx-lg-5">
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-gem fs-1 text-theme"></i></div>
                            <h3 class="h4 mb-2">Sturdy Themes</h3>
                            <p class="text-muted mb-0">Our themes are updated regularly to keep them bug free!</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-laptop fs-1 text-theme"></i></div>
                            <h3 class="h4 mb-2">Up to Date</h3>
                            <p class="text-muted mb-0">All dependencies are kept current to keep things fresh.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-globe fs-1 text-theme"></i></div>
                            <h3 class="h4 mb-2">Ready to Publish</h3>
                            <p class="text-muted mb-0">You can use this design as is, or you can make changes!</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-heart fs-1 text-theme"></i></div>
                            <h3 class="h4 mb-2">Made with Love</h3>
                            <p class="text-muted mb-0">Is it really open source if it's not made with love?</p>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
        <!-- Portfolio-->
        <div id="portfolio">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="{{ asset('images/salas/01.jpeg') }}" title="Espaço Juntos">
                            <img class="img-fluid" src="{{ asset('images/salas/01.jpeg') }}" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Espaço</div>
                                <div class="project-name">Juntos</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="{{ asset('images/salas/02.jpeg') }}" title="Espaço Juntos">
                            <img class="img-fluid" src="{{ asset('images/salas/02.jpeg') }}" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Espaço</div>
                                <div class="project-name">Juntos</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="{{ asset('images/salas/03.jpeg') }}" title="Espaço Juntos">
                            <img class="img-fluid" src="{{ asset('images/salas/03.jpeg') }}" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Espaço</div>
                                <div class="project-name">Juntos</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="{{ asset('images/salas/07.png') }}" title="Espaço Juntos">
                            <img class="img-fluid" src="{{ asset('images/salas/07.png') }}" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Espaço</div>
                                <div class="project-name">Juntos</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="{{ asset('images/salas/08.png') }}" title="Espaço Juntos">
                            <img class="img-fluid" src="{{ asset('images/salas/08.png') }}" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Espaço</div>
                                <div class="project-name">Juntos</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="{{ asset('images/salas/06.png') }}" title="Espaço Juntos">
                            <img class="img-fluid" src="{{ asset('images/salas/06.png') }}" alt="..." />
                            <div class="portfolio-box-caption p-3">
                                <div class="project-category text-white-50">Espaço</div>
                                <div class="project-name">Juntos</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <section class="page-section bg-theme" id="localizacao">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="text-white mt-0">Localização</h2>
                        <hr class="divider divider-light" />
                        <p class="text-white mb-4"><b>O espaço perfeito para você está localizado no coração de Nova Iguaçú, bem próximo a Via Light no centro comercial da cidade.</b></p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3447.6768083693264!2d-43.446646103036635!3d-22.75960642196577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x99670010b1275d%3A0x309493d995cb5039!2sR.%20Prof.%20Venina%20Correa%20Torres%2C%2017A%20-%20Centro%2C%20Nova%20Igua%C3%A7u%20-%20RJ%2C%2026221-200!5e0!3m2!1spt-BR!2sbr!4v1650679236821!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </section>
        <!-- Call to action-->
        <section class="page-section bg-dark text-white">
            <div class="container px-4 px-lg-5 text-center">
                <h2 class="mb-4">Venha reservar o seu Espaço!</h2>
                <a class="btn btn-light btn-xl" href="{{ route('user.guest-create') }}">Realizar cadastro</a>
            </div>
        </section>
        <!-- Contact-->
        <section class="page-section" id="contact">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h2 class="mt-0">Entre em contato!</h2>
                        <hr class="divider" />
                        <p class="text-muted mb-5">Pronto para iniciar seu próximo projeto conosco? Envie-nos uma mensagem e marque uma visita.</p>
                        <a href="https://wa.me/5521986022928" class="btn btn-primary btn-icon-split" style="background-color: rgb(69 90 100)!important; border-color:rgb(69 90 100)!important; padding: 1.25rem 2.25rem;
                        font-size: 0.85rem;
                        font-weight: 700;
                        text-transform: uppercase;
                        border: none;
                        border-radius: 10rem;">
                            <span class="text">Fale com a gente!</span>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="icon text-white-50">
                                <i class="fab fa-whatsapp" style="font-size: 24px;"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="bg-light py-5">
            <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} - {{ config('app.name') }}</div></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SimpleLightbox plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

        <link rel="stylesheet" href="https://cdn.positus.global/production/resources/robbu/whatsapp-button/whatsapp-button.css">
        <a id="robbu-whatsapp-button" target="_blank" href="https://api.whatsapp.com/send?phone=5521986022928&text=Olá, eu gostaria de agendar um horário.">
        <div class="rwb-tooltip">Posso Ajudar?</div>
        <img src="https://cdn.positus.global/production/resources/robbu/whatsapp-button/whatsapp-icon.svg">
        </a>
        <!-- /GetButton.io widget -->
    </body>
</html>
