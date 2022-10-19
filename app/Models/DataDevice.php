<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DataDevice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function device() {
        return $this->belongTo(User::class, 'device_id');
    }

    public function scopeFilter($query, array $fillters) {
        $query->when($fillters['created_at'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->whereDate('created_at',  $search == 0 ? $this->day($search) : $this->now());
            });
        });
    }

    public function day($subday){
        return Carbon::today()->subDay($subday);
    }

    public function now(){
        return Carbon::today();
    }
}
