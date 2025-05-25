import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\SupplierResource\Pages\ListSuppliers::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/ListSuppliers.php:7
* @route '/admin/suppliers'
*/
const ListSuppliers = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ListSuppliers.url(options),
    method: 'get',
})

ListSuppliers.definition = {
    methods: ['get','head'],
    url: '/admin/suppliers',
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\ListSuppliers::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/ListSuppliers.php:7
* @route '/admin/suppliers'
*/
ListSuppliers.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return ListSuppliers.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\SupplierResource\Pages\ListSuppliers::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/ListSuppliers.php:7
* @route '/admin/suppliers'
*/
ListSuppliers.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ListSuppliers.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\SupplierResource\Pages\ListSuppliers::__invoke
* @see app/Filament/Resources/SupplierResource/Pages/ListSuppliers.php:7
* @route '/admin/suppliers'
*/
ListSuppliers.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: ListSuppliers.url(options),
    method: 'head',
})

export default ListSuppliers