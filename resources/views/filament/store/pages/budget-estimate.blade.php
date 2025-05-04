<x-filament-panels::page>
    <div class="flex flex-col gap-8 sm:flex-row">
        <div class="sm:w-1/2">
            <div>
                <label for="budget">Budget</label>
                <input class="w-full rounded-lg border border-black" id="budget" type="number" wire:model="budget" />
            </div>
            <div class="mt-4">
                <label for="budget">Description</label>
                <textarea class="w-full rounded-lg" rows="7" required placeholder="Describe your house" wire:model="description"></textarea>
            </div>
            <x-filament::button class="mt-2" wire:click="estimate" color="primary">Estimate</x-filament::button>
            <div class="mt-4">
                <label for="chat">Chat</label>
                <textarea class="w-full rounded-lg" rows="5" required placeholder="Give further instructions" wire:model="chat"></textarea>
            </div>
            <x-filament::button class="mt-2" wire:click="sendChat" color="primary">Send</x-filament::button>
        </div>
        <div class="sm:w-1/2">
            <div class="flex w-full gap-8">
                <div class="h-[70vh] w-full overflow-y-auto rounded-lg border-2 border-gray-600 bg-gray-200 p-4">
                    <div class="text-xs [&_table]:my-2 [&_table]:w-full [&_td]:border [&_td]:border-black [&_td]:px-2 [&_th]:border [&_th]:border-black [&_th]:px-2 [&_th]:text-left" id="content" wire:stream="content">
                        @if (filled($quotation))
                            <h2>Sample Quotation for a <strong>{{ $description }}</strong></h2>
                            <div>
                                <h4>Length: {{ $quotation['length'] }}m</h4>
                                <h4>Width: {{ $quotation['width'] }}m</h4>
                                <h4>Total Floor Area: {{ $quotation['total_area'] }}sq.m</h4>
                                <h4>Budget: {{ number_format($quotation['budget']) }}</h4>
                                <h4>Total Quotation: {{ number_format($quotation['total_cost']) }}</h4>
                            </div>
                            <div class="mt-4">
                                @foreach ($quotation['itemized_costs'] as $itemized_cost)
                                    <h3>{{ $itemized_cost['name'] }}</h3>
                                    <table>
                                        <thead>
                                            <th>Name</th>
                                            <th>Unit Cost</th>
                                            <th>Total Cost</th>
                                        </thead>
                                        @foreach ($itemized_cost['line_items'] as $line_item)
                                            <tbody>
                                                <tr>
                                                    <td>{{ $line_item['description'] }}</td>
                                                    <td>{{ number_format($line_item['unit_cost']) }}</td>
                                                    <td>{{ number_format($line_item['total_cost']) }}</td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-filament-panels::page>
