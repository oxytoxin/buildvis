<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Register extends Component implements HasForms
{
    use InteractsWithForms;

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('first_name')->required(),
            TextInput::make('middle_name'),
            TextInput::make('last_name')->required(),
            TextInput::make('email')->required()->email()->unique(User::class),
            TextInput::make('password')->required()->password()->revealable(),
            TextInput::make('password_confirmation')->required()->password()->revealable(),
            Select::make('gender')->required()->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other']),
            TextInput::make('phone_number')->required()->minLength(11)->maxLength(11)->regex('/^09[0-9]{9}$/'),
        ]);
    }

    public string $first_name = '';

    public string $middle_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $gender = '';

    public string $phone_number = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->form->getState();
        $validated['password'] = Hash::make($validated['password']);
        unset($validated['password_confirmation']);

        event(new Registered($user = User::query()->create($validated)));

        Auth::login($user);

        $this->redirectIntended(default: route('welcome', absolute: false));
    }

    public function render()
    {
        return view('livewire.register');
    }
}
