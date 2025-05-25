import { queryParams, type QueryParams } from './../../../../../wayfinder'
/**
* @see \App\Filament\Store\Pages\CustomerProfile::__invoke
* @see app/Filament/Store/Pages/CustomerProfile.php:7
* @route '/store/customer-profile'
*/
const CustomerProfile = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CustomerProfile.url(options),
    method: 'get',
})

CustomerProfile.definition = {
    methods: ['get','head'],
    url: '/store/customer-profile',
}

/**
* @see \App\Filament\Store\Pages\CustomerProfile::__invoke
* @see app/Filament/Store/Pages/CustomerProfile.php:7
* @route '/store/customer-profile'
*/
CustomerProfile.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return CustomerProfile.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Store\Pages\CustomerProfile::__invoke
* @see app/Filament/Store/Pages/CustomerProfile.php:7
* @route '/store/customer-profile'
*/
CustomerProfile.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CustomerProfile.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Pages\CustomerProfile::__invoke
* @see app/Filament/Store/Pages/CustomerProfile.php:7
* @route '/store/customer-profile'
*/
CustomerProfile.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: CustomerProfile.url(options),
    method: 'head',
})

export default CustomerProfile