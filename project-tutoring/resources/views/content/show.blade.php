@extends('layouts.main')

<style>
    .back {
        right: 9%;
        bottom: 0;
        transform: translateY(170px)
    }
</style>

@section('container')
    <div class="container my-5">
        <div class="row mb-5">
            <div class="col-md-8">
                <iframe class="rounded shadow" width="750" height="450" src="{{ $youtubeEmbedLink }}" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="col-md-4 justify-content-end d-flex">
                <div class="card" style="width: 20rem;">
                    <div class="card-body p-4">
                      <p class="card-title d-flex fs-6">Kelas : <span class="ms-auto fw-medium">{{ $course->course }}</span></p>
                      <hr>
                      <p class="card-text d-flex fs-6">Pengajar : <span class="ms-auto fw-medium">{{ $pengajar }}</span></p>
                      <p class="card-text d-flex fs-6">Daftar Materi : </p>
                      @foreach ($contents as $singleContent)
                        @if ($singleContent->title === $judulMateri)
                            <a href="{{ route('tampil.content', ['courseName' => $course->course, 'judulMateri' => $singleContent->title]) }}" class="btn btn-warning shadow-sm text-white px-3 py-1 d-flex justify-content-start mb-2">
                                {{ $singleContent->title }}
                            </a>
                        @else
                            <a href="{{ route('tampil.content', ['courseName' => $course->course, 'judulMateri' => $singleContent->title]) }}" class="btn btn-light text-dark px-3 py-1 d-flex justify-content-start mb-2">
                                {{ $singleContent->title }}
                            </a>
                        @endif
                    @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <hr>
                <h1 class="mt-5 mb-3">{{ $content->title }}</h1>
                <p>{{ $content->content }}</p>
            </div>
            <div class="col-md-4">
                <div class="back position-absolute d-flex rounded-circle" >
                    <a href="{{ route('content.index', ['courseName' => $course->course]) }}"><i class="bi bi-arrow-left-circle-fill text-warning fs-1 "></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
