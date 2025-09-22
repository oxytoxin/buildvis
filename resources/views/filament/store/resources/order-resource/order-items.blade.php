<div>
    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Product</th>
            <th class="px-4 py-2 text-sm font-semibold text-gray-600">Quantity</th>
            <th class="px-4 py-2 text-sm font-semibold text-gray-600">Unit Price</th>
            <th class="px-4 py-2 text-sm font-semibold text-gray-600">Subtotal</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
        @foreach($order->items as $item)
            <tr>
                <td class="px-4 py-2 text-sm text-gray-800">{{ $item->product_variation->product_slug }}</td>
                <td class="px-4 py-2 text-sm text-center text-gray-800">{{ $item->quantity }}</td>
                <td class="px-4 py-2 text-sm text-center text-gray-800">{{ $item->unit_price }}</td>
                <td class="px-4 py-2 text-sm text-center text-gray-800">{{ $item->subtotal }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
