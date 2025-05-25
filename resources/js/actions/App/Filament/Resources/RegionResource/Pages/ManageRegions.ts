import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\RegionResource\Pages\ManageRegions::__invoke
* @see app/Filament/Resources/RegionResource/Pages/ManageRegions.php:7
* @route '/admin/addresses/regions'
*/
const ManageRegions = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ManageRegions.url(options),
    method: 'get',
})

ManageRegions.definition = {
    methods: ['get','head'],
    url: '/admin/addresses/regions',
}

/**
* @see \App\Filament\Resources\RegionResource\Pages\ManageRegions::__invoke
* @see app/Filament/Resources/RegionResource/Pages/ManageRegions.php:7
* @route '/admin/addresses/regions'
*/
ManageRegions.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return ManageRegions.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\RegionResource\Pages\ManageRegions::__invoke
* @see app/Filament/Resources/RegionResource/Pages/ManageRegions.php:7
* @route '/admin/addresses/regions'
*/
ManageRegions.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ManageRegions.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\RegionResource\Pages\ManageRegions::__invoke
* @see app/Filament/Resources/RegionResource/Pages/ManageRegions.php:7
* @route '/admin/addresses/regions'
*/
ManageRegions.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: ManageRegions.url(options),
    method: 'head',
})

export default ManageRegions