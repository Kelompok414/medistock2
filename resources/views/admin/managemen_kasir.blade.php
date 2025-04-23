<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akses Kasir</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar for navigation -->
        <aside class="sidebar">
            <h1>Manajemen Akses Kasir</h1>
            <form action="{{ route('managemen_kasir_create_view') }}" method="GET">
                @csrf
                <button type="submit" class="add-user-btn">Tambah Pengguna Baru</button>
            </form>
        </aside>

        <!-- Main content -->
        <section class="main-content">
            <div class="search-bar">
                <input type="text" placeholder="Search">
            </div>
            <div class="user-list">
                @foreach($users as $user)
                    <div class="user-card">
                        <!-- <p>Kode User: {{ $user->kode_user }}</p> -->
                        <p>Nama: {{ $user->nama }}</p>
                        <p>Role: {{ $user->role }}</p>
                        <form action="{{ route('managemen_kasir_update_view', $user->id) }}" method="GET">
                            @csrf
                            <button class="edit-btn">Edit</button>
                        </form>
                        <form action="{{ route('managemen_kasir.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="delete-btn">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</body>
</html>