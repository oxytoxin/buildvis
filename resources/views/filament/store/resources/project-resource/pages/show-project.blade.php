<x-filament-panels::page>

    <x-filament::card>
        <p>Project Manager: {{ $project->project_manager?->name ?? 'Unassigned' }}</p>
    </x-filament::card>
    <div>
        <h3 class="mt-4 mb-2 font-semibold text-lg">Budget Estimates</h3>
        {{ $this->table }}
    </div>

    <div class="flex flex-col gap-8 sm:flex-row mt-6">
        <div class="sm:w-1/2">
            <div class="space-y-4">
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Budget
                        (PHP)</label>
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

                <!-- Lot Dimensions -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="lotLength" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Lot
                            Length (m)</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="lotLength"
                            type="number"
                            wire:model.live.debounce.500ms="lotLength"
                            min="5"
                            max="100"
                            required
                        />
                        @error('lotLength')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="lotWidth" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Lot
                            Width (m)</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="lotWidth"
                            type="number"
                            wire:model.live.debounce.500ms="lotWidth"
                            min="5"
                            max="100"
                            required
                        />
                        @error('lotWidth')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Floor Dimensions -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="floorLength" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Floor
                            Length (m)</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="floorLength"
                            type="number"
                            wire:model.live.debounce.500ms="floorLength"
                            min="3"
                            max="50"
                            required
                        />
                        @error('floorLength')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="floorWidth" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Floor
                            Width (m)</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="floorWidth"
                            type="number"
                            wire:model.live.debounce.500ms="floorWidth"
                            min="3"
                            max="50"
                            required
                        />
                        @error('floorWidth')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Building Specifications -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="numberOfRooms" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Number
                            of Rooms</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="numberOfRooms"
                            type="number"
                            wire:model.live.debounce.500ms="numberOfRooms"
                            min="1"
                            max="20"
                            required
                        />
                        @error('numberOfRooms')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="numberOfStories" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Number
                            of Stories</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="numberOfStories"
                            type="number"
                            wire:model.live.debounce.500ms="numberOfStories"
                            min="1"
                            max="5"
                            required
                        />
                        @error('numberOfStories')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Area Summary -->
                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Lot Area:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $lotLength * $lotWidth }} sq.m</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Floor Area:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $floorLength * $floorWidth }} sq.m</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Project
                        Description</label>
                    <textarea
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        rows="7"
                        required
                        placeholder="Describe your construction project in detail. Include lot size, floor dimensions, number of rooms, stories, and budget. The AI will automatically extract specifications from your description..."
                        wire:model.live.debounce.500ms="description"
                    ></textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Tip: Describe your project naturally. The AI will extract specifications like "20x30 meter lot",
                        "3 bedrooms", "2-story house", or "₱2M budget" from your description.
                    </p>
                    @error('description')
                    <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-2">
                    <x-filament::button
                        class="w-full"
                        wire:click="parseDescription"
                        wire:loading.attr="disabled"
                        color="info"
                    >
                    <span wire:loading.remove wire:target="parseDescription">
                        Extract Specifications with AI
                    </span>
                        <span wire:loading wire:target="parseDescription">
                        Analyzing...
                    </span>
                    </x-filament::button>

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
                </div>
            </div>
        </div>

        <div class="sm:w-1/2">
            <div class="flex w-full gap-8">
                <div
                    class="h-[70vh] w-full overflow-y-auto rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-4">
                    <div
                        class="text-sm text-gray-900 dark:text-gray-200 [&_table]:my-2 [&_table]:w-full [&_td]:border [&_td]:border-gray-300 [&_td]:dark:border-gray-600 [&_td]:px-2 [&_th]:border [&_th]:border-gray-300 [&_th]:dark:border-gray-600 [&_th]:px-2 [&_th]:text-left"
                        id="content" wire:stream="content">
                        @if (filled($quotation))
                            <div class="space-y-4">
                                <div class="border-b border-gray-200 dark:border-gray-600 pb-4">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Sample Quotation
                                        for a <strong>{{ $description }}</strong></h2>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Lot Length</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['lot_length'] ?? $lotLength }}
                                            m</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Lot Width</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['lot_width'] ?? $lotWidth }}
                                            m</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Floor
                                            Length</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['floor_length'] ?? $floorLength }}
                                            m</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Floor
                                            Width</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['floor_width'] ?? $floorWidth }}
                                            m</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Number of
                                            Rooms</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['number_of_rooms'] ?? $numberOfRooms }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Number of
                                            Stories</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['number_of_stories'] ?? $numberOfStories }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Lot
                                            Area</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ($quotation['lot_length'] ?? $lotLength) * ($quotation['lot_width'] ?? $lotWidth) }}
                                            sq.m</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Floor
                                            Area</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['total_area'] }}
                                            sq.m</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Budget</h4>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            ₱{{ number_format($quotation['budget']) }}</p>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Total
                                        Quotation: ₱{{ number_format($quotation['total_cost']) }}</h3>

                                    @if(isset($quotation['materials_cost']) && isset($quotation['labor_cost_total']))
                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                            <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                                                <h4 class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                                    Materials Cost</h4>
                                                <p class="text-lg font-semibold text-blue-900 dark:text-blue-100">
                                                    ₱{{ number_format($quotation['materials_cost']) }}</p>
                                            </div>
                                            <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded-lg">
                                                <h4 class="text-sm font-medium text-green-600 dark:text-green-400">Labor
                                                    Cost</h4>
                                                <p class="text-lg font-semibold text-green-900 dark:text-green-100">
                                                    ₱{{ number_format($quotation['labor_cost_total']) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="space-y-6">
                                    @foreach ($quotation['itemized_costs'] as $itemized_cost)
                                        <div
                                            class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                                                <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $itemized_cost['name'] }}</h3>
                                                @if(isset($itemized_cost['category_total']))
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Category Total:
                                                        ₱{{ number_format($itemized_cost['category_total']) }}</p>
                                                @endif
                                            </div>
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Product
                                                        </th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            SKU
                                                        </th>
                                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Quantity
                                                        </th>
                                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Unit
                                                        </th>
                                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Unit Price
                                                        </th>
                                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Total Price
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody
                                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                    @foreach ($itemized_cost['products'] as $product)
                                                        <tr>
                                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $product['product_name'] }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $product['sku'] }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">{{ number_format($product['quantity']) }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-right">{{ $product['unit'] }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">
                                                                ₱{{ number_format($product['unit_price']) }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">
                                                                ₱{{ number_format($product['total_price']) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    @if(isset($itemized_cost['labor_cost']) && $itemized_cost['labor_cost'] > 0)
                                                        <tr class="bg-gray-50 dark:bg-gray-700">
                                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100"
                                                                colspan="4">Labor Cost
                                                            </td>
                                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">
                                                                ₱{{ number_format($itemized_cost['labor_cost']) }}</td>
                                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">
                                                                ₱{{ number_format($itemized_cost['labor_cost']) }}</td>
                                                        </tr>
                                                    @endif
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
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No estimate
                                        generated</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter your budget and
                                        project details to generate an estimate.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
