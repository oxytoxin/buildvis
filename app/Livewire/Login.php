<?php

namespace App\Livewire;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    public LoginForm $form;
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('welcome', absolute: false));
    }
    public function render()
    {
        return view('livewire.login');
    }
}
