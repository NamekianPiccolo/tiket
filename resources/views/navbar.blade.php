<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="hypetix-red" href="#">
            <h1>
        Hypetix
            </h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Beranda</a>
                </li>



                @auth
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'tiket.customer' ? 'active' : '' }}" href="{{route('tiket.customer')}}">Tiket Saya</a>
                </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'keranjang.index' ? 'active' : '' }}" href="{{ route('keranjang.index') }}">Keranjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'transaksi.index' ? 'active' : '' }}" href="{{ route('transaksi.index') }}">Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ secure_url('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link px-3" style="cursor: pointer;">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth

                @if(!auth()->check())
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-primary login-btn" href="/login"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
