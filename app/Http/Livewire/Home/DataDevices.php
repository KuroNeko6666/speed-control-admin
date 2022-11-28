<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use App\Models\Device;
use Livewire\Component;
use App\Models\DataDevice;
use App\Models\UserDevice;
use Livewire\WithPagination;
use App\Http\Livewire\Home\DataSidebar;


class DataDevices extends Component
{
    use WithPagination;

    public $data_device;
    public $user;
    public $search;
    public $devices;
    public $device_id, $speed;
    protected $paginationTheme = 'bootstrap';


    protected $rules = [
        'speed' => 'required',
        'device_id' => 'required',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->devices = Device::all();
    }

    public function store()
    {

        $data = $this->validate();
        $device = Device::find($data['device_id']);

        if(!$device) {
        $this->resetData();
            $this->dispatchBrowserEvent('closeCreateModal');
            return session()->flash('error', 'User or device not found!');
        }
        try {
        $this->resetData();
            $result = DataDevice::create($data);
            $this->dispatchBrowserEvent('closeCreateModal');
            return session()->flash('success', 'Your account has been created!');
        }
        catch (Illuminate\Database\QueryException $e){
            $this->dispatchBrowserEvent('closeCreateModal');
            $errorCode = $e->errorInfo[1];
            return session()->flash('error', 'Query error ' + $errorCode);
        }
    }

    public function show(DataDevice $data_device)
    {
        // dd($data_device);
        $this->data_device = $data_device;
        $this->device_id = $data_device->device_id;
        $this->speed = $data_device->speed;
    }

    public function update()
    {
        $data = $this->validate();

        $device = Device::find($data['device_id']);

        if( !$device) {
        $this->resetData();
        $this->dispatchBrowserEvent('closeEditModal');
            return session()->flash('error', 'User or device not found!');
        }

        $affectedRows = $this->data_device->update($data);

        if($affectedRows) {
        $this->resetData();
            $this->dispatchBrowserEvent('closeEditModal');
            return session()->flash('success', 'Data has been updated!');
        }
        $this->resetData();
        $this->dispatchBrowserEvent('closeEditModal');
        return session()->flash('error', 'Data failed to update');

    }

    public function deleteAt(DataDevice $data_device)
    {
        $affectedRows = $data_device->delete();
        if($affectedRows) {
        $this->resetData();
            return session()->flash('success', 'Data has been deleted!');
        }
        $this->resetData();
        return session()->flash('error', 'Data failed to delete');
    }

    public function delete()
    {
        $affectedRows = $this->data_device->delete();
        if($affectedRows) {
        $this->resetData();
            return session()->flash('success', 'Data has been deleted!');
        }
        $this->resetData();
        return session()->flash('error', 'Data failed to delete');
    }

    public function resetData(){
        $this->speed = '';
        $this->device_id = '';
    }

    public function search(){
        $this->render();
    }

    public function render()
    {
        $data = new DataSidebar;
        $menus = $data->data('data_device');
        $user_devices = DataDevice::latest()->filter(['search' => $this->search])->paginate(10)->withQueryString();
        // dd($user_devices[0]->device_id);
        $role = auth()->user()->role;
        if($role == 'admin') {
            unset($menus['data_device']);
            unset($menus['user_device']);
        } else {
            unset($menus['master']);
        }
        return view('livewire.home.data-devices', ['data' => $user_devices])
        ->layout('layouts.home', [
            'user' => $this->user,
            'menus' => $menus,
        ]);
    }
}
