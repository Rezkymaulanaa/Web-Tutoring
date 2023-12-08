@extends('dashboard/layouts/main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 ms-4 ">Tambah Materi</h1>
    </div>

    <form action="{{ route('storeContent') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Materi</label>
            <input type="text" name="title" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title') is-invalid @enderror" id="title" placeholder="Masukkan title materi" required value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label block mb-2 text-sm font-medium text-gray-900 dark:text-white">Isi Materi</label>
            <textarea name="content" class="form-control block w-full h-64 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('content') is-invalid @enderror" id="content" placeholder="Masukkan isi content" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="course" class="form-label">Select Course</label>
            <select class="form-select" id="course" name="course" required>
                <option value="">Select a Course</option>
                @if($courses)
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label block mb-2 text-sm font-medium text-gray-900 dark:text-white">Link Youtube (Opsional)</label>
            <input type="text" name="link" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('link') is-invalid @enderror" id="link" placeholder="Masukkan link youtube" autocomplete="off" required value="{{ old('link') }}">
            @error('link')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Tambahkan Materi!</button>

    </form>
@endsection