@extends('layouts.main')

@section('container')
    <style>
        .heading {
            color: #00006b;
        }
        .container h1 {
            font-size: 3.5rem;
        }

        .about-section img{
            width: 150px;
        }
        .sub-heading {
            color: #38B6FF;
        }
        .label {
            height: 30px;
            align-items: center;
            justify-content: center;
            margin-top: 35px;
            right: 0;
            bottom: 45%;
        }
        .kontak {
            width: 40px;
            height: 40px;
            background-color: rgb(0, 156, 0);
            right: 15px;
            bottom: 15px;
        } 
        .carousel-control-prev {
            height: 90px;
            width: 90px;
            top: 41%;
        }
        .carousel-control-next {
            height: 90px;
            width: 90px;
            top: 41%;
        }
    </style>

    <section class="home-section py-5" id="home-section">
        <div class="container d-flex ">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    <h6 class="text-secondary">INGIN BELAJAR MUDAH ?</h6>
                    <h1 class="heading fw-bold mt-3">Belajar Disini Aja</h1>
                    <p class="mt-4">Dengan materi mudah dimengerti dan berbentuk video sehingga membantu proses pembelajaran anda</p>
                    <a href="{{ route('courses.index') }}"><button class="btn btn-warning mt-4 text-white px-5 py-2 fw-medium rounded-pill">Belajar Sekarang</button></a>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('images/edu-logo.png') }}" alt="edu-logo">
                </div>
            </div>
        </div>
    </section>

    <hr  id="about-section">

    <section class="py-5 my-5 about-section" >
        <!-- Konten untuk bagian About -->
        <h1 class="heading fw-medium fs-1 text-center ">Tentang Kami</h1>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <div class="cards text-center">
                        <img class="bg-white" src="{{ asset('images/students-logo.png') }}" alt="student-logo">
                        <h1 class="sub-heading">200.000+</h1>
                        <p>Siswa Mendaftar</p>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <div class="cards text-center">
                        <img src="{{ asset('images/teachers-logo.png') }}" alt="student-logo">
                        <h1 class="sub-heading">50.000+</h1>
                        <p>Guru Bergabung</p>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <div class="cards text-center">
                        <img src="{{ asset('images/courses-logo.png') }}" alt="student-logo">
                        <h1 class="sub-heading">550.000+</h1>
                        <p>Materi untuk melatih kemampuan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr  id="populer-section">

    <section class="py-5 my-5 populer-section">
        <!-- Konten untuk bagian Populer -->
        <h1 class="heading fw-medium fs-1 mb-5 text-center">Course Populer</h1>
    
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($courses->chunk(3) as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $course)
                                <div class="col-md-4 my-3">
                                    <div class="card">
                                        <div class="label d-flex bg-warning position-absolute px-3 rounded-start">
                                            <p class="fw-medium fst-italic my-auto mx-auto"><small>{{ $course->start_date }} - {{ $course->end_date }}</small></p>
                                        </div>
                                        <img src="{{ asset('images/kelas.png') }}" class="card-img-top mx-auto" alt="math-logo" style=" object-fit:contain;width:16rem;">
                                        <hr>
                                        <div class="card-body">
                                            @if(auth()->check() && auth()->user()->role === 'Siswa')
                                                <div class="progress mb-3 w-50">
                                                    <div class="progress-bar overflow-visible" role="progressbar" style="width: {{ $course->userProgress }}%;" aria-valuenow="{{ $course->userProgress }}" aria-valuemin="0" aria-valuemax="100">{{ round($course->userProgress) }}%</div>
                                                </div>
                                            @endif
                                          <h5 class="card-title">{{ $course->course }}</h5>
                                          <p class="card-text">{{ Str::limit($course->deskripsi, 200) }}</p>
                                          <h6 class="card-title mb-3"><small>Pengajar: {{ $course->pengajar_nama }}</small></h6>
                                          @auth
                                            <a href="{{ route('content.index', ['courseName' => $course->course]) }}" class="btn btn-warning text-white w-25">Lihat</a>
                                            <div class="kontak d-flex position-absolute rounded-circle shadow">
                                                <a class="text-decoration-none mx-auto my-auto" href="https://api.whatsapp.com/send/?phone=6282293000500&text=Halo Kak&type=phone_number&app_absent=0" target="_blank"><i class="bi bi-whatsapp fs-5 text-white"></i></a>
                                            </div>
                                            @else
                                            <a href="{{ route('login') }}" class="btn btn-warning text-white w-25">Lihat</a>
                                          @endauth
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev bg-dark d-flex align-items-center" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next bg-dark" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    
    
@endsection