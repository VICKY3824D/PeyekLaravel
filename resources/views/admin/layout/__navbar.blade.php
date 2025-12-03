<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('admin.index') }}">Peyek</a>
        <div class="ms-auto">
            @auth
                <span class="text-white me-3 fs-6 fw-bold">{{ Auth::user()->nama }}</span>
                <a class="nav-link d-inline text-white" href="{{ route('logout') }}"
                   onclick="event.preventDefault();if(confirm('Apakah anda yakin ingin Logout?')){ document.getElementById('logout-form').submit() }">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endauth
        </div>
    </div>
</nav>
