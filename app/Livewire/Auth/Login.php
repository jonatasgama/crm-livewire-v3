<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{

    public ?string $email;
    public ?string $password;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function tryToLogin(): void{

        if(!Auth::attempt(['email' => $email, 'password' => $password])){
            $this->addError('invalidCredencials', trans('auth.failed'));
            return;
        }

        $this->redirect(route('dashboard'));
    }
}
