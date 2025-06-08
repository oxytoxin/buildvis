<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->table }}
    </div>

    <div class="flex flex-col gap-8 sm:flex-row mt-6">
        <div class="sm:w-1/2">
            <div class="space-y-4">
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Budget (PHP)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">₱</span>
                        </div>
                        <input 
                            class="w-full rounded-lg border-gray-300 pl-7 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" 
                            id="budget" 
                            type="number" 
                            wire:model.live.debounce.500ms="budget"
                            min="100000"
                            step="10000"
                            required
                        />
                    </div>
                    @error('budget')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Project Description</label>
                    <textarea 
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" 
                        rows="7" 
                        required 
                        placeholder="Describe your construction project in detail..." 
                        wire:model.live.debounce.500ms="description"
                    ></textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <x-filament::button 
                    class="w-full" 
                    wire:click="estimate" 
                    wire:loading.attr="disabled"
                    color="primary"
                >
                    <span wire:loading.remove wire:target="estimate">
                        Generate Estimate
                    </span>
                    <span wire:loading wire:target="estimate">
                        Generating...
                    </span>
                </x-filament::button>

                <div>
                    <label for="chat" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Additional Instructions</label>
                    <textarea 
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" 
                        rows="5" 
                        required 
                        placeholder="Add any specific requirements or modifications..." 
                        wire:model.live.debounce.500ms="chat"
                    ></textarea>
                    @error('chat')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <x-filament::button 
                    class="w-full" 
                    wire:click="sendChat" 
                    wire:loading.attr="disabled"
                    color="secondary"
                >
                    <span wire:loading.remove wire:target="sendChat">
                        Send Instructions
                    </span>
                    <span wire:loading wire:target="sendChat">
                        Sending...
                    </span>
                </x-filament::button>
            </div>
        </div>

        <div class="sm:w-1/2">
            <div class="flex w-full gap-8">
                <div class="h-[70vh] w-full overflow-y-auto rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-4">
                    <div class="text-sm text-gray-900 dark:text-gray-200 [&_table]:my-2 [&_table]:w-full [&_td]:border [&_td]:border-gray-300 [&_td]:dark:border-gray-600 [&_td]:px-2 [&_th]:border [&_th]:border-gray-300 [&_th]:dark:border-gray-600 [&_th]:px-2 [&_th]:text-left" id="content" wire:stream="content">
                        @if (filled($quotation))
                            <div class="space-y-4">
                                <div class="border-b border-gray-200 dark:border-gray-600 pb-4">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Sample Quotation for a <strong>{{ $description }}</strong></h2>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Length</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['length'] }}m</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Width</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['width'] }}m</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Floor Area</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['total_area'] }}sq.m</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Budget</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">₱{{ number_format($quotation['budget']) }}</p>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Total Quotation: ₱{{ number_format($quotation['total_cost']) }}</h3>
                                </div>

                                <div class="space-y-6">
                                    @foreach ($quotation['itemized_costs'] as $itemized_cost)
                                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                                                <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $itemized_cost['name'] }}</h3>
                                            </div>
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                                        <tr>
                                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Unit Cost</th>
                                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Cost</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                        @foreach ($itemized_cost['line_items'] as $line_item)
                                                            <tr>
                                                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $line_item['description'] }}</td>
                                                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">₱{{ number_format($line_item['unit_cost']) }}</td>
                                                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">₱{{ number_format($line_item['total_cost']) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-center h-full">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No estimate generated</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter your budget and project details to generate an estimate.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
