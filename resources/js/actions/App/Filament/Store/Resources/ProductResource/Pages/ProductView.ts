import { queryParams, type QueryParams } from './../../../../../../../wayfinder'
/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ProductView::__invoke
* @see app/Filament/Store/Resources/ProductResource/Pages/ProductView.php:7
* @route '/store/products/{record}'
*/
const ProductView = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ProductView.url(args, options),
    method: 'get',
})

ProductView.definition = {
    methods: ['get','head'],
    url: '/store/products/{record}',
}

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ProductView::__invoke
* @see app/Filament/Store/Resources/ProductResource/Pages/ProductView.php:7
* @route '/store/products/{record}'
*/
ProductView.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    const parsedArgs = {
        record: args.record,
    }

    return ProductView.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ProductView::__invoke
* @see app/Filament/Store/Resources/ProductResource/Pages/ProductView.php:7
* @route '/store/products/{record}'
*/
ProductView.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ProductView.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ProductView::__invoke
* @see app/Filament/Store/Resources/ProductResource/Pages/ProductView.php:7
* @route '/store/products/{record}'
*/
ProductView.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: ProductView.url(args, options),
    method: 'head',
})

export default ProductView