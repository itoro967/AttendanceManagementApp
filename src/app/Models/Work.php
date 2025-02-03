<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Work extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date',
        'begin_at',
        'finish_at',
        'note'
    ];
    public function scopeToday(Builder $query): void
    {
        $query->where('user_id', Auth::user()->id)->where('date', today());
    }
}
