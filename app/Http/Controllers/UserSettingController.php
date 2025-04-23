<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function index()
    {
        $user = UserSetting::find(1);
        if (!$user) {
            abort(404, "UserSetting not found");
        }

        return view('user-setting', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'two_step_verification' => 'string',
            'device' => 'nullable|string',
            'recovery_email' => 'nullable|email',
            'recovery_phone' => 'nullable|string',
            'security_notification' => 'string',
        ]);

        $user = UserSetting::findOrFail($id);
        $user->update($data);
        $user->dob = \Carbon\Carbon::parse($user->dob)->format('Y-m-d');

        return redirect()->route('user-setting.index')->with('success', 'Pengaturan berhasil disimpan.');

    }
}
