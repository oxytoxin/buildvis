<?php

    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Validation\Rule;
    use Livewire\Volt\Component;

    new class extends Component {
        public string $first_name = '';
        public ?string $middle_name = '';
        public string $last_name = '';
        public string $gender = '';
        public string $phone_number = '';
        public string $email = '';

        /**
         * Mount the component.
         */
        public function mount(): void
        {
            $this->first_name = Auth::user()->first_name;
            $this->middle_name = Auth::user()->middle_name;
            $this->last_name = Auth::user()->last_name;
            $this->gender = Auth::user()->gender;
            $this->phone_number = Auth::user()->phone_number;
            $this->email = Auth::user()->email;
        }

        /**
         * Update the profile information for the currently authenticated user.
         */
        public function updateProfileInformation(): void
        {
            $user = Auth::user();

            $validated = $this->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['nullable', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)
                ],
                'gender' => ['nullable', 'string', 'in:male,female,other'],
                'phone_number' => ['nullable', 'string', 'max:255'],
            ]);

            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            $this->dispatch('profile-updated', first_name: $user->first_name, middle_name: $user->middle_name,
                last_name: $user->last_name, gender: $user->gender, phone_number: $user->phone_number);
        }

        /**
         * Send an email verification notification to the current user.
         */
        public function sendVerification(): void
        {
            $user = Auth::user();

            if ($user->hasVerifiedEmail()) {
                $this->redirectIntended(default: route('dashboard', absolute: false));

                return;
            }

            $user->sendEmailVerificationNotification();

            Session::flash('status', 'verification-link-sent');
        }
    }; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="first_name" :value="__('First Name')"/>
            <x-text-input wire:model="first_name" id="first_name" name="first_name" type="text"
                          class="mt-1 block w-full" required autofocus autocomplete="first_name"/>
            <x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
        </div>

        <div>
            <x-input-label for="middle_name" :value="__('Middle Name')"/>
            <x-text-input wire:model="middle_name" id="middle_name" name="middle_name" type="text"
                          class="mt-1 block w-full" autocomplete="middle_name"/>
            <x-input-error class="mt-2" :messages="$errors->get('middle_name')"/>
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Last Name')"/>
            <x-text-input wire:model="last_name" id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                          required autocomplete="last_name"/>
            <x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required
                          autocomplete="username"/>
            <x-input-error class="mt-2" :messages="$errors->get('email')"/>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="gender" :value="__('Gender')"/>
            <select wire:model="gender" id="gender" name="gender"
                    class="block w-full px-4 py-2 mb-2 outline-none ring-offset-0 focus:ring-2 focus:ring-lime-500 shadow rounded-lg">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <x-input-error :messages="$errors->get('gender')"/>
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')"/>
            <x-text-input wire:model="phone_number" id="phone_number" name="phone_number" type="text"
                          class="mt-1 block w-full" required autocomplete="phone_number"/>
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
