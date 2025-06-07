<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting as Tampilan; // Menggunakan alias Tampilan untuk model Setting
use App\Models\User; // Menggunakan model User yang baru
use App\Models\Font;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan tampilan untuk user tertentu.
     */
    public function index()
    {
        // Pastikan user yang login adalah user yang sama dengan ID di URL
        $user = Auth::user();

        $user = User::findOrFail($user->id); // Menggunakan model User

        $tampilan = Tampilan::firstOrCreate(
            ['user_id' => $user->id],
            [
                'language'   => 'id',
                'text_size'  => 'default',
                'font_family' => 'Default',
                'dark_mode'  => false,
            ]
        );

        // Ambil semua font yang tersedia dari database
        $availableFonts = Font::all();

        // Mapping ukuran teks ke nilai piksel untuk diterapkan di Blade
        $fontSizeValue = $this->mapTextSizeToPixels($tampilan->text_size);

        // Cari CSS family dan Google Font name untuk font yang dipilih user
        $selectedFont = $availableFonts->firstWhere('name', $tampilan->font_family);
        $fontFamilyCss = $selectedFont ? $selectedFont->css_family : 'Arial, sans-serif';
        $googleFontName = $selectedFont ? $selectedFont->google_font_name : null;

        return view('display', compact('user', 'tampilan', 'fontSizeValue', 'fontFamilyCss', 'googleFontName', 'availableFonts'));
    }

    /**
     * Memperbarui pengaturan tampilan untuk user tertentu.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $user = User::findOrFail($user->id); // Menggunakan model User

        // Validasi input
        $validated = $request->validate([
            'language'   => 'required|string|in:id,en,ko,zh',
            'text_size'  => 'required|string|in:default,small,medium,large,extra_large',
            'font_family' => 'required|string|max:50|exists:fonts,name',
            'dark_mode'  => 'required|in:0,1',
        ]);

        $validated['dark_mode'] = $validated['dark_mode'] === '1';

        Tampilan::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()
            ->route('user-setting.display', ['id' => $user->id])
            ->with('success', 'Pengaturan tampilan berhasil diperbarui.');
    }

    /**
     * Helper function to map text size to pixel values.
     */
    protected function mapTextSizeToPixels(string $size): string
    {
        switch ($size) {
            case 'small':
                return '12px';
            case 'default':
                return '16px';
            case 'medium':
                return '18px';
            case 'large':
                return '22px';
            case 'extra_large':
                return '26px';
            default:
                return '16px'; // Default fallback
        }
    }
}
