<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Facades\Filament;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Register extends Component implements HasForms
{
    use InteractsWithForms;
    use WithRateLimiting;

    public $name = '';
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function updatedEmail(): void
    {
        $this->validate(['email' => 'unique:users']);
    }

    public function createAccount(): void
    {

        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->addError('email', __('filament::register.messages.throttled', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]));

            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:8|same:passwordConfirmation',
        ]);

        Auth::login($user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]));

        event(new Registered($user));

        redirect()->intended(Filament::getUrl());
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('register.fields.name.label'))
                ->required()
                ->autocomplete(),
            TextInput::make('email')
                ->label(__('register.fields.email.label'))
                ->email()
                ->required()
                ->autocomplete(),
            TextInput::make('password')
                ->label(__('register.fields.password.label'))
                ->password()
                ->required(),
            TextInput::make('passwordConfirmation')
                ->label(__('register.fields.passwordConfirmation.label'))
                ->password()
                ->required(),
        ];
    }

    public function render(): View
    {
        $view = view('register');
        $view->layout('filament::components.layouts.base', [
            'title' => __('register.title'),
        ]);
        return $view;
    }
}
