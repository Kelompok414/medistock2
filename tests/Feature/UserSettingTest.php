<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_setting_page_is_accessible(): void
    {
        $user = User::factory()->create();

        UserSetting::create([
            'user_id' => $user->id,
            'username' => 'cinta',
            'email' => 'cinta@example.com',
            'phone' => '08111222333',
            'password' => bcrypt('password'),
            'dob' => '2000-08-17',
            'gender' => 'Perempuan',
            'two_step_verification' => true,
            'device' => 'Asus ROG',
            'recovery_email' => 'cinta.backup@example.com',
            'recovery_phone' => '08111222111',
            'security_notification' => true,
        ]);

        $this->actingAs($user)
             ->get('/user-setting')
             ->assertStatus(200);
    }

    public function test_user_can_update_info_pribadi(): void
    {
        $user = User::factory()->create();

        $userSetting = UserSetting::create([
            'user_id' => $user->id,
            'username' => 'cinta',
            'email' => 'cinta@example.com',
            'phone' => '08111222333',
            'password' => bcrypt('password'),
            'dob' => '2000-08-17',
            'gender' => 'Perempuan',
            'two_step_verification' => true,
            'device' => 'Asus ROG',
            'recovery_email' => 'cinta.backup@example.com',
            'recovery_phone' => '08111222111',
            'security_notification' => true,
        ]);

        $this->actingAs($user)
             ->post("/user-setting/update/{$userSetting->id}", [
                 'username' => 'budi',
                 'dob' => '1990-01-01',
                 'gender' => 'Laki-laki',
                 'phone' => '08123456789',
                 'email' => 'budi@example.com',
             ])
             ->assertRedirect('/user-setting');

        $this->assertDatabaseHas('user_settings', [
            'id' => $userSetting->id,
            'username' => 'budi',
            'dob' => '1990-01-01',
            'gender' => 'Laki-laki',
            'phone' => '08123456789',
            'email' => 'budi@example.com',
        ]);
    }
}
