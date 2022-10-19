<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use App\Models\Device;
use Livewire\Component;
use App\Http\Livewire\Home\UserDevice;
use App\Http\Livewire\Home\DataSidebar;
use Livewire\WithPagination;


class UserDevice extends Component
{
    use WithPagination;
    public $user_device;
    public $user;
    public $user_id, $device_id;
    protected $paginationTheme = 'bootstrap';


    protected $rules = [
        'user_id' => 'required',
        'device_id' => 'required',
    ];

    public function mount()
    {
        $this->user = auth()->user();

    }

    public function store()
    {

        $data = $this->validate();
        $user = User::find($data['user_id']);
        $device = Device::find($data['device_id']);
        $exist = App\Models\UserDevice::where('device_id', $device->id)->where('user_id', $user_id)->get();

        if(!$user && !$device) {
            return session()->flash('error', 'User or device not found!');
        }
        if($exist){
            return session()->flash('error', 'User and device exist!');
        }
        try {
            $result = UserDevice::create($data);
            return session()->flash('success', 'Your account has been created!');
        }
        catch (Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            return session()->flash('error', 'Query error ' + $errorCode);
        }
    }

    public function show(UserDevice $user_device)
    {
        $this->user_device = $user_device;
    }

    public function update()
    {
        $data = $this->validate();
        $user = User::find($data['user_id']);
        $device = Device::find($data['device_id']);
        $exist = UserDevice::where('device_id', $device->id)->where('user_id', $user_id)->get();

        if(!$user && !$device) {
            return session()->flash('error', 'User or device not found!');
        }

        if($exist){
            $true = $exist == $this->user_device;
            if(!$true){
                return  session()->flash('error', 'User and device exist!');
            }
        }

        $affectedRows = $this->user_device->update($data);

        if($affectedRows) {
            return session()->flash('success', 'Data has been updated!');
        }

        return session()->flash('error', 'Data failed to update');

    }

    public function delete()
    {
        $affectedRows = $this->user_device->delete();
        if($affectedRows) {
            return session()->flash('success', 'Data has been deleted!');
        }
        return session()->flash('error', 'Data failed to delete');
    }

    public function render()
    {
        $data = new DataSidebar;
        $menus = $data->data('user_device');
        $user_devices = UserDevice::latest()->paginate(10)->withQueryString();
        $role = auth()->user()->role;
        if($role == 'admin') {
            unset($menus['user_device']);
        } else {
            unset($menus['master']);
        }

        return view('livewire.home.user-device')
        ->layout('layouts.home', [
            'user' => $this->user,
            'data' => $user_devices,
            'menus' => $menus,
            'role' => auth()->user()->role,
        ]);
    }
}
