<?php

namespace App\Http\Livewire\Home;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Device;
use Livewire\Component;
use App\Models\DataDevice;
use App\Http\Livewire\Home\DataSidebar;

class Dashboard extends Component
{
    public $user;
    public $users, $admins, $operators, $devices;

    public function  mount(){
        $this->user = auth()->user();
        $this->users = User::all()->count();
        $this->devices = Device::all()->count();
        $this->admins = Admin::latest()->filter(['role' => 'admin'])->count();
        $this->operators = Admin::latest()->filter(['role' => 'operator'])->count();
    }

    public function render()
    {
        $data = new DataSidebar;
        $menus = $data->data('dashboard');
        $role = auth()->user()->role;
        if($role == 'admin') {
            unset($menus['user_device']);
        } else {
            unset($menus['master']);
        }
        return view('livewire.home.dashboard')
        ->layout('layouts.home', [
            'user' => $this->user,
            'menus' => $menus,
            'role' => $role,
        ]);
    }
}
