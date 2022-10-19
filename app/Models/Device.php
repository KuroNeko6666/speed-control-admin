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
}
