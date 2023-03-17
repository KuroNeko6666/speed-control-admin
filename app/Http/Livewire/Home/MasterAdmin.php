<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use App\Models\Admin;
use Livewire\Component;
use App\Http\Livewire\Home\DataSidebar;
use Livewire\WithPagination;

class MasterAdmin extends Component
{
    use WithPagination;
    public $admin;
    public $user;
    public $search;
    public $name, $email, $password;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->user = auth()->user();

    }

    public function store()
    {
        $data = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6'
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'admin';
        try {
            $result = Admin::create($data);
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

    public function show(Admin $admin)
    {
        $this->admin = $admin;
        $this->name = $admin->name;
        $this->email = $admin->email;

    }

    public function update()
    {
        $data;
        if ($this->admin->email == $this->email) {
            $data = $this->validate([
                'name' => 'required',
                'email' => 'required|email',
                // 'password' => 'required|min:6'
            ]);
        } else {
            $data = $this->validate([
                'name' => 'required',
                'email' => 'required|email|unique:admins',
                // 'password' => 'required|min:6'
            ]);
        }

        $affectedRows = $this->admin->update($data);
        $this->resetData();

        if($affectedRows) {
            $this->dispatchBrowserEvent('closeEditModal');
            return session()->flash('success', 'Data has been updated!');
        }
        $this->dispatchBrowserEvent('closeEditModal');
        return session()->flash('error', 'Data failed to update');

    }

    public function delete()
    {
        $affectedRows = $this->admin->delete();
        $this->resetData();
        if($affectedRows) {
            return session()->flash('success', 'Data has been deleted!');
        }
        return session()->flash('error', 'Data failed to delete');
    }



    public function resetData(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    public function render()
    {

        $data = new DataSidebar;
        $menus = $data->data('master', 'admin');
        $admins = Admin::latest()->filter(['role' => 'admin'])->filter(['search' => $this->search])->paginate(10)->withQueryString();
        $role = auth()->user()->role;
        if($role == 'admin') {
            unset($menus['user_device']);
        } else {
            unset($menus['master']);
        }
        return view('livewire.home.master-admin', ['data' => $admins])
        ->layout('layouts.home', [
            'user' => $this->user,
            'menus' => $menus,

        ]);
    }
}
