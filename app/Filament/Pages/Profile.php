<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Squire\Models\Currency;
use Squire\Models\Country;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Account';

    protected static string $view = 'filament.pages.profile';

    public $name;

    public $email;

    public $country;

    public $currency;

    public $current_password;

    public $new_password;

    public $new_password_confirmation;

    public function mount()
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'country' => auth()->user()->country,
            'currency' => auth()->user()->currency,
        ]);
    }

    public function submit()
    {
        $this->form->getState();

        $state = array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->new_password ? Hash::make($this->new_password) : null,
            'country' => $this->country,
            'currency' => $this->currency,
        ]);

        auth()->user()->update($state);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->notify('success', 'Your profile has been updated.');
    }

    public function getCancelButtonUrlProperty()
    {
        return static::getUrl();
    }

    protected function getBreadcrumbs(): array
    {
        return [
            url()->current() => 'Profile',
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Personal Information')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email Address')
                        ->required(),
                ])
                ->extraAttributes(['class' => 'bg-white dark:bg-gray-800']),
            Forms\Components\Section::make('Configuration')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('currency')
                        ->searchable()
                        ->getSearchResultsUsing(fn (string $query) => Currency::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                        ->getOptionLabelUsing(fn ($value): ?string => Currency::find($value)?->name)
                        ->required(),
                    Forms\Components\Select::make('country')
                        ->searchable()
                        ->getSearchResultsUsing(fn (string $query) => Country::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                        ->getOptionLabelUsing(fn ($value): ?string => Country::find($value)?->name)
                        ->required(),
                ])
                ->extraAttributes(['class' => 'bg-white dark:bg-gray-800']),
            Forms\Components\Section::make('Update Password')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('current_password')
                        ->label('Current Password')
                        ->password()
                        ->rules(['required_with:new_password'])
                        ->currentPassword()
                        ->autocomplete('off')
                        ->columnSpan(1),
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\TextInput::make('new_password')
                                ->label('New Password')
                                ->password()
                                ->rules(['confirmed'])
                                ->autocomplete('new-password'),
                            Forms\Components\TextInput::make('new_password_confirmation')
                                ->label('Confirm Password')
                                ->password()
                                ->rules([
                                    'required_with:new_password',
                                ])
                                ->autocomplete('new-password'),
                        ]),
                ])
                ->extraAttributes(['class' => 'bg-white dark:bg-gray-800']),
        ];
    }
}
