<x-filament-panels::page class="h-full">
    @if(!$model)
        <div class="grid mt-16 h-full place-items-center">
            <div class="flex gap-4 text-lg font-semibold">
                <div>Choosing House Model...</div>
                <x-heroicon-c-arrow-path class="animate-spin h-6 w-6 text-gray-500"/>
            </div>
            <p class="mt-5">Please refresh the page later.</p>
        </div>
    @else
        <x-react-filament wire:key="house-gen" component="HouseGenerator"
                          :props="['budget_estimate' => $budget_estimate, 'model' => $model_url]"/>
    @endif
</x-filament-panels::page>
