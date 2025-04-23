<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Akun</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script>
        function editField(id) {
            const field = document.getElementById(id);
            field.removeAttribute('readonly');
            field.focus();
        }

        function togglePassword() {
            const passField = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");
            if (passField.type === "password") {
                passField.type = "text";
                eyeIcon.src = "{{ asset('img/eye.svg') }}";
            } else {
                passField.type = "password";
                eyeIcon.src = "{{ asset('img/eye-off.svg') }}";
            }
        }

        function toggleTwoStep(id) {
            const field = document.getElementById(id);
            field.value = field.value === "Aktif" ? "Non Aktif" : "Aktif";
        }
    </script>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="sidebar-top">
            <h3>Pengaturan</h3>
            <button class="menu active">
                <img src="{{ asset('img/user.svg') }}"> Akun
            </button>
            <button class="menu">
                <img src="{{ asset('img/monitor.svg') }}"> Tampilan
            </button>
        </div>
        <div class="sidebar-bottom">
            <div class="logout">
                <button><img src="{{ asset('img/log-out.svg') }}"> Log Out</button>
            </div>
            <div class="profile">
                <img src="{{ asset('img/download.png') }}" alt="user">
                <div>
                    <p>{{ $user->username }}</p>
                    <small>Admin</small>
                </div>
            </div>
        </div>
    </div>

    <div class="main">
    @if (session('success'))
    <div style="background-color: #d4edda; padding: 10px; margin-bottom: 10px; border: 1px solid #c3e6cb; color: #155724;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="background-color: #f8d7da; padding: 10px; margin-bottom: 10px; border: 1px solid #f5c6cb; color: #721c24;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin: 5px 0 0 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        <form method="POST" action="{{ route('user-setting.update', $user->id) }}">
            @csrf
            <div class="card">
                <h2>Info pribadi</h2>

                <div class="row">
                    <label>Nama Pengguna</label>
                    <input type="text" name="username" id="username" value="{{ $user->username }}" readonly>
                    <button type="button" onclick="editField('username')"><img src="{{ asset('img/edit.svg') }}"></button>
                </div>
                <div class="row">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="dob" id="dob" value="{{ \Carbon\Carbon::parse($user->dob)->format('Y-m-d') }}" readonly>
                    <button type="button" onclick="editField('dob')"><img src="{{ asset('img/edit.svg') }}"></button>
                </div>
                <div class="row">
                    <label>Gender</label>
                    <select name="gender" id="gender">
                        <option value="Laki-laki" {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                     </select>
                </div>
                <div class="row">
                    <label>Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" readonly>
                    <button type="button" onclick="editField('email')"><img src="{{ asset('img/edit.svg') }}"></button>
                </div>
                <div class="row">
                    <label>Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ $user->phone }}" readonly>
                    <button type="button" onclick="editField('phone')"><img src="{{ asset('img/edit.svg') }}"></button>
                </div>
            </div>

            <div class="card">
                <h2>Sandi & Keamanan</h2>

                <div class="row">
                    <label>Sandi</label>
                    <input type="password" id="password" value="********" readonly>
                    <button type="button" onclick="editField('password')"><img src="{{ asset('img/edit.svg') }}"></button>
                    <button type="button" onclick="togglePassword()"><img id="eyeIcon" src="{{ asset('img/eye-off.svg') }}"></button>
                </div>
                <div class="row">
                    <label>Verifikasi 2 Langkah</label>
                    <input type="text" name="two_step_verification" id="twoStep" value="{{ $user->two_step_verification ? 'Aktif' : 'Non Aktif' }}" readonly>
                    <button type="button" onclick="toggleTwoStep('twoStep')"><img src="{{ asset('img/edit.svg') }}"></button>
                </div>
                <div class="row">
                    <label>Perangkat Anda</label>
                    <input type="text" name="device" value="{{ $user->device }}" readonly>
                </div>
                <div class="row">
                    <label>Email Pemulihan</label>
                    <input type="email" name="recovery_email" id="emailpm" value="{{ $user->recovery_email }}" readonly>
                    <button type="button" onclick="editField('emailpm')"><img src="{{ asset('img/edit.svg') }}"></button>
                </div>
                <div class="row">
                    <label>Telepon Pemulihan</label>
                    <input type="text" name="recovery_phone" id="telppm" value="{{ $user->recovery_phone }}" readonly>
                    <button type="button" onclick="editField('telppm')"><img src="{{ asset('img/edit.svg') }}"></button>
                </div>
                <div class="row">
                    <label>Notifikasi Keamanan</label>
                    <input type="text" name="security_notification" id="notif" value="{{ $user->security_notification ? 'Aktif' : 'Non Aktif' }}" readonly>
                    <button type="button" onclick="toggleTwoStep('notif')"><img src="{{ asset('img/edit.svg') }}"></button>
                </div>
            </div>

            <button type="submit" class="save">Simpan Pengaturan</button>
        </form>
    </div>
</div>
<script>
    document.querySelector('form').addEventListener('submit', function () {
        document.querySelectorAll('input').forEach(input => {
            input.removeAttribute('readonly');
        });
    });
</script>

</body>
</html>
