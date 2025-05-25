import { queryParams, type QueryParams } from './../../../../../wayfinder'
/**
* @see \App\Filament\Resources\SupplierResource\Pages\ListSuppliers::index
* @see app/Filament/Resources/SupplierResource/Pages/ListSuppliers.php:7
* @route '/admin/suppliers'
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
    url: '/admin/suppliers',
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\ListSuppliers::index
* @see app/Filament/Resources/SupplierResource/Pages/ListSuppliers.php:7
* @route '/admin/suppliers'
*/
index.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\ListSuppliers::index
* @see app/Filament/Resources/SupplierResource/Pages/ListSuppliers.php:7
* @route '/admin/suppliers'
*/
index.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\SupplierResource\Pages\ListSuppliers::index
* @see app/Filament/Resources/SupplierResource/Pages/ListSuppliers.php:7
* @route '/admin/suppliers'
*/
index.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\SupplierResource\Pages\CreateSupplier::create
* @see app/Filament/Resources/SupplierResource/Pages/CreateSupplier.php:7
* @route '/admin/suppliers/create'
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
    url: '/admin/suppliers/create',
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\CreateSupplier::create
* @see app/Filament/Resources/SupplierResource/Pages/CreateSupplier.php:7
* @route '/admin/suppliers/create'
*/
create.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\CreateSupplier::create
* @see app/Filament/Resources/SupplierResource/Pages/CreateSupplier.php:7
* @route '/admin/suppliers/create'
*/
create.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\SupplierResource\Pages\CreateSupplier::create
* @see app/Filament/Resources/SupplierResource/Pages/CreateSupplier.php:7
* @route '/admin/suppliers/create'
*/
create.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\SupplierResource\Pages\EditSupplier::edit
* @see app/Filament/Resources/SupplierResource/Pages/EditSupplier.php:7
* @route '/admin/suppliers/{record}/edit'
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
    url: '/admin/suppliers/{record}/edit',
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\EditSupplier::edit
* @see app/Filament/Resources/SupplierResource/Pages/EditSupplier.php:7
* @route '/admin/suppliers/{record}/edit'
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
* @see \App\Filament\Resources\SupplierResource\Pages\EditSupplier::edit
* @see app/Filament/Resources/SupplierResource/Pages/EditSupplier.php:7
* @route '/admin/suppliers/{record}/edit'
*/
edit.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\SupplierResource\Pages\EditSupplier::edit
* @see app/Filament/Resources/SupplierResource/Pages/EditSupplier.php:7
* @route '/admin/suppliers/{record}/edit'
*/
edit.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: edit.url(args, options),
    method: 'head',
})

const suppliers = {
    index,
    create,
    edit,
}

export default suppliers