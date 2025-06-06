@extends('layouts.app')
@section('content')
    <div class="main">
        @if(session('success'))
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

        <form method="POST" action="{{ route('user-setting.display.update', $user->id) }}">
            @csrf
            <div class="card">
                <h2>Pengaturan Tampilan</h2>

                <div class="row">
                    <label for="language">Bahasa</label>
                    <select name="language" id="language">
                        <option value="id" {{ $tampilan->language == 'id' ? 'selected' : '' }}>Indonesia</option>
                        <option value="en" {{ $tampilan->language == 'en' ? 'selected' : '' }}>English</option>
                        <option value="ko" {{ $tampilan->language == 'ko' ? 'selected' : '' }}>한국어</option>
                        <option value="zh" {{ $tampilan->language == 'zh' ? 'selected' : '' }}>中文</option>
                    </select>
                    <div id="google_translate_element"></div>
                </div>

                <div class="row">
                    <label for="font_family">Jenis Huruf</label>
                    <select name="font_family" id="font_family">
                        @foreach($availableFonts as $font)
                            <option value="{{ $font->name }}" {{ $tampilan->font_family == $font->name ? 'selected' : '' }}>
                                {{ $font->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <label for="text_size">Ukuran Teks</label>
                    <select name="text_size" id="text_size">
                        <option value="default" {{ $tampilan->text_size == 'default' ? 'selected' : '' }}>Default</option>
                        <option value="small" {{ $tampilan->text_size == 'small' ? 'selected' : '' }}>Kecil</option>
                        <option value="medium" {{ $tampilan->text_size == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="large" {{ $tampilan->text_size == 'large' ? 'selected' : '' }}>Besar</option>
                        <option value="extra_large" {{ $tampilan->text_size == 'extra_large' ? 'selected' : '' }}>Sangat Besar</option>
                    </select>
                </div>

                <div class="row">
                    <label for="dark_mode">Mode Gelap</label>
                    <select name="dark_mode" id="dark_mode">
                        <option value="0" {{ !$tampilan->dark_mode ? 'selected' : '' }}>Non Aktif</option>
                        <option value="1" {{ $tampilan->dark_mode ? 'selected' : '' }}>Aktif</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="save">Simpan Pengaturan</button>
        </form>
    </div>
@endsection