import { queryParams, type QueryParams } from './../../../../../wayfinder'
/**
* @see \App\Filament\Store\Pages\CartIndex::__invoke
* @see app/Filament/Store/Pages/CartIndex.php:7
* @route '/store/cart-index'
*/
const CartIndex = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CartIndex.url(options),
    method: 'get',
})

CartIndex.definition = {
    methods: ['get','head'],
    url: '/store/cart-index',
}

/**
* @see \App\Filament\Store\Pages\CartIndex::__invoke
* @see app/Filament/Store/Pages/CartIndex.php:7
* @route '/store/cart-index'
*/
CartIndex.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return CartIndex.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Store\Pages\CartIndex::__invoke
* @see app/Filament/Store/Pages/CartIndex.php:7
* @route '/store/cart-index'
*/
CartIndex.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CartIndex.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Pages\CartIndex::__invoke
* @see app/Filament/Store/Pages/CartIndex.php:7
* @route '/store/cart-index'
*/
CartIndex.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: CartIndex.url(options),
    method: 'head',
})

export default CartIndex