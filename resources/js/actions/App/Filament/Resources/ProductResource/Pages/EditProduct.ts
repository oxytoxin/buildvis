import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\ProductResource\Pages\EditProduct::__invoke
* @see app/Filament/Resources/ProductResource/Pages/EditProduct.php:7
* @route '/admin/products/{record}/edit'
*/
const EditProduct = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: EditProduct.url(args, options),
    method: 'get',
})

EditProduct.definition = {
    methods: ['get','head'],
    url: '/admin/products/{record}/edit',
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\EditProduct::__invoke
* @see app/Filament/Resources/ProductResource/Pages/EditProduct.php:7
* @route '/admin/products/{record}/edit'
*/
EditProduct.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
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

    return EditProduct.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\ProductResource\Pages\EditProduct::__invoke
* @see app/Filament/Resources/ProductResource/Pages/EditProduct.php:7
* @route '/admin/products/{record}/edit'
*/
EditProduct.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: EditProduct.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ProductResource\Pages\EditProduct::__invoke
* @see app/Filament/Resources/ProductResource/Pages/EditProduct.php:7
* @route '/admin/products/{record}/edit'
*/
EditProduct.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: EditProduct.url(args, options),
    method: 'head',
})

export default EditProduct