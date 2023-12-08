@extends('layouts.main')

<style>
    .background {
        height: 200px;
        background: linear-gradient(to right, lightyellow, lightpink);
    }
    .white-background {
        padding: 30px 35px;
    }
    .white-background-2 {
        padding: 20px;
        height: 500px;
        width: 270px;
        position: absolute;
        overflow-y: scroll
    }
    .profile {
        margin-top: 120px;
        margin-left: 35px;
    }
    .profile-2 {
        width: 35px;
    }
    .nama {
        padding-top: 70px;   
    }
    .email {
        margin-top: -10px;
    }
    .kontak {
        width: 40px;
        height: 40px;
        background-color: rgb(0, 156, 0);
        outline: 5px solid white;
    }
</style>

@section('container')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-9">
                <div class="background shadow rounded-top w-100">
                    <a href=""><img class="profile p-1 bg-white rounded-circle position-absolute" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo"></a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="white-background-2 shadow rounded">
                    <h5 class="mb-4">People Associated</h5>
                    @foreach ($users as $users)
                        @if ($users->id !== auth()->user()->id) <!-- Memastikan bukan pengguna yang sedang login -->
                            @if (auth()->user()->role === 'Guru' && $users->role === 'Guru')
                                <a href=""><img class="profile-2 rounded-circle mb-2" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo"></a>
                                <h6><small>{{ $users->nama }}</small></h6>
                                <p class="text-secondary"><small>{{ $users->role }}</small></p>
                                <hr>
                            @elseif (auth()->user()->role === 'Siswa' && $users->role === 'Siswa')
                                <a href=""><img class="profile-2 rounded-circle mb-2" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo"></a>
                                <h6><small>{{ $users->nama }}</small></h6>
                                <p class="text-secondary"><small>{{ $users->role }}</small></p>
                                <hr>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="white-background shadow rounded-bottom w-100 bg-white">
                    <h3 class="nama">{{ $user->nama }}</h3>
                    <p class="lokasi text-secondary"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" zoomAndPan="magnify" viewBox="2 0 30 30.000001" height="25" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="id1"><path d="M 2.128906 5.222656 L 27.53125 5.222656 L 27.53125 15 L 2.128906 15 Z M 2.128906 5.222656 " clip-rule="nonzero"/></clipPath><clipPath id="id2"><path d="M 2.128906 14 L 27.53125 14 L 27.53125 23.371094 L 2.128906 23.371094 Z M 2.128906 14 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#id1)"><path fill="rgb(86.268616%, 12.159729%, 14.898682%)" d="M 24.703125 5.222656 L 4.957031 5.222656 C 3.398438 5.222656 2.132812 6.472656 2.132812 8.015625 L 2.132812 14.296875 L 27.523438 14.296875 L 27.523438 8.015625 C 27.523438 6.472656 26.261719 5.222656 24.703125 5.222656 Z M 24.703125 5.222656 " fill-opacity="1" fill-rule="nonzero"/></g><g clip-path="url(#id2)"><path fill="rgb(93.328857%, 93.328857%, 93.328857%)" d="M 27.523438 20.578125 C 27.523438 22.121094 26.261719 23.371094 24.703125 23.371094 L 4.957031 23.371094 C 3.398438 23.371094 2.132812 22.121094 2.132812 20.578125 L 2.132812 14.296875 L 27.523438 14.296875 Z M 27.523438 20.578125 " fill-opacity="1" fill-rule="nonzero"/></g></svg><small class="ms-2">Makassar, Indonesia</small></p>
                    <p class="email"><i class="bi bi-envelope me-2 fs-5"></i>{{ $user->email }}</p>
                    <div class="kontak d-flex rounded-circle shadow">
                        <a class="text-decoration-none mx-auto my-auto p-2" href="https://api.whatsapp.com/send/?phone=6282293000500&text=Halo Kak&type=phone_number&app_absent=0" target="_blank"><i class="bi bi-whatsapp fs-5 text-white"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @if(auth()->user() && auth()->user()->role !== 'Siswa')
            <div class="row py-3">
                <div class="col-md-9">
                    <div class="white-background shadow rounded w-100 bg-white">
                        <h3 class="course mb-4">Course</h3>
                        @foreach ($courses as $course)
                            <a href="" class="btn btn-outline-dark shadow-sm">{{ $course->course }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection