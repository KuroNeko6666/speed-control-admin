<?php

namespace App\Models;

use App\Models\DataDevice;
use App\Models\UserDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function data() {
        return $this->hasMany(DataDevice::class, 'device_id');
    }

    public function user() {
        return $this->hasMany(UserDevice::class, 'device_id');
    }

    public function scopeFilter($query, array $fillters) {
        $query->when($fillters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('id', 'like', '%'. $search. '%')
                ->orWhere('name', 'like', '%'. $search. '%')
                ->orWhere('location', 'like', '%'. $search. '%');
            });
        });
    }
}
