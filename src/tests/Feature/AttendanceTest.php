<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Work;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;
    private $attendanceUrl = '/attendance';
    private $punchUrl = '/attendance/punch';
    private $postCorrectUrl = '/attendance/correct';
    private $correctListUrl = '/stamp_correction_request/list';
    private $approvalUrl = '/stamp_correction_request/approve/';
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    //ID:5
    public function testStatus()
    {
        $user = User::where('is_admin', false)->latest()->first();
        $response = $this->actingAs($user)->get($this->attendanceUrl);
        $response->assertSee('勤務外');
        //出勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '1',
        ]);
        $response->assertSee('出勤中');

        //休憩入ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '2',
        ]);
        $response->assertSee('休憩中');

        //休憩戻ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '3',
        ]);
        $response->assertSee('出勤中');

        //退勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '9',
        ]);
        $response->assertSee('退勤済');
    }

    //ID:6
    public function testWork()
    {
        $user = User::where('is_admin', false)->latest()->first();
        $response = $this->actingAs($user)->get($this->attendanceUrl);
        //出勤ボタン表示確認
        $response->assertSee('<button name="punch" value="1" class="working-button">出勤</button>', false);
        //出勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '1',
        ]);
        //ステータス確認 
        $response->assertSee('出勤中');

        //退勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '9',
        ]);
        //出勤ボタンが表示されないこと
        $response->assertDontSee('<button name="punch" value="1" class="working-button">出勤</button>', false);

        //勤怠データが記録されているか確認
        $this->assertDatabaseHas('works', [
            'user_id' => $user->id,
            'date' => today(),
        ]);
    }

    //ID:7
    public function testRest()
    {
        $user = User::where('is_admin', false)->latest()->first();
        $response = $this->actingAs($user)->get($this->attendanceUrl);
        //出勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '1',
        ]);
        //休憩入ボタンが表示されていることを確認
        $response->assertSee('<button name="punch" value="2" class="working-button breaking">休憩 入</button>', false);
        //休憩入ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '2',
        ]);
        $response->assertSee('休憩中');
        //休憩戻ボタンが表示されていることを確認
        $response->assertSee('<button name="punch" value="3" class="working-button breaking">休憩 戻</button>', false);
        //休憩戻ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '3',
        ]);
        //休憩入ボタンが表示されていることを確認
        $response->assertSee('<button name="punch" value="2" class="working-button breaking">休憩 入</button>', false);
        $response->assertSee('出勤中');

        //休憩データが記録されているか確認
        $work = Work::where('user_id', $user->id)->where('date', today())->first();
        $this->assertDatabaseHas('rests', [
            'work_id' => $work->id,
        ]);
    }

    //ID:8
    public function testLeaveWorking()
    {
        $user = User::where('is_admin', false)->latest()->first();
        $response = $this->actingAs($user)->get($this->attendanceUrl);
        //出勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '1',
        ]);
        //退勤ボタンが表示されていることを確認
        $response->assertSee('<button name="punch" value="9" class="working-button">退勤</button>', false);
        //退勤ボタン押下
        $response = $this->actingAs($user)->post($this->punchUrl, [
            'punch' => '9',
        ]);

        $response->assertSee('退勤済');
        //勤怠データが記録されているか確認
        $this->assertDatabaseHas('works', [
            'user_id' => $user->id,
            'date' => today(),
        ]);
    }
    //ID:10
    public function testAttendanceDetailGet()
    {
        $user = User::where('is_admin', false)->latest()->first();
        $work = Work::where('user_id', $user->id)->first();
        $response = $this->actingAs($user)->get($this->attendanceUrl . '/' . $work->id);
        //名前がログインユーザーの名前になっているか確認
        $response->assertViewHas('work', function ($work) use ($user) {
            return $work->user->name == $user->name;
        });
        //日時が選択した日時になっているか確認
        $response->assertViewHas('work', function ($work) use ($user) {
            $w = Work::where('user_id', $user->id)->first();
            return $work->date == $w->date;
        });
        //「出勤・退勤」にて記されている時間がログインユーザーの打刻と一致しているか確認
        $response->assertViewHas('work', function ($work) use ($user) {
            $w = Work::where('user_id', $user->id)->first();
            return $work->begin_at == $w->begin_at
                && $work->finish_at == $w->finish_at;
        });
        //「休憩」にて記されている時間がログインユーザーの打刻と一致しているか確認
        $response->assertViewHas('work', function ($work) use ($user) {
            $w = Work::where('user_id', $user->id)->first();
            $length = $w->rests->count();
            for ($i = 0; $i < $length; $i++) {
                if (
                    $work->rests[$i]->begin_at != $w->rests[$i]->begin_at
                    || $work->rests[$i]->finish_at != $w->rests[$i]->finish_at
                ) {
                    return false;
                }
            }
            return true;
        });
    }
    //ID:11
    public function testAttendanceDetailCorrect()
    {
        $user = User::where('is_admin', false)->latest()->first();
        $work = Work::where('user_id', $user->id)->first();
        //出勤時間が退勤時間より後の場合
        $response = $this->actingAs($user)->post($this->postCorrectUrl, [
            'work_id' => $work->id,
            'date' => $work->date,
            'begin_at' => '09:00',
            'finish_at' => '08:00',
            'rest' => $work->rests->toArray(),
            'type' => $work->type + 1,
            'note' => 'テスト',
        ]);
        //メッセージが配列になっているため下記処理実行
        $errors = session('errors')->get('begin_at');
        $error_begin_at = $errors[0]['begin_at'];
        $this->assertEquals('出勤時間もしくは退勤時間が不適切な値です', $error_begin_at);
        //休憩開始時間が退勤時間より後になっている場合
        $response = $this->actingAs($user)->post($this->postCorrectUrl, [
            'work_id' => $work->id,
            'date' => $work->date,
            'begin_at' => '09:00',
            'finish_at' => '18:00',
            'rest' => [
                [
                    'begin_at' => '08:00',
                    'finish_at' => '13:00',
                ],
            ],
            'type' => $work->type + 1,
            'note' => 'テスト',
        ]);
        $response->assertInvalid([
            'rest.0.begin_at' => '休憩時間が勤務時間外です',
        ]);
        //休憩終了時間が退勤時間より後になっている場合
        $response = $this->actingAs($user)->post($this->postCorrectUrl, [
            'work_id' => $work->id,
            'date' => $work->date,
            'begin_at' => '09:00',
            'finish_at' => '18:00',
            'rest' => [
                [
                    'begin_at' => '10:00',
                    'finish_at' => '19:00',
                ],
            ],
            'type' => $work->type + 1,
            'note' => 'テスト',
        ]);
        $response->assertInvalid([
            'rest.0.finish_at' => '休憩時間が勤務時間外です',
        ]);
        //備考欄が未入力の場合
        $response = $this->actingAs($user)->post($this->postCorrectUrl, [
            'work_id' => $work->id,
            'date' => $work->date,
            'begin_at' => $work->begin_at,
            'finish_at' => $work->finish_at,
            'rest' => $work->rests->toArray(),
            'type' => $work->type + 1,
            'note' => '',
        ]);
        $response->assertInvalid([
            'note' => '備考を入力してください',
        ]);
        //正常な値の場合
        $correctData = [
            'work_id' => $work->id,
            'date' => $work->date,
            'begin_at' => '09:00',
            'finish_at' => '18:00',
            'rest' => $work->rests->toArray(),
            'type' => $work->type + 1,
            'note' => 'テスト',
        ];
        $response = $this->actingAs($user)->post($this->postCorrectUrl,$correctData);
        $response->assertValid();
        //管理者ユーザーで承認画面と申請一覧画面を確認
        $admin = User::where('is_admin', true)->latest()->first();
        $response = $this->actingAs($admin)->get($this->correctListUrl);
        //申請一覧画面に申請が表示されているか確認
        $response->assertViewHas('corrects', function ($corrects) use ($user) {
            return $corrects->where('user_id', $user->id)->count() == 1;
        });
        //承認画面に表示されているか確認
        $correct_id = Work::where('user_id', $user->id)->where('note','テスト',)->first()->id;
        $response = $this->actingAs($admin)->get($this->approvalUrl . $correct_id);
        $response->assertViewHas('work', function ($work) use ($user) {
            return $work->user->id == $user->id;
        });
    }
}
