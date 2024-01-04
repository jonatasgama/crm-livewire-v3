<?php

namespace App\Livewire\Auth\Password;

use App\Models\User;
use App\Notifications\PasswordRecoveryNotification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Recovery extends Component
{

    public ?string $message = null;

    #[Rule(['require', 'email'])]
    public ?string $email = null;

    public function render(): View
    {
        return view('livewire.auth.password.recovery')->layout('components.layouts.guest');;
    }

    public function startPasswordRecovery(): void {

        $user = User::whereEmail($this->email)->first();

        if($user){
            $user->notify(new PasswordRecoveryNotification());
        }

        $this->message = "Você receberá um link para alteração de senha";

    }
}
