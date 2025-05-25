import { queryParams, type QueryParams } from './../../../../../../../wayfinder'
/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ListProducts::__invoke
* @see app/Filament/Store/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/store/products'
*/
const ListProducts = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ListProducts.url(options),
    method: 'get',
})

ListProducts.definition = {
    methods: ['get','head'],
    url: '/store/products',
}

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ListProducts::__invoke
* @see app/Filament/Store/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/store/products'
*/
ListProducts.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return ListProducts.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ListProducts::__invoke
* @see app/Filament/Store/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/store/products'
*/
ListProducts.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ListProducts.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ListProducts::__invoke
* @see app/Filament/Store/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/store/products'
*/
ListProducts.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: ListProducts.url(options),
    method: 'head',
})

export default ListProducts