<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Livewire\Component;
use App\Http\Livewire\Home\DataSidebar;

class MasterUser extends Component
{
    public $user;
    public $data_user;
    public $name, $email, $password;
    public $search;
    protected $paginationTheme = 'bootstrap';


    public function mount()
    {
        $this->user = auth()->user();

    }

    public function store()
    {
        $data = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $data['password'] = bcrypt($data['password']);
        try {
            $result = User::create($data);
            $this->resetData();
            $this->dispatchBrowserEvent('closeCreateModal');
            return session()->flash('success', 'Your account has been created!');
        }
        catch (Illuminate\Database\QueryException $e){
            $this->resetData();
            $this->dispatchBrowserEvent('closeCreateModal');
            $errorCode = $e->errorInfo[1];
            return session()->flash('error', 'Query error ' + $errorCode);
        }
    }

    public function show(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function update()
    {
        $data;
        if ($this->user->email == $this->email) {
            $data = $this->validate([
                'name' => 'required',
                'email' => 'required|email',
                // 'password' => 'required|min:6'
            ]);
        } else {
            $data = $this->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                // 'password' => 'required|min:6'
            ]);
        }

        $affectedRows = $this->user->update($data);
        $this->resetData();
        $this->dispatchBrowserEvent('closeEditModal');
        if($affectedRows) {
            return session()->flash('success', 'Data has been updated!');
        }
        return session()->flash('error', 'Data failed to update');

    }

    public function delete()
    {
        $affectedRows = $this->user->delete();
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
        $menus = $data->data('master', 'user');
        $users = User::latest()->filter(['search' => $this->search])->paginate(10)->withQueryString();
        $role = auth()->user()->role;
        if($role == 'admin') {
            unset($menus['user_device']);
        } else {
            unset($menus['master']);
        }
        return view('livewire.home.master-user', ['data' => $users])
        ->layout('layouts.home', [
            'user' => $this->data_user,
            'menus' => $menus,
            'role' => $role
        ]);
    }
}
