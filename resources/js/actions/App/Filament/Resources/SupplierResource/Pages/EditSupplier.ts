import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\SupplierResource\Pages\EditSupplier::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/EditSupplier.php:7
* @route '/admin/suppliers/{record}/edit'
*/
const EditSupplier = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: EditSupplier.url(args, options),
    method: 'get',
})

EditSupplier.definition = {
    methods: ['get','head'],
    url: '/admin/suppliers/{record}/edit',
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\EditSupplier::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/EditSupplier.php:7
* @route '/admin/suppliers/{record}/edit'
*/
EditSupplier.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
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

    return EditSupplier.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\EditSupplier::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/EditSupplier.php:7
* @route '/admin/suppliers/{record}/edit'
*/
EditSupplier.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: EditSupplier.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\SupplierResource\Pages\EditSupplier::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/EditSupplier.php:7
* @route '/admin/suppliers/{record}/edit'
*/
EditSupplier.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: EditSupplier.url(args, options),
    method: 'head',
})

export default EditSupplier