@extends('dashboard/layouts/main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 ms-4 ">Tambah Course</h1>
    </div>

    <div class="container">
        <form action="{{ route('storeCourse') }}" method="post">
            @csrf

            <div class="mb-3">
                <label for="course" class="form-label block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama course</label>
                <input type="text" name="course" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('course') is-invalid @enderror" id="course" placeholder="Enter course name" required value="{{ old('course') }}">
                @error('course')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="mb-3">
                <label for="deskripsi" class="form-label block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <textarea name="deskripsi" class="form-control block w-full h-64 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('deskripsi') is-invalid @enderror" id="deskripsi" placeholder="Enter deskripsi" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="mb-3">
                <label for="start_date" class="form-label block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                <input type="date" name="start_date" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('start_date') is-invalid @enderror" id="start_date" required value="{{ old('start_date') }}">
                @error('start_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="mb-3">
                <label for="end_date" class="form-label block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                <input type="date" name="end_date" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('end_date') is-invalid @enderror" id="end_date" required value="{{ old('end_date') }}">
                @error('end_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Tambah Course!</button>
        </form>
    </div>
@endsection