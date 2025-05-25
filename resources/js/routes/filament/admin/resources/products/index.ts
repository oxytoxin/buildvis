import { queryParams, type QueryParams } from './../../../../../wayfinder'
/**
* @see \App\Filament\Resources\ProductResource\Pages\ListProducts::index
* @see app/Filament/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/admin/products'
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
    url: '/admin/products',
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\ListProducts::index
* @see app/Filament/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/admin/products'
*/
index.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\ListProducts::index
* @see app/Filament/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/admin/products'
*/
index.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ProductResource\Pages\ListProducts::index
* @see app/Filament/Resources/ProductResource/Pages/ListProducts.php:7
* @route '/admin/products'
*/
index.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\ProductResource\Pages\CreateProduct::create
* @see app/Filament/Resources/ProductResource/Pages/CreateProduct.php:7
* @route '/admin/products/create'
*/
export const create = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ['get','head'],
    url: '/admin/products/create',
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\CreateProduct::create
* @see app/Filament/Resources/ProductResource/Pages/CreateProduct.php:7
* @route '/admin/products/create'
*/
create.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\CreateProduct::create
* @see app/Filament/Resources/ProductResource/Pages/CreateProduct.php:7
* @route '/admin/products/create'
*/
create.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ProductResource\Pages\CreateProduct::create
* @see app/Filament/Resources/ProductResource/Pages/CreateProduct.php:7
* @route '/admin/products/create'
*/
create.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\ProductResource\Pages\EditProduct::edit
* @see app/Filament/Resources/ProductResource/Pages/EditProduct.php:7
* @route '/admin/products/{record}/edit'
*/
export const edit = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ['get','head'],
    url: '/admin/products/{record}/edit',
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\EditProduct::edit
* @see app/Filament/Resources/ProductResource/Pages/EditProduct.php:7
* @route '/admin/products/{record}/edit'
*/
edit.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
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

    return edit.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\EditProduct::edit
* @see app/Filament/Resources/ProductResource/Pages/EditProduct.php:7
* @route '/admin/products/{record}/edit'
*/
edit.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ProductResource\Pages\EditProduct::edit
* @see app/Filament/Resources/ProductResource/Pages/EditProduct.php:7
* @route '/admin/products/{record}/edit'
*/
edit.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: edit.url(args, options),
    method: 'head',
})

const products = {
    index,
    create,
    edit,
}

export default products