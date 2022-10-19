<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use App\Models\Device;
use Livewire\Component;
use App\Http\Livewire\Home\DataSidebar;

class MasterDevice extends Component
{
    public $device;
    public $user;
    public $name, $location;

    protected $rules = [
        'name' => 'required',
        'location' => 'required',
    ];

    public function mount()
    {
        $this->user = auth()->user();

    }

    public function store()
    {
        $data = $this->validate();

        try {
            $result = Device::create($data);
            $this->resetData();
            $this->dispatchBrowserEvent('closeCreateModal');
            return session()->flash('success', 'Your account has been created!');
        }
        catch (Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            $this->resetData();
            $this->dispatchBrowserEvent('closeCreateModal');
            return session()->flash('error', 'Query error ' + $errorCode);
        }
    }

    public function show(Device $device)
    {
        $this->device = $device;
        $this->name = $device->name;
        $this->location = $device->location;
    }

    public function update()
    {
        $data = $this->validate();

        $affectedRows = $this->device->update($data);
        $this->dispatchBrowserEvent('closeEditModal');

        if($affectedRows) {
            $this->resetData();
            return session()->flash('success', 'Data has been updated!');
        }
        $this->resetData();
        return session()->flash('error', 'Data failed to update');

    }

    public function delete()
    {
        $affectedRows = $this->device->delete();

        if($affectedRows) {
            return session()->flash('success', 'Data has been deleted!');
        }
        return session()->flash('error', 'Data failed to delete');
    }

    public function resetData(){
        $this->name = '';
        $this->email = '';
        $this->location = '';
    }

    public function render()
    {
        $data = new DataSidebar;
        $menus = $data->data('master', 'device');
        $devices = Device::latest()->paginate(10)->withQueryString();
        $role = auth()->user()->role;
        if($role == 'admin') {
            unset($menus['user_device']);
        } else {
            unset($menus['master']);
        }
        return view('livewire.home.master-device',['data' => $devices])
        ->layout('layouts.home', [
            'user' => $this->user,
            'menus' => $menus,
        ]);
    }
}
