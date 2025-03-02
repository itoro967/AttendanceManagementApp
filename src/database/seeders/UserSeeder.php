<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use InvalidArgumentException;

class UserSeeder extends Seeder
{
    /**
     * 時刻生成
     *
     * @param string $min hh:mm:ss
     * @param string $max hh:mm:ss
     * @return string hh:mm:ss
     */
    private function randTime(string $min, string $max): string
    {

        $time1 = strtotime($min);
        $time2 = strtotime($max);
        $timeDelta = $time2 - $time1;
        if ($timeDelta < 0) {
            throw new InvalidArgumentException('$time2は$time1よりも大きい必要があります。');
        }
        $time = $time1 + rand(0, $timeDelta);

        return date('H:i:s', $time);
    }
    public function run(): void
    {
        #NOTE 連続した日付を作りたかったためFactory不使用
        $startDate = now();
        for ($i = -30; $i < 0; $i++) {
            $dateArray[] = $startDate->copy()->addDays($i)->toDateString();
        }
        $users = User::factory()->count(10)->create();
        foreach ($users as $user) {
            foreach ($dateArray as $date) {
                $work = $user->works()->create([
                    'date' => $date,
                    'begin_at' => $this->randTime('08:00:00', '08:29:59'),
                    'finish_at' =>  $this->randTime('17:15:00', "20:59:59"),
                    'type' => 0,
                ]);
                $work->rests()->create([
                    'begin_at' => $this->randTime('12:00:00', '12:10:00'),
                    'finish_at' =>  $this->randTime('12:50:00', "13:00:00")
                ]);
                $work->rests()->create([
                    'begin_at' => $this->randTime('15:00:00', '15:10:00'),
                    'finish_at' =>  $this->randTime('15:20:00', "15:30:00")
                ]);
            }
        }
    }
}
