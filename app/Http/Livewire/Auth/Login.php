<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{

    public $email, $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function login(){

        $data = $this->validate();
        if(auth()->guard('admin')->attempt($data)){
            return redirect()->route('home');
        }
        session()->flash('error', 'Invalid email or password');
    }

    public function render()
    {
        return view('livewire.auth.login')
        ->layout('layouts.auth');
    }
}
