@php use App\Enums\MessageTypes; @endphp
<x-filament-panels::page>
    <div class="md:max-w-5xl w-full mx-auto">
        <div class="flex flex-col items-start">
            <img src="{{ asset('images/gcash.jpg') }}" class="w-48 rounded-lg" alt="gcash">
            <a href="{{ asset('images/gcash.jpg') }}" class="border p-2 rounded mt-2 border-black"
               download="Buildvis Arenger Gcash">Download</a>
        </div>
        <div class="flex flex-col gap-4 mt-4">
            @foreach($order->messages()->get() as $message)
                <div @class([
                    'flex flex-col',
                    'items-end' => $message->user_id === auth()->id()
                ])>
                    @if($message->type === MessageTypes::IMAGE)
                        <img class="w-56 rounded" src="{{ $message->content }}" alt="order uploads">
                    @else
                        <div class="p-2 bg-primary-200">
                            <p>{{ $message->content }}</p>
                        </div>
                    @endif
                </div>

            @endforeach
        </div>
        <form wire:submit.prevent="sendMessage"
              class="mt-4 bg-primary-700 rounded-lg px-8 py-4 sticky bottom-8 flex-col md:flex-row flex gap-2">
            <input type="file" class="border p-2 bg-white border-black " wire:model="file" wire:loading.attr="disabled">
            <div class="flex gap-2 flex-1">
                <input class="text-xs flex-1 !border !border-black rounded" wire:model="message" type="text"/>
                <x-filament::button wire:target="sendMessage" class="px-8" type="submit">Send</x-filament::button>
            </div>
        </form>
    </div>

</x-filament-panels::page>
