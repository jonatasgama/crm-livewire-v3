<x-card title="Recuperação de senha" shadow class="mx-auto w-[450px]">
    @if($message)
        <x-alert icon="o-exclamation-triangle" class="alert-success text-sm mb-4">
            <span>{{ $message }}</span>
        </x-alert>
    @endif

    <x-form wire:submit="startPasswordRecovery">
        <x-input label="E-mail" wire:model="email" />

        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route('login') }}" class="underline">Login</a>
                <x-button type="submit" class="btn-primary">
                    <span wire:loading.class="hidden" wire:target="startPasswordRecovery">Enviar</span>
                    <span wire:loading wire:target="startPasswordRecovery">Enviando...</span>
                </x-button>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
