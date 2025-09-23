<div class="container mx-auto px-4 relative">
    <div class="max-w-sm mx-auto">
        <form class="space-y-4" wire:submit.prevent="register">
            <h3 class="text-4xl text-center font-medium mb-10">Create your account</h3>
            {{ $this->form }}
            <button type="submit"
                    class="inline-flex w-full mt-2 py-3 px-6 items-center justify-center text-lg font-medium text-white hover:text-teal-900 border border-teal-900 hover:border-lime-500 bg-teal-900 hover:bg-lime-500 rounded-full transition duration-200">
                Create account
            </button>
            <div class="text-center mt-2">
                <p>
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}"
                       class="inline-block font-medium underline hover:text-lime-600">Login</a>
                </p>
            </div>
        </form>
    </div>
</div>
