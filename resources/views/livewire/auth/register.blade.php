<x-card title="Criar conta" shadow class="mx-auto w-[450px]">
    <x-form wire:submit="submit">
        <x-input label="Nome" wire:model="name" />
        <x-input label="E-mail" wire:model="email" />
        <x-input label="Confirme seu e-mail" wire:model="email_confirmation" />
        <x-input label="Senha" wire:model="password" type="password" />

        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route('login') }}" class="underline">Já tenho conta</a>
                <div>
                    <x-button label="Reset" type="reset" />
                    <x-button label="Registrar" class="btn-primary" type="submit" spinner="submit" />
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
