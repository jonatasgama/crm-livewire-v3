<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{

    public ?string $email = null;
    public ?string $password = null;

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest');
    }

    public function tryToLogin(): void{

        if($this->ensureIsNotRateLimiting()){
            return;
        }

        if(!Auth::attempt(['email' => $this->email, 'password' => $this->password])){

            RateLimiter::hit($this->throttleKey());

            $this->addError('invalidCredencials', trans('auth.failed'));
            return;
        }

        $this->redirect(route('dashboard'));
    }

    private function ensureIsNotRateLimiting(): bool
    {
        if(RateLimiter::tooManyAttempts($this->throttleKey(), 5)){

            $this->addError('rateLimiter', trans('auth.throttle', [
                'seconds' => RateLimiter::availableIn($this->throttleKey()),
            ]));

            return true;
        }

        return false;
    }

    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email). '|' .request()->ip());
    }
}
