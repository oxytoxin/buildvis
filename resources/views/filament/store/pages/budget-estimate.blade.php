<x-filament-panels::page>
    <div>
        <label for="budget">Budget</label>
        <input type="number" id="budget" class="border border-black w-full" wire:model="budget" />
    </div>
    <div x-data>
        <div class="flex gap-8 w-full">
            <div class="w-1/2 h-96 bg-gray-200 p-4 overflow-y-auto">
                <h2>Reasoning</h2>
                <div id="reasoning" class="text-xs" wire:stream="reasoning">{!! $reasoning !!}</div>
            </div>

            <div class="w-1/2 h-96 bg-gray-200 p-4 overflow-y-auto">
                <h2>Content</h2>
                <div id="content" class="text-xs" wire:stream="content">{!! $content !!}</div>
            </div>
        </div>
        <div class="flex gap-2 items-center">
            <x-filament::button wire:click="calculate" class="mt-8" color="primary">Calculate</x-filament::button>
            <x-filament::button wire:click="format" class="mt-8" color="primary">Format</x-filament::button>
        </div>
    </div>
    @script
        <script>
            $js('formatmd', () => {
                $wire.content = marked.marked($wire.content);
                $wire.reasoning = marked.marked($wire.reasoning);
            })
        </script>
    @endscript

</x-filament-panels::page>
