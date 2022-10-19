<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use App\Models\Device;
use Livewire\Component;
use App\Models\UserDevice;
use App\Http\Livewire\Home\DataSidebar;

class DeviceUser extends Component
{

    public $user_device;
    public $user;
    public $search;
    public $users, $devices;
    public $user_id, $device_id;

    protected $rules = [
        'user_id' => 'required',
        'device_id' => 'required',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->users = User::all();
        $this->devices = Device::all();
    }

    public function store()
    {

        $data = $this->validate();
        $user = User::find($data['user_id']);
        $device = Device::find($data['device_id']);
        $exist = UserDevice::where('device_id', $this->device_id)->where('user_id', $this->user_id)->get();

        if(!$user && !$device) {
        $this->resetData();
            $this->dispatchBrowserEvent('closeCreateModal');
            return session()->flash('error', 'User or device not found!');
        }
        if($exist->count()){

        $this->resetData();
            $this->dispatchBrowserEvent('closeCreateModal');
            return session()->flash('error', 'User and device exist!');
        }
        try {
        $this->resetData();
            $result = UserDevice::create($data);
            $this->dispatchBrowserEvent('closeCreateModal');
            return session()->flash('success', 'Your account has been created!');
        }
        catch (Illuminate\Database\QueryException $e){
            $this->dispatchBrowserEvent('closeCreateModal');
            $errorCode = $e->errorInfo[1];
            return session()->flash('error', 'Query error ' + $errorCode);
        }
    }

    public function show(UserDevice $user_device)
    {
        $this->user_device = $user_device;
        $this->user_id = $user_device->user_id;
        $this->device_id = $user_device->device_id;
    }

    public function update()
    {
        $data = $this->validate();
        $user = User::find($data['user_id']);
        $device = Device::find($data['device_id']);
        $exist = UserDevice::where('device_id', $this->device_id)->where('user_id', $this->user_id)->get();

        if(!$user && !$device) {
        $this->resetData();
        $this->dispatchBrowserEvent('closeEditModal');
            return session()->flash('error', 'User or device not found!');
        }

        if($exist->count()){
            $true = $exist == $this->user_device;
            if(!$true){
            $this->dispatchBrowserEvent('closeEditModal');
                return  session()->flash('error', 'User and device exist!');
            }
        }

        $affectedRows = $this->user_device->update($data);

        if($affectedRows) {
        $this->resetData();
            $this->dispatchBrowserEvent('closeEditModal');
            return session()->flash('success', 'Data has been updated!');
        }
        $this->resetData();
        $this->dispatchBrowserEvent('closeEditModal');
        return session()->flash('error', 'Data failed to update');

    }

    public function delete()
    {
        $affectedRows = $this->user_device->delete();
        if($affectedRows) {
        $this->resetData();
            return session()->flash('success', 'Data has been deleted!');
        }
        $this->resetData();
        return session()->flash('error', 'Data failed to delete');
    }

    public function resetData(){
        $this->user_id = '';
        $this->device_id = '';
    }

    public function search(){
        $this->render();
    }

    public function render()
    {
        $data = new DataSidebar;
        $menus = $data->data('user_device');
        $user_devices = UserDevice::latest()->filter(['search' => $this->search])->paginate(10)->withQueryString();
        $role = auth()->user()->role;
        if($role == 'admin') {
            unset($menus['user_device']);
        } else {
            unset($menus['master']);
        }
        return view('livewire.home.device-user', ['data' => $user_devices])
        ->layout('layouts.home', [
            'user' => $this->user,
            'menus' => $menus,

        ]);
    }
}
