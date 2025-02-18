<div class="container mx-auto px-4 relative">
    <div class="max-w-sm mx-auto">
        <form wire:submit.prevent="login" class="space-y-4">
            <h3 class="text-4xl text-center font-medium mb-10">Login</h3>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email" type="email" name="email" required />
                <x-input-error :messages="$errors->get('form.email')" />
            </div>
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input wire:model="form.password" id="password" type="password" name="password" required />
                <x-input-error :messages="$errors->get('form.email')" />
            </div>
            <div class="text-right mb-10">
                <a href="{{ route('password.request') }}" class="inline-block text-sm underline font-medium">Forgot password?</a>
            </div>
            <button type="submit" class="inline-flex w-full py-3 px-6 items-center justify-center text-lg font-medium text-white hover:text-teal-900 border border-teal-900 hover:border-lime-500 bg-teal-900 hover:bg-lime-500 rounded-full transition duration-200">Login</button>
            <div class="text-center mt-2">
                <p>
                    <span>New to BuildVis?</span>
                    <a href="{{ route('register') }}" class="inline-block font-medium underline hover:text-lime-600">Create an account</a>
                </p>
            </div>
        </form>
    </div>
</div>
