@extends('layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

<style>

    :root {
        --white: #fff;
        --bg: #f5f5f5;
        --text: #333;
        --light-gray: #ddd;
        --border-radius: 10px;
        --shadow: 0 2px 8px rgba(0, 0, 0, 0.05);

        
        --body-bg: var(--bg);
        --body-text: var(--text);
        --container-bg: var(--white);
        --sidebar-bg: var(--white); 
        --main-bg: var(--white);
        --card-bg: var(--white);
        --input-bg: #f9f9f9;
        --input-border: var(--light-gray);
        --button-text-default: #555; 
        --menu-hover-bg: #efefef;
        --menu-active-bg: #279B48; 
        --menu-active-text: var(--white);
        --link-color: #007bff; 
        --profile-small-text: #666; 
        --success-bg: #d4edda;
        --success-text: #155724;
        --success-border: #c3e6cb;
        --error-bg: #f8d7da;
        --error-text: #721c24;
        --error-border: #f5c6cb;
        --save-button-bg: #E53935; 
        --save-button-hover-bg: #45a049;
    }

    body.dark-mode {
        --body-bg: #1a202c;
        --body-text: #e2e8f0;
        --container-bg: #2d3748;
        --sidebar-bg: #374151;
        --main-bg: #2d3748;
        --card-bg: #374151;
        --input-bg: #4b5563;
        --input-border: #6b7280;
        --button-text-default: #e2e8f0;
        --menu-hover-bg: #4a5568;
        --menu-active-bg: #38a169; 
        --menu-active-text: var(--white);
        --link-color: #9cb3d4;
        --profile-small-text: #a0aec0;
        --success-bg: #38a169;
        --success-text: #e2e8f0;
        --success-border: #2f855a;
        --error-bg: #e53e3e;
        --error-text: #e2e8f0;
        --error-border: #c53030;
        --save-button-bg: #8b1f1f; 
        --save-button-hover-bg: #2f855a; 
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: var(--body-bg);
        color: var(--body-text);
        transition: background-color 0.3s ease, color 0.3s ease;
        min-height: 100vh; 
        display: flex;
        flex-direction: column;
    }

    
    .main-content-inner {
        flex: 1; 
        background-color: var(--main-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: var(--shadow);
        color: var(--body-text);
        display: flex;
        flex-direction: column;
        overflow-y: auto; 
        margin: 20px; 
        max-width: calc(100% - 40px); 
        align-self: center; 
    }

    .card {
        background-color: var(--card-bg);
        padding: 20px;
        margin-bottom: 25px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        color: var(--body-text);
        display: flex;
        flex-direction: column;
    }

    .card h2 {
        font-size: 18px;
        margin-bottom: 20px;
        color: var(--body-text);
    }

    .row {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        gap: 10px; 
    }

    .row label {
        width: 160px;
        font-weight: bold;
        color: var(--body-text);
        flex-shrink: 0; 
    }

    .row .col-md-8 { 
        flex: 1; 
        display: flex; 
        align-items: center;
        gap: 8px; 
    }

    .row input,
    .row select {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid var(--input-border);
        border-radius: 6px;
        font-size: 14px;
        background-color: var(--input-bg);
        color: var(--body-text);
        transition: background-color 0.3s, border-color 0.3s, color 0.3s;
        width: 100%;
    }

    .row input:focus,
    .row select:focus {
        outline: none;
        background-color: var(--input-bg);
        border-color: var(--link-color);
    }

    
    .btn {
        border-radius: 8px;
        padding: 8px 15px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }

    
    .btn-icon.btn-light-warning {
        background: none;
        border: none;
        padding: 4px 7px;
        font-size: 16px; 
        box-shadow: none;
        color: var(--button-text-default);
        flex-shrink: 0; 
    }

    .btn-icon.btn-light-warning:hover {
        color: var(--link-color);
    }

    .btn-icon.btn-light-warning i {
        width: 16px; 
        height: 16px;
        vertical-align: middle;
    }

    body.dark-mode .btn-icon.btn-light-warning i {
        filter: invert(1) hue-rotate(180deg) brightness(1.5);
    }

    
    .btn-sm.btn-outline-secondary {
        background: none;
        border: 1px solid var(--input-border);
        color: var(--body-text);
        padding: 4px 10px;
        font-size: 12px;
        flex-shrink: 0;
    }

    .btn-sm.btn-outline-secondary:hover {
        background-color: var(--menu-hover-bg);
        border-color: var(--menu-hover-bg);
    }

    .btn-sm.btn-outline-secondary img {
        width: 16px;
        height: 16px;
    }

    body.dark-mode .btn-sm.btn-outline-secondary img {
        filter: invert(1) hue-rotate(180deg) brightness(1.5);
    }

    /* Tombol Simpan */
    .save {
        background: var(--save-button-bg);
        color: var(--white);
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        cursor: pointer;
        float: right; 
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .save:hover {
        background-color: var(--save-button-hover-bg);
    }

    .success, .error {
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }

    .success {
        background-color: var(--success-bg);
        color: var(--success-text);
        border: 1px solid var(--success-border);
    }

    .error {
        background-color: var(--error-bg);
        color: var(--error-text);
        border: 1px solid var(--error-border);
    }

    .error ul {
        padding-left: 20px;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        body {
            padding: 0;
        }

        .main-content-inner {
            padding: 15px; 
            margin: 0; 
            max-width: 100%; 
            border-radius: 0; 
            overflow-y: visible; 
        }

        .card {
            padding: 15px;
            border-radius: 0; 
        }

        .row {
            flex-direction: column; 
            align-items: flex-start; 
            gap: 5px; 
        }

        .row label {
            width: 100%; 
            margin-bottom: 0;
        }

        .row .col-md-8 {
            width: 100%;
            flex-wrap: wrap;  
            gap: 5px; 
        }

        .row input,
        .row select {
            width: 100%; 
            flex: none; 
        }

        .save {
            float: none; 
            width: 100%; 
            align-self: center; 
            margin-top: 20px;
        }
    }
</style>

<div class="main-content-inner"> 

    
    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="card p-8">
            <h2>Info pribadi</h2>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Nama Pengguna</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="text" name="name" id="username" value="{{ old('name', $user->name) }}" readonly class="form-control" required>
                    <button type="button" onclick="editField('username')" class="btn btn-icon btn-light-warning">
                        <i data-feather="edit-3"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Tanggal Lahir</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="date" name="birthday" id="dob" value="{{ old('birthday', \Carbon\Carbon::parse($user->birthday)->format('Y-m-d')) }}" readonly class="form-control" required> 
                    <button type="button" onclick="editField('dob')" class="btn btn-icon btn-light-warning">
                        <i data-feather="edit-3"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Gender</label>
                <div class="col-md-8 d-flex align-items-center">
                    <select name="gender" id="gender" class="form-select" disabled required>
                        <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <button type="button" onclick="editField('gender', 'select')" class="btn btn-icon btn-light-warning">
                        <i data-feather="edit-3"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Email</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" readonly class="form-control" required>
                    <button type="button" onclick="editField('email')" class="btn btn-icon btn-light-warning">
                        <i data-feather="edit-3"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Sandi</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="password" id="password" value="{{ old('password', $user->password) }}" readonly class="form-control" required>
                    <button type="button" onclick="togglePassword()" class="btn btn-sm btn-outline-secondary ms-2">
                        <img id="eyeIcon" src="{{ asset('img/eye-off.svg') }}" alt="Toggle Password">
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Telepon</label>
                <div class="col-md-8 d-flex align-items-center">
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" readonly class="form-control" required>
                    <button type="button" onclick="editField('phone')" class="btn btn-icon btn-light-warning">
                        <i data-feather="edit-3"></i>
                    </button>
                </div>
            </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary save mt-4">Simpan Pengaturan</button>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
    });

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            form.querySelectorAll('input, select').forEach(element => {
                element.removeAttribute('readonly');
                element.removeAttribute('disabled');
            });
        });
    });


    function editField(id, type = 'input') { 
        const field = document.getElementById(id);
        if (type === 'input') {
            if (field.hasAttribute('readonly')) {
                field.removeAttribute('readonly');
                field.focus();
            } else {
                field.setAttribute('readonly', true);
            }
        } else if (type === 'select') {
            if (field.hasAttribute('disabled')) {
                field.removeAttribute('disabled');
                field.focus();
            } else {
                field.setAttribute('disabled', true);
            }
        }
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