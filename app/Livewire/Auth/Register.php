<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Models\User;
use Livewire\Attributes\Rule;

class Register extends Component
{
    #[Rule(['required', 'max:255'])]
    public ?string $name;

    #[Rule(['required', 'email', 'max:255', 'confirmed'])]
    public ?string $email;
    public ?string $email_confirmation;

    #[Rule(['required'])]
    public ?string $password;

    public function render(): View
    {
        return view('livewire.auth.register');
    }

    public function submit(): void{

        $this->validate();

        $user = User::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ]);

        auth()->login($user);

    }
}
