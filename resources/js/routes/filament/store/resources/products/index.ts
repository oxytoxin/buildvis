import { queryParams, type QueryParams } from './../../../../../wayfinder'
/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ListProducts::index
* @see app/Filament/Store/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/store/products'
*/
export const index = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ['get','head'],
    url: '/store/products',
}

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ListProducts::index
* @see app/Filament/Store/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/store/products'
*/
index.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ListProducts::index
* @see app/Filament/Store/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/store/products'
*/
index.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ListProducts::index
* @see app/Filament/Store/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/store/products'
*/
index.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ProductView::view
* @see app/Filament/Store/Resources/ProductResource/Pages/ProductView.php:7
* @route '/store/products/{record}'
*/
export const view = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ['get','head'],
    url: '/store/products/{record}',
}

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ProductView::view
* @see app/Filament/Store/Resources/ProductResource/Pages/ProductView.php:7
* @route '/store/products/{record}'
*/
view.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
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

    return view.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ProductView::view
* @see app/Filament/Store/Resources/ProductResource/Pages/ProductView.php:7
* @route '/store/products/{record}'
*/
view.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Resources\ProductResource\Pages\ProductView::view
* @see app/Filament/Store/Resources/ProductResource/Pages/ProductView.php:7
* @route '/store/products/{record}'
*/
view.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: view.url(args, options),
    method: 'head',
})

const products = {
    index,
    view,
}

export default products