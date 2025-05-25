import { queryParams, type QueryParams } from './../../../../wayfinder'
/**
* @see \App\Filament\Clusters\Addresses::__invoke
* @see app/Filament/Clusters/Addresses.php:7
* @route '/admin/addresses'
*/
const Addresses = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: Addresses.url(options),
    method: 'get',
})

Addresses.definition = {
    methods: ['get','head'],
    url: '/admin/addresses',
}

/**
* @see \App\Filament\Clusters\Addresses::__invoke
* @see app/Filament/Clusters/Addresses.php:7
* @route '/admin/addresses'
*/
Addresses.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return Addresses.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Clusters\Addresses::__invoke
* @see app/Filament/Clusters/Addresses.php:7
* @route '/admin/addresses'
*/
Addresses.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: Addresses.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Clusters\Addresses::__invoke
* @see app/Filament/Clusters/Addresses.php:7
* @route '/admin/addresses'
*/
Addresses.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: Addresses.url(options),
    method: 'head',
})

export default Addresses