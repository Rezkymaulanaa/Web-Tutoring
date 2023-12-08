@extends('dashboard/layouts/main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 ms-4 ">Edit User: {{ $user->nama }}</h1>
    </div>

    <div class="container">
        <form action="{{ route('update', $user) }}" method="POST">
            @csrf
            @method('PUT')
             <div class="flex-column">
                <label for="nama">Nama Lengkap </label>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="nama"><i class="bi bi-person-vcard fs-5"></i></label>
                <input type="text" name="nama" class="form-control border-light-subtle rounded-end px-2 @error('nama') is-invalid @enderror" id="nama" placeholder="Enter your nama" required value="{{ $user->nama }}">
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="flex-column">
                <label for="username">Username </label>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="username"><i class="bi bi-person-badge fs-5"></i></label>
                <input type="text" name="username" class="form-control border-light-subtle rounded-end px-2 @error('username') is-invalid @enderror" id="username" placeholder="Enter your username" required value="{{ $user->username }}">
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="flex-column">
                <label for="email">Email </label>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="email"><i class="bi bi-envelope fs-5"></i></label>
                <input type="text" name="email" class="form-control border-light-subtle rounded-end px-2 @error('email') is-invalid @enderror" id="email" placeholder="Enter your Email" required value="{{ $user->email }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            

            <div class="flex-column">
                <label for="role">Tipe Akun </label>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="role"><i class="bi bi-person-fill fs-5"></i></label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" id="role" >
                    @if ($user->role === 'Guru')
                        <option value="Guru" selected>Guru</option>
                        <option value="Siswa">Siswa</option>
                    @elseif ($user->role === 'Siswa')
                        <option value="Siswa" selected>Siswa</option>
                        <option value="Guru">Guru</option>
                    @endif
                </select>
                @error('role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Simpan Perubahan</button>
        </form>
    </div>
@endsection