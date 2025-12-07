@php use App\Enums\MessageTypes; @endphp
@props([
    /** @var \App\Models\Order */
    'order'
])
<div class="md:max-w-5xl w-full mx-auto">
    <div class="flex flex-col gap-4 mt-4">
        @foreach($order->messages()->get() as $message)
            <div @class([
                    'flex flex-col',
                    'items-end' => $message->user_id === auth()->id(),
                    'items-start' => $message->user_id !== auth()->id()
                ])>
                @if($message->type === MessageTypes::IMAGE)
                    <img class="w-56 rounded" src="{{ $message->content }}" alt="order uploads">
                @else
                    <div @class([
                        'p-2 rounded-lg',
                        'bg-primary-500' => $message->user_id === auth()->id(),
                        'bg-gray-200' => $message->user_id !== auth()->id()
                        ])>
                        <p>{{ $message->content }}</p>
                    </div>
                @endif
            </div>

        @endforeach
    </div>
    <div>
    </div>
    <form wire:submit.prevent="sendMessage"
          class="mt-4 bg-primary-700 md:max-w-5xl w-full mx-auto rounded-lg px-8 py-4 sticky bottom-8 flex-col md:flex-row flex gap-2">
        <div class="w-full">{{ $this->form }}</div>
        <div class="flex gap-2 flex-1">
            <x-filament::button wire:target="sendMessage" class="px-8" type="submit">Send</x-filament::button>
        </div>
    </form>
</div>
