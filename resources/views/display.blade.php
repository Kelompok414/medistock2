@extends('layouts.app')

@section('content')
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

        .success,
        .error {
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

            .row-language {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 20px;
                flex-wrap: wrap; 
            }

            .row-language label {
                flex-shrink: 0;
                font-weight: 600;
                color: #444;
                width: 180px;
                margin-right: 6px;
            }

            .row-language select {
                width: 180px; 
                padding: 6px 10px;
                font-size: 14px;
                border-radius: 6px;
                border: 1px solid #ccc;
                background-color: #fff;
                color: #333;
            }

            #google_translate_element {
                min-width: 160px;
                flex-shrink: 0;
                display: flex; 
                align-items: center;
            }

            #google_translate_element .goog-te-gadget-simple {
                font-family: Arial, sans-serif !important;
                background-color: #f9f9f9 !important;
                border: 1px solid #ccc !important;
                border-radius: 6px !important;
                padding: 5px 8px !important;
                line-height: normal !important;
                display: inline-block !important;
                box-shadow: none !important;
                color: #333 !important;
                vertical-align: middle;
                height: 38px; 
            }

            #google_translate_element .goog-te-gadget-simple .goog-te-menu-value span {
                color: #333 !important;
            }

            #google_translate_element .goog-te-gadget-simple a {
                color: #007BFF !important;
                text-decoration: none !important;
            }

           
            body > .skiptranslate,
            .goog-tooltip,
            .goog-tooltip:hover,
            .goog-tooltip-parent {
                display: none !important;
            }
        }
    </style>


    @if ($googleFontName)
        <link href="https://fonts.googleapis.com/css2?family={{ urlencode($googleFontName) }}:wght@400;700&display=swap" rel="stylesheet">
    @endif

    <div class="main-content-inner">
        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error">
                <strong>Terjadi kesalahan:</strong>
                <ul style="margin: 5px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('user-setting.display.update') }}">
            @csrf
            <div class="card">
                <h2>Pengaturan Tampilan</h2>

                
                <div class="row row-language">
                    <label for="language_select">Bahasa</label>
                    <select name="language" id="language_select">
                        <option value="id" {{ $tampilan->language == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="en" {{ $tampilan->language == 'en' ? 'selected' : '' }}>English</option>
                        <option value="ko" {{ $tampilan->language == 'ko' ? 'selected' : '' }}>한국어 (Korean)</option>
                        <option value="zh" {{ $tampilan->language == 'zh' ? 'selected' : '' }}>中文 (Chinese Simplified)</option>
                    </select>
                    <div id="google_translate_element"></div>
                </div>

                <div class="row">
                    <label for="text_size">Ukuran Teks</label>
                    <select name="text_size" id="text_size">
                        <option value="small" {{ $tampilan->text_size == 'small' ? 'selected' : '' }}>Kecil</option>
                        <option value="default" {{ $tampilan->text_size == 'default' ? 'selected' : '' }}>Default</option>
                        <option value="medium" {{ $tampilan->text_size == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="large" {{ $tampilan->text_size == 'large' ? 'selected' : '' }}>Besar</option>
                        <option value="extra_large" {{ $tampilan->text_size == 'extra_large' ? 'selected' : '' }}>Sangat Besar</option>
                    </select>
                </div>

                <div class="row">
                    <label for="font_family">Jenis Huruf</label>
                    <select name="font_family" id="font_family">
                        @foreach ($availableFonts as $font)
                            <option value="{{ $font->name }}" {{ $tampilan->font_family == $font->name ? 'selected' : '' }}
                                @if ($font->google_font_name) data-google-font="{{ $font->google_font_name }}" @endif>
                                {{ $font->name }}
                            </option>
                        @endforeach
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

    @push('scripts')
    <script type="text/javascript">
        
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en,zh-CN,ko', 
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeSelect = document.getElementById('dark_mode');
            const textSizeSelect = document.getElementById('text_size');
            const fontFamilySelect = document.getElementById('font_family');
            const languageSelect = document.getElementById('language_select');
            const body = document.body;

            const fontSizeMap = {
                'small': '12px',
                'default': '14px',
                'medium': '16px',
                'large': '18px',
                'extra_large': '20px'
            };

        
            function applyGoogleTranslate(langCode) {

                if (typeof google !== 'undefined' && google.translate && google.translate.TranslateElement) {
                    const googleWidget = document.querySelector('#google_translate_element .goog-te-combo');
                    if (googleWidget) {
                        googleWidget.value = langCode;
                        googleWidget.dispatchEvent(new Event('change')); 
                    } else {
                        
                        setTimeout(() => applyGoogleTranslate(langCode), 200);
                    }
                } else {
                    console.warn('Google Translate API not fully loaded or available. Retrying...');
                    setTimeout(() => applyGoogleTranslate(langCode), 500);
                }
            }

        
            function applyDisplaySettings() {
                
                if (darkModeSelect.value === '1') {
                    body.classList.add('dark-mode');
                } else {
                    body.classList.remove('dark-mode');
                }

                
                const selectedTextSize = textSizeSelect.value;
                body.style.fontSize = fontSizeMap[selectedTextSize] || '14px';

                
                const selectedFontOption = fontFamilySelect.options[fontFamilySelect.selectedIndex];
                const selectedFontName = selectedFontOption.value;
                const googleFontName = selectedFontOption.dataset.googleFont;

                if (googleFontName) {
                    if (!document.head.querySelector(`link[href*="family=${encodeURIComponent(googleFontName)}"]`)) {
                        const link = document.createElement('link');
                        link.href = `https://fonts.googleapis.com/css2?family=${encodeURIComponent(googleFontName)}:wght@400;700&display=swap`;
                        link.rel = 'stylesheet';
                        document.head.appendChild(link);
                    }
                    body.style.fontFamily = `'${selectedFontName}', sans-serif`;
                } else {
                    body.style.fontFamily = `'${selectedFontName}', sans-serif`;
                }
            }

            
            applyDisplaySettings();
            
            setTimeout(() => {
                applyGoogleTranslate(languageSelect.value);
            }, 500); 

            
            darkModeSelect.addEventListener('change', applyDisplaySettings);
            textSizeSelect.addEventListener('change', applyDisplaySettings);
            fontFamilySelect.addEventListener('change', applyDisplaySettings);
            languageSelect.addEventListener('change', function() {
                applyGoogleTranslate(this.value);
            });
        });
    </script>
    @endpush
@endsection