<div class="container mx-auto px-4 relative">
    <div class="max-w-sm mx-auto">
        <form class="space-y-4" wire:submit.prevent="register">
            <h3 class="text-4xl text-center font-medium mb-10">Create your account</h3>
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input wire:model="first_name" id="first_name" name="first_name" required />
                <x-input-error :messages="$errors->get('first_name')" />
            </div>

            <div>
                <x-input-label for="middle_name" :value="__('Middle Name')" />
                <x-text-input wire:model="middle_name" id="middle_name" name="middle_name" />
                <x-input-error :messages="$errors->get('middle_name')" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input wire:model="last_name" id="last_name" name="last_name" required />
                <x-input-error :messages="$errors->get('last_name')" />
            </div>
            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <select wire:model="gender" id="gender" name="gender" class="block w-full px-4 py-2 mb-2 outline-none ring-offset-0 focus:ring-2 focus:ring-lime-500 shadow rounded-lg">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" />
            </div>

            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <x-text-input wire:model="phone_number" id="phone_number" name="phone_number" type="tel" />
                <x-input-error :messages="$errors->get('phone_number')" />
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
