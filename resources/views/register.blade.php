<div class="flex items-center justify-center min-h-screen bg-gray-100 text-gray-900">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form wire:submit.prevent="createAccount" class="bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8">
            <div class="w-full flex justify-center">
                <x-filament::brand />
            </div>

            <h2 class="font-bold tracking-tight text-center text-2xl">
                {{ __('register.heading') }}
            </h2>

            {{ $this->form }}

            <x-filament::button type="submit" class="w-full">
                {{ __('register.buttons.submit.label') }}
            </x-filament::button>

            <div class="w-full flex justify-center">
                <a href="{{ route('filament.auth.login') }}" class="text-gray-600 hover:text-primary-500 focus:outline-none focus:underline">
                    {{ __('register.links.login.label') }}
                </a>
            </div>
        </form>

        <x-filament::footer />
    </div>
</div>
