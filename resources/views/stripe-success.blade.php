<x-layouts.app>
    <div class="container mx-auto py-32">
        <h1 class="text-2xl font-semibold mb-8">Payment Successful!</h1>
        <p>Thank you for your payment. Your transaction has been completed and a receipt for your purchase will be
            emailed to you.</p>
        <a href="{{ route('filament.store.pages.shop') }}"
           class="px-4 py-2 inline-block border-2 border-teal-600 rounded-lg mt-8">Back to Store</a>
    </div>
</x-layouts.app>
