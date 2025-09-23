<?php

namespace App\Livewire;

use App\Livewire\Forms\LoginForm;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component implements HasForms
{
    use InteractsWithForms;

    public LoginForm $loginForm;

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('loginForm.email')->required(),
            TextInput::make('loginForm.password')->required()->password()->revealable(),
        ]);
    }

    public function login(): void
    {
        $this->validate();

        $this->loginForm->authenticate();

        Session::regenerate();

        $this->redirect(route('welcome', absolute: false));
    }

    public function render()
    {
        return view('livewire.login');
    }
}
