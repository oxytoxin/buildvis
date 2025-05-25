import { queryParams, type QueryParams } from './../../../wayfinder'
import auth from './auth'
import pages from './pages'
import addresses from './addresses'
import resources from './resources'
/**
* @see \App\Filament\Clusters\Addresses::addresses
* @see app/Filament/Clusters/Addresses.php:7
* @route '/admin/addresses'
*/
export const addresses = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: addresses.url(options),
    method: 'get',
})

addresses.definition = {
    methods: ['get','head'],
    url: '/admin/addresses',
}

/**
* @see \App\Filament\Clusters\Addresses::addresses
* @see app/Filament/Clusters/Addresses.php:7
* @route '/admin/addresses'
*/
addresses.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return addresses.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Clusters\Addresses::addresses
* @see app/Filament/Clusters/Addresses.php:7
* @route '/admin/addresses'
*/
addresses.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: addresses.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Clusters\Addresses::addresses
* @see app/Filament/Clusters/Addresses.php:7
* @route '/admin/addresses'
*/
addresses.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: addresses.url(options),
    method: 'head',
})

const admin = {
    auth,
    pages,
    addresses,
    resources,
}

export default admin