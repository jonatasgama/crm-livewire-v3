<?php

namespace App\Livewire\Auth\Password;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\{Rule, Computed};
use Livewire\Component;

class Reset extends Component
{

    public ?string $token = null;

    #[Rule(['required', 'email', 'confirmed'])]
    public ?string $email = null;
    public ?string $email_confirmation = null;

    #[Rule(['required', 'confirmed'])]
    public ?string $password = null;
    public ?string $password_confirmation = null;

    public function mount(?string $token, ?string $email) : void
    {
        $this->token = request('token', $token);
        $this->email = request('email', $email);

        if($this->tokenNotValid())
        {
            session()->flash('status', 'Token inválido');
            $this->redirectRoute('login');
        }
    }

    public function render(): View
    {
        return view('livewire.auth.password.reset');
    }

    public function updatePassword(): void
    {
        $this->validate();

        $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'),
            function(User $user, $password){
                $user->password = $password;
                $user->rememberToken = Str::random(60);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        session()->flash('status', __($status));

        $this->redirect(route('dashborad'));
    }

    #[Computed]
    public function obfuscatedEmail(){
        return obfuscate_email($this->email);
    }

    private function tokenNotValid() : bool
    {
        $tokens = DB::table('password_reset_tokens')->get(['token']);

        foreach($tokens as $t){
            if(Hash::check($this->token, $t->token)){
                return false;
            }
        }

        return true;
    }
}
