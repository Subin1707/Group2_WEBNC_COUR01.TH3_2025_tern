<section id="footer" class="bg-black text-white pt-5">
    <div class="container">
        <div class="row">
            <!-- 🏢 Giới thiệu -->
            <div class="col-md-4 mb-4">
                <h3>
                    <a class="text-white text-decoration-none" href="{{ url('/') }}">
                        <i class="fa fa-video-camera text-danger me-2"></i> Q&HCinema
                    </a>
                </h3>
                <p class="mt-3">
                    © {{ date('Y') }} Rạp Chiếu Phim Q&H | Developed by 
                    <strong>Nguyễn Mạnh Quyền</strong> & <strong>Phạm Văn Hoàng</strong> 🎥
                </p>
                <p class="mb-1"><i class="fa fa-map-marker text-danger me-2"></i>Đại học Phenikaa, Yên Nghĩa, Hà Đông</p>
                <p class="mb-1"><i class="fa fa-envelope text-danger me-2"></i>23010245@st.phenikaa-uni.edu.vn</p>
                <p class="mb-0"><i class="fa fa-phone text-danger me-2"></i>+84 9856 193 47</p>
            </div>

            <!-- 🖼️ Ảnh nhỏ -->
            <div class="col-md-4 mb-4">
                <h4>Flickr <span class="text-danger">Stream</span></h4>
                <div class="row mt-3 g-2">
                    @for ($i = 4; $i <= 11; $i++)
                        <div class="col-3">
                            <a href="#">
                                <img src="{{ asset('img/' . $i . '.jpg') }}" alt="img" class="img-fluid rounded">
                            </a>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- ✉️ Đăng ký nhận tin -->
            <div class="col-md-4 mb-4">
                <h4>Đăng ký <span class="text-danger">Bản tin</span></h4>
                <p class="mt-3">Nhập email để nhận thông tin phim mới nhất và khuyến mãi hấp dẫn!</p>
                <div class="input-group">
                    <input type="email" class="form-control bg-black text-white border-secondary" placeholder="Email của bạn">
                    <button class="btn btn-danger text-white rounded-0">Subscribe</button>
                </div>

                <ul class="social-network social-circle mt-4 mb-0 list-inline">
                    <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-youtube"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- 🌙 Footer cuối -->
<section id="footer_b" class="pt-3 pb-3 bg-light text-dark border-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <p class="mb-0">© {{ date('Y') }} Q&HCinema. All Rights Reserved.</p>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="list-inline-item"><a href="{{ route('movies.index') }}">Phim</a></li>
                    <li class="list-inline-item"><a href="{{ route('theaters.index') }}">Rạp</a></li>
                    <li class="list-inline-item"><a href="{{ route('aboutme') }}">Giới thiệu</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // 🧭 Sticky navbar (nếu có phần header có id="navbar_sticky")
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('navbar_sticky');
        if (!navbar) return;
        const sticky = navbar.offsetTop;
        const navbarHeight = navbar.offsetHeight;
        if (window.pageYOffset >= sticky + navbarHeight) {
            navbar.classList.add('sticky');
            document.body.style.paddingTop = navbarHeight + 'px';
        } else {
            navbar.classList.remove('sticky');
            document.body.style.paddingTop = '0';
        }
    });
</script>
@endpush
