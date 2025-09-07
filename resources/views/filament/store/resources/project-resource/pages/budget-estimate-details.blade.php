<div class="sm:w-1/2">
    <div class="flex w-full gap-8">
        <div
            class="h-[70vh] w-full overflow-y-auto rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-4">
            <div
                wire:poll
                class="text-sm h-full text-gray-900 dark:text-gray-200 [&_table]:my-2 [&_table]:w-full [&_td]:border [&_td]:border-gray-300 [&_td]:dark:border-gray-600 [&_td]:px-2 [&_th]:border [&_th]:border-gray-300 [&_th]:dark:border-gray-600 [&_th]:px-2 [&_th]:text-left"
                id="content">
                @if($loadedEstimate)
                    @if($loadedEstimate->status === 'processing')
                        <div class="grid h-full place-items-center">
                            <div class="flex gap-4">
                                <div>Processing Estimate...</div>
                                <x-heroicon-c-arrow-path class="animate-spin h-6 w-6 text-gray-500"/>
                            </div>
                        </div>
                    @else
                        @php
                            $quotation = $loadedEstimate->structured_data;
                        @endphp
                        <div id="estimate" class="space-y-4 p-8">
                            <div class="border-b border-gray-200 dark:border-gray-600 pb-4">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Sample Quotation
                                    for a <strong>{{ $description }}</strong></h2>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Lot Length</h4>
                                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['lot_length'] }}
                                        m</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Lot Width</h4>
                                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['lot_width'] }}
                                        m</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Floor
                                        Length</h4>
                                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['floor_length'] }}
                                        m</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Floor
                                        Width</h4>
                                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['floor_width'] }}
                                        m</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Number of
                                        Rooms</h4>
                                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['number_of_rooms'] }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Number of
                                        Stories</h4>
                                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $quotation['number_of_stories'] }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Lot
                                        Area</h4>
                                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ($quotation['lot_length'] * $quotation['lot_width']) }}
                                        sq.m</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Floor
                                        Area</h4>
                                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ($quotation['floor_length'] * $quotation['floor_width']) }}
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
                    @endif
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
