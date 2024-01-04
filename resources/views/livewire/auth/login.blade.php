<x-card title="Login" shadow class="mx-auto w-[450px]">

    @if($errors->hasAny(['invalidCredencials', 'rateLimiter']))
        <x-alert icon="o-exclamation-triangle" class="alert-warning text-sm mb-4">

            @error('invalidCredencials')
                <span>{{ $message }}</span>
            @enderror

            @error('rateLimiter')
                <span>{{ $message }}</span>
            @enderror

        </x-alert>
    @endif

    <x-form wire:submit="tryToLogin">
        <x-input label="E-mail" wire:model="email" />
        <x-input label="Senha" wire:model="password" type="password" />

        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route('auth.register') }}" class="underline">Criar conta</a>
                <div>
                    <x-button label="Login" class="btn-primary" type="submit" spinner="submit" />
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>

