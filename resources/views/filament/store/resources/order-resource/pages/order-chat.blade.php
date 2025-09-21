@php use App\Enums\MessageTypes;use App\Models\SystemConfig; @endphp
<x-filament-panels::page>
    <div class="flex flex-col items-start md:max-w-5xl w-full mx-auto">
        <img src="{{ SystemConfig::getGcashQrUrl() }}" class="w-48 rounded-lg" alt="gcash">
        <a href="{{ SystemConfig::getGcashQrUrl()  }}" target="_blank"
           class="border p-2 rounded mt-2 border-black">Download</a>
    </div>
    <x-order-chat-messages :order="$order"/>
</x-filament-panels::page>
