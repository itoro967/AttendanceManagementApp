<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Work extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date',
        'begin_at',
        'finish_at',
    ];

    public function scopeToday(Builder $query): void
    {
        $query->where('user_id', Auth::user()->id)->where('date', today());
    }
    public function rests(): HasMany
    {
        return $this->hasMany(Rest::class);
    }

    /**
     * 労働時間取得
     *
     * @return integer seconds
     */
    public function getWorkTime(): int
    {
        $begin = Carbon::parse($this->begin_at);
        $finish = Carbon::parse($this->finish_at);
        return $finish->diffInSeconds($begin);
    }
    /**
     * 休憩時間取得
     *
     * @return integer seconds
     */
    public function getRestSum(): int
    {
        $totalDuration = 0;
        $restTimes = $this::rests()->select('begin_at', 'finish_at')->get();
        foreach ($restTimes as $restTime) {
            $begin = Carbon::parse($restTime->begin_at);
            $finish = Carbon::parse($restTime->finish_at);
            $duration = $finish->diffInSeconds($begin);
            $totalDuration += $duration;
        }
        return $totalDuration;
        // return $this::rests()->select('begin_at', 'finish_at');
    }
}
