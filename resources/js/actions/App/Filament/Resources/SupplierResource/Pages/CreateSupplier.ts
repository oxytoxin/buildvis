import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\SupplierResource\Pages\CreateSupplier::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/CreateSupplier.php:7
* @route '/admin/suppliers/create'
*/
const CreateSupplier = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CreateSupplier.url(options),
    method: 'get',
})

CreateSupplier.definition = {
    methods: ['get','head'],
    url: '/admin/suppliers/create',
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\CreateSupplier::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/CreateSupplier.php:7
* @route '/admin/suppliers/create'
*/
CreateSupplier.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return CreateSupplier.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\CreateSupplier::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/CreateSupplier.php:7
* @route '/admin/suppliers/create'
*/
CreateSupplier.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CreateSupplier.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\SupplierResource\Pages\CreateSupplier::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/CreateSupplier.php:7
* @route '/admin/suppliers/create'
*/
CreateSupplier.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: CreateSupplier.url(options),
    method: 'head',
})

export default CreateSupplier