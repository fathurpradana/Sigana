<aside class="sidebar" aria-label="Navigasi SIGANA">
    <div class="brand">
        <div class="brand-icon" aria-hidden="true">
            <img src="{{ asset('images/sigana-mark.svg') }}" alt="" width="25" height="25">
        </div>
        <div>
            <h2 class="brand-name">SIGANA</h2>
            <p class="brand-caption">Monitoring Bencana Alam</p>
        </div>
    </div>

    <nav class="nav" aria-label="Menu utama">
        <a class="{{ request()->routeIs('dashboard', 'guest.home') ? 'active' : '' }}" href="{{ auth()->check() ? route('dashboard') : route('guest.home') }}"><span aria-hidden="true">⌂</span> Dashboard</a>
        <a class="{{ request()->routeIs('peta.*') ? 'active' : '' }}" href="{{ route('peta.index') }}"><span aria-hidden="true">◎</span> Peta</a>
        <a class="{{ request()->routeIs('bencana.*') ? 'active' : '' }}" href="{{ route('bencana.index') }}"><span aria-hidden="true">⚠</span> Bencana</a>
        <a class="{{ request()->routeIs('tips.*') ? 'active' : '' }}" href="{{ route('tips.index') }}"><span aria-hidden="true">♡</span> Tips &amp; darurat</a>
        <a class="{{ request()->routeIs('bantuan.index') ? 'active' : '' }}" href="{{ route('bantuan.index') }}"><span aria-hidden="true">◌</span> Bantuan</a>
        <a class="{{ request()->routeIs('bantuan.report*') ? 'active' : '' }}" href="{{ route('bantuan.report.form') }}"><span aria-hidden="true">＋</span> Lapor Bencana</a>
        <a class="{{ request()->routeIs('damage-scan.*') ? 'active' : '' }}" href="{{ route('damage-scan.index') }}"><span aria-hidden="true">⌕</span> Scan Kerusakan</a>
        <a class="{{ request()->routeIs('profil.*') ? 'active' : '' }}" href="{{ route('profil.index') }}"><span aria-hidden="true">♙</span> Profil</a>
    </nav>

    <div class="sidebar-bottom">
        <div class="emergency-card">
            <span>Keadaan darurat?</span>
            <strong>112</strong>
        </div>
        @if (auth()->check())
            <form class="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-button" type="submit">Keluar dari akun</button>
            </form>
        @else
            <a class="logout-button" href="{{ route('login') }}">Masuk ke akun</a>
        @endif
    </div>
</aside>
