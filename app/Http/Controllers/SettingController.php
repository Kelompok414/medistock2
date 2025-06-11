<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use App\Models\Font;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan tampilan untuk user yang login.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil atau buat pengaturan tampilan
        $tampilan = Setting::firstOrCreate(
            ['user_id' => $user->id],
            [
                'language'     => 'id',
                'text_size'    => 'default',
                'font_family'  => 'Default',
                'dark_mode'    => false,
            ]
        );

        $availableFonts = Font::all();

        $fontSizeValue = $this->mapTextSizeToPixels($tampilan->text_size);

        $selectedFont   = $availableFonts->firstWhere('name', $tampilan->font_family);
        $fontFamilyCss  = $selectedFont ? $selectedFont->css_family : 'Arial, sans-serif';
        $googleFontName = $selectedFont ? $selectedFont->google_font_name : null;

        return view('display', compact(
            'user',
            'tampilan',
            'fontSizeValue',
            'fontFamilyCss',
            'googleFontName',
            'availableFonts'
        ));
    }

    /**
     * Menyimpan perubahan pengaturan tampilan.
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user
        $user = Auth::user();

        $validated = $request->validate([
            'language'     => 'required|string|in:id,en,ko,zh',
            'text_size'    => 'required|string|in:default,small,medium,large,extra_large',
            'font_family'  => 'required|string|exists:fonts,name|max:50',
            'dark_mode'    => 'required|boolean',
        ]);

        Setting::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()
            ->route('user-setting.display')
            ->with('success', 'Pengaturan tampilan berhasil diperbarui.');
    }

    protected function mapTextSizeToPixels(string $size): string
    {
        return match ($size) {
            'small'       => '12px',
            'default'     => '16px',
            'medium'      => '18px',
            'large'       => '22px',
            'extra_large' => '26px',
            default       => '16px',
        };
    }
}
