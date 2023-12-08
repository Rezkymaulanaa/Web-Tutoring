@extends('layouts.main')

<style>
    .heading {
        color: #00006b;
    }
</style>

@section('container')
    <div class="container py-5 my-4">
        <div class="row">
            <div class="col-md-8">
                <h2 class="heading">{{ $courseName }}</h2>
                <p>{{ $deskripsi }}</p>
            </div>
            <div class="col-md-4 justify-content-end d-flex">
                <div class="card" style="width: 20rem;height:12rem;">
                    <div class="card-body p-4">
                      <p class="card-title d-flex fs-6">Kelas : <span class="ms-auto fw-medium">{{ $courseName }}</span></p>
                      <hr>
                      <p class="card-text d-flex fs-6">Pengajar : <span class="ms-auto fw-medium">{{ $pengajar }}</span></p>
                      @php
                          $firstContent = $contents->first();
                          $hasContent = $firstContent !== null;
                      @endphp

                      @if($hasContent)
                          <a href="{{ route('show.content', ['courseName' => $courseName, 'judulMateri' => $firstContent->title]) }}" class="btn btn-warning text-white px-5 py-1 d-flex justify-content-center mb-2">Belajar</a>
                      @else
                          <button class="btn btn-secondary text-white py-1 w-100 d-flex justify-content-center mb-2" disabled>Tidak ada materi</button>
                      @endif
                    </div>
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <hr>
                <h2 class="heading mb-4">Daftar Materi</h2>
                <div class="accordion" id="accordionExample">
                    @forelse($contents as $content)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $content->id }}" aria-expanded="false" aria-controls="collapse{{ $content->id }}">
                                    {{ $content->title }}
                                </button>
                            </h2>
                            <div id="collapse{{ $content->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ Str::limit($content->content, 200) }}
                                    <hr>
                                    <p class="mb-1">Klik <span class="fw-medium">'Belajar'</span> untuk materi selengkapnya...</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info" role="alert">
                            Course ini belum memiliki materi.
                        </div>
                    @endforelse
                </div>
            </div>
            
        </div>
      
    </div>


@endsection