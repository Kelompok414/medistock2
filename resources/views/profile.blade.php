@extends('layouts.app')

@section('content')
<div class="main-content-inner"> {{-- Wrapper untuk konten spesifik halaman --}}

    <form method="POST" action="{{ route('user-setting.update', ['id' => $user->id]) }}">
        @csrf
        <div class="card p-8">
            <h2>Info pribadi</h2>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Nama Pengguna</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="text" name="name" id="username" value="{{ $user->name }}" readonly class="form-control"> {{-- Gunakan 'name' sesuai model User --}}
                    <button type="button" onclick="editField('username')" class="btn btn-icon btn-light-warning"
                        style="border-radius: 8px; padding: 4px 7px; font-size: 16px; margin-right: 4px; box-shadow: none;"><i data-feather="edit-3"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Tanggal Lahir</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="date" name="birthday" id="dob" value="{{ \Carbon\Carbon::parse($user->birthday)->format('Y-m-d') }}" readonly class="form-control"> {{-- Gunakan 'birthday' sesuai model User --}}
                    <button type="button" onclick="editField('dob')" class="btn btn-icon btn-light-warning"
                        style="border-radius: 8px; padding: 4px 7px; font-size: 16px; margin-right: 4px; box-shadow: none;"><i data-feather="edit-3"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Gender</label>
                <div class="col-md-8">
                    <select name="gender" id="gender" class="form-select">
                        <option value="Laki-laki" {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Email</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="email" name="email" id="email" value="{{ $user->email }}" readonly class="form-control">
                    <button type="button" onclick="editField('email')" class="btn btn-icon btn-light-warning"
                        style="border-radius: 8px; padding: 4px 7px; font-size: 16px; margin-right: 4px; box-shadow: none;"><i data-feather="edit-3"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Sandi</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="password" id="password" value="********" readonly class="form-control">
                    <!-- <button type="button" onclick="editField('password')" class="btn btn-icon btn-light-warning"
                        style="border-radius: 8px; padding: 4px 7px; font-size: 16px; margin-right: 4px; box-shadow: none;"><i data-feather="edit-3"></i>
                    </button> -->
                    <button type="button" onclick="togglePassword()" class="btn btn-sm btn-outline-secondary ms-2"><img id="eyeIcon" src="{{ asset('img/eye-off.svg') }}" alt="Toggle Password"></button>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Telepon</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="text" name="phone" id="phone" value="{{ $user->phone }}" readonly class="form-control">
                    <button type="button" onclick="editField('phone')" class="btn btn-icon btn-light-warning"
                        style="border-radius: 8px; padding: 4px 7px; font-size: 16px; margin-right: 4px; box-shadow: none;"><i data-feather="edit-3"></i>
                    </button>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary save mt-4">Simpan Pengaturan</button>
    </form>
</div>

@push('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function() {
        document.querySelectorAll('input').forEach(input => {
            input.removeAttribute('readonly');
        });
    });

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
@endpush

@endsection