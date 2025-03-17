<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;
    private $attendanceUrl = '/attendance';
    private $punchUrl = '/attendance/punch';
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    #ID:5
    public function testStatus()
    {
        $user = User::latest()->first();
        $response = $this->actingAs($user)->get($this->attendanceUrl);
        $response->assertSee('勤務外');
        #出勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '1',
        ]);
        $response->assertSee('出勤中');

        #休憩入ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '2',
        ]);
        $response->assertSee('休憩中');

        #休憩戻ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '3',
        ]);
        $response->assertSee('出勤中');

        #退勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '9',
        ]);
        $response->assertSee('退勤済');
    }

    #ID:6
    public function testWorking()
    {
        $user = User::latest()->first();
        $response = $this->actingAs($user)->get($this->attendanceUrl);
        $response->assertSee('<button name="punch" value="1" class="working-button">出勤</button>', false);

        #出勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '1',
        ]);
        #退勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '9',
        ]);
        $response->assertDontSee('<button name="punch" value="1" class="working-button">出勤</button>', false);

        $admin = User::where('email', 'admin@admin.jp')->first();
        $response = $this->actingAs($admin)->get($this->attendanceUrl);

        #勤怠データが記録されているか確認
        $this->assertDatabaseHas('works', [
            'user_id' => $user->id,
            'date' => today(),
        ]);
    }
}
