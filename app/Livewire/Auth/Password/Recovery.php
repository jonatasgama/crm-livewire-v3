<?php

namespace App\Livewire\Auth\Password;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Component;

class Recovery extends Component
{

    public ?string $message = null;

    #[Rule(['required', 'email'])]
    public ?string $email = null;

    public function render(): View
    {
        return view('livewire.auth.password.recovery')->layout('components.layouts.guest');
    }

    public function startPasswordRecovery(): void {

        $this->validate();

        Password::sendResetLink($this->only('email'));

        $this->message = "Você receberá um link para alteração de senha";

    }
}
