import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\ProductResource\Pages\CreateProduct::__invoke
* @see app/Filament/Resources/ProductResource/Pages/CreateProduct.php:7
* @route '/admin/products/create'
*/
const CreateProduct = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CreateProduct.url(options),
    method: 'get',
})

CreateProduct.definition = {
    methods: ['get','head'],
    url: '/admin/products/create',
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\CreateProduct::__invoke
* @see app/Filament/Resources/ProductResource/Pages/CreateProduct.php:7
* @route '/admin/products/create'
*/
CreateProduct.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return CreateProduct.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\CreateProduct::__invoke
* @see app/Filament/Resources/ProductResource/Pages/CreateProduct.php:7
* @route '/admin/products/create'
*/
CreateProduct.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CreateProduct.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ProductResource\Pages\CreateProduct::__invoke
* @see app/Filament/Resources/ProductResource/Pages/CreateProduct.php:7
* @route '/admin/products/create'
*/
CreateProduct.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: CreateProduct.url(options),
    method: 'head',
})

export default CreateProduct