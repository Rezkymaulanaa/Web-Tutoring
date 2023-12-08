<style>
    .footer {
        background-color: #112849;  
        width: 100%;
        padding: 2rem 7%;
    }

    .heading-foot .social .bi-instagram{
        color: #f10079;
    }
    .heading-foot .social .bi-tiktok{
        color: #000000;
    }
    .heading-foot .social .bi-facebook{
        color: #004cf1;
    }

    .footer .container h6{
        color: white;
        margin-top: 25px; 
        margin-bottom: 16px; 
    }
    .footer .container p {
        color: #a6ddfc;
        opacity: .8;
    }
    .footer .container a {
        color: #a6ddfc;
        opacity: .8;
    }
</style>

<footer class="footer">
    <div class="heading-foot d-flex mt-2"> 
        <a class="navbar-brand" href=""><img class="me-2" src="{{ asset('images/eduLearn-logo.png') }}" alt="" style="width: 50px;"><span class="brand-logo fw-bold fs-3 my-auto">EduLearn</span></a>
        <div class="social ms-auto">
            <a href="https://www.instagram.com/rezkyymaulana_/" target="_blank"><i class="bi bi-instagram fs-3"></i></a>
            <a href=""><i class="bi bi-tiktok fs-3 mx-3"></i></a>
            <a href=""><i class="bi bi-facebook fs-3"></i></a>
        </div>
    </div>

    <hr class="text-white mt-4">
    
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h6>Untuk Murid</h6>
                <p><small>EduLearn Video</small></p>
                <p><small>EduLearn School</small></p>
                <p><small>EduLearn Campus</small></p>

                <h6>Untuk guru</h6>
                <p><small>EduLearn School</small></p>
            </div>
            <div class="col-md-3">
                <h6>Tentang EduLearn</h6>
                <p><small>EduLearn Indonesia</small></p>
                <p><small>Karier</small></p>
                <p><small>Media</small></p>
                <p><small>EduLearn Blog</small></p>
            </div>
            <div class="col-md-3">
                <h6>PT EduLearn Indonesia</h6>
                <p><small>Gedung Kalla, 3rd floor <br>
                    Jalan A. Mappanyukki No.50,<br> Kunjung Mae, Kec. Mariso,<br> Kota Makassar, Sulawesi Selatan <br>90113</small></p>
                <p><i class="bi bi-telephone"></i><span class="ms-3">0822-9300-0500</span></p>
                <p><i class="bi bi-envelope"></i><span class="ms-3">info-id@edulearn.com</span></p>
                <h6>Customer Service</h6>
                <a class="text-decoration-none" href="https://api.whatsapp.com/send/?phone=6282293000500&text&type=phone_number&app_absent=0"><i class="bi bi-whatsapp"></i><span class="ms-3">0822-9300-0500</span></a>
            </div>
            <div class="col-md-3">
                <h6>Download Aplikasi EduLearn</h6>
                <img src="{{ asset('images/eduLearn-app.png') }}" alt="eduLearn App" style="width: 250px">
            </div>
        </div>

        <hr class="text-white mt-5">
    
        <div>
            <div class="foot-items d-flex">
                <p><small>&copy; 2023.All rights reserved.</small></p>

                <div class="d-flex ms-auto">
                    <p><small>Syarat & Ketentuan</small></p>
                    <p class="mx-4"><small>Kebijakan Privasi</small></p>
                    <p><small>Hubungi Kami</small></p>
                </div>
            </div>
        </div>
    </div>

</footer>