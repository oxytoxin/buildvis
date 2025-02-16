<div class="container mx-auto px-4 relative">
    <div class="max-w-sm mx-auto">
        <form class="space-y-4" wire:submit.prevent="register">
            <h3 class="text-4xl text-center font-medium mb-10">Create your account</h3>
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input wire:model="name" id="name" name="name" required />
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" type="email" name="email" required />
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input wire:model="password" id="password" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm password')" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>
            <button type="submit" class="inline-flex w-full mt-2 py-3 px-6 items-center justify-center text-lg font-medium text-white hover:text-teal-900 border border-teal-900 hover:border-lime-500 bg-teal-900 hover:bg-lime-500 rounded-full transition duration-200">Create account</button>
            <div class="text-center mt-2">
                <p>
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}" class="inline-block font-medium underline hover:text-lime-600">Login</a>
                </p>
            </div>
        </form>
    </div>
</div>
