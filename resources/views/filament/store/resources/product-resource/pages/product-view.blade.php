<x-filament-panels::page>
    <x-react-filament component="Store/ProductView"
                      :props="['product' => $product, 'cartData' => $cartData, 'model' => $model]"/>
</x-filament-panels::page>
