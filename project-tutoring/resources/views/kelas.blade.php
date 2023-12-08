@extends('layouts.main')

@section('container')
    <style>
        .heading {
            margin-top: 1rem;
            color: #00006b;
        }
        .row {
            margin-top: 24px;
        }
        .label{
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
            outline: 5px solid white;
        }
    </style>


    <h1 class="heading fw-medium fs-1 text-center">Daftar Kelas</h1>

    <form action="{{ route('course.search') }}" method="GET">
        <div class="input-group my-4 mx-auto" style="width: 500px;">
            <input type="text" class="form-control" placeholder="Search" autocomplete="off" name="search" value="{{ request('search') }}">
            <button class="btn btn-warning text-white w-25" type="submit">Search</button>
        </div>
    </form>

    <div class="container mb-5 mt-4">
        <div class="row">
            @forelse ($courses as $course)
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
            @empty
            <div class="col-md-12">
                <p class="text-center align-items-center fs-4 fw-light">The course you are looking for does not exist.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection