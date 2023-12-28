<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
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

        if($this->ensureIsNotRateLimitng()){
            return;
        }

        if(!Auth::attempt(['email' => $this->email, 'password' => $this->password])){

            RateLimiter::hit($this->throttleKey());

            $this->addError('invalidCredencials', trans('auth.failed'));
            return;
        }

        $this->redirect(route('dashboard'));
    }

    private function throttleKey()
    {
        return Str::transliterate(Str::lower($this->email). '|' .request()->ip());
    }

    private function ensureIsNotRateLimitng()
    {
        if(RateLimiter::tooManyAttempts($this->throttleKey(), 5)){

            $this->addError('rateLimitter', trans('auth.throttle', [
                'seconds' => RateLimiter::availableIn($this->throttleKey()),
            ]));

            return true;
        }

        return false;
    }
}
