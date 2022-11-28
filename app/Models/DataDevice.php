<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Device;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataDevice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function device() {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function scopeFilter($query, array $fillters) {
        $query->when($fillters['created_at'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->whereDate('created_at',  $search == 0 ? $this->day($search) : $this->now());
            });
        });

        $query->when($fillters['search'] ?? false, function ($query, $search) {
            return $query->whereHas('device', function($query) use ($search) {
                $query->where('name', 'like', '%'. $search. '%')
                ->orWhere('location', 'like', '%'. $search. '%')
                ->orWhere('id', 'like', '%'. $search. '%');
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
