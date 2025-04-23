<div class="sidebar d-flex flex-column justify-content-between" style="width: 250px; background-color: #FFFFFF; padding: 20px; border-radius: 0 16px 16px 0;">
    <div>
        <h3 class="text-center mb-4">Menu</h3>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" style="background-color: {{ request()->is('dashboard') ? '#279B48' : 'transparent' }}; color: {{ request()->is('dashboard') ? '#FFFFFF' : '#000000' }}; border-radius: 8px; padding: 8px 16px; display: block;">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="/medicines" class="nav-link {{ request()->is('medicines*') ? 'active' : '' }}" style="color: {{ request()->is('medicines*') ? '#279B48' : '#000000' }};">Inventaris</a>
            </li>
            <li class="nav-item">
                <a href="/transactions" class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}" style="color: {{ request()->is('transactions*') ? '#279B48' : '#000000' }};">Transaksi</a>
            </li>
            <li class="nav-item">
                <a href="/reports" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}" style="color: {{ request()->is('reports*') ? '#279B48' : '#000000' }};">Laporan</a>
            </li>
        </ul>
    </div>

    <div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/profile" class="nav-link {{ request()->is('profile') ? 'active' : '' }}" style="color: {{ request()->is('profile') ? '#279B48' : '#000000' }}; padding: 8px 16px;">Profile</a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link" style="color: #000000; text-align: left; padding: 8px 16px;">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>
