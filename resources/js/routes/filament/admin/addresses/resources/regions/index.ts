import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\RegionResource\Pages\ManageRegions::index
* @see app/Filament/Resources/RegionResource/Pages/ManageRegions.php:7
* @route '/admin/addresses/regions'
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
    url: '/admin/addresses/regions',
}

/**
* @see \App\Filament\Resources\RegionResource\Pages\ManageRegions::index
* @see app/Filament/Resources/RegionResource/Pages/ManageRegions.php:7
* @route '/admin/addresses/regions'
*/
index.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\RegionResource\Pages\ManageRegions::index
* @see app/Filament/Resources/RegionResource/Pages/ManageRegions.php:7
* @route '/admin/addresses/regions'
*/
index.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\RegionResource\Pages\ManageRegions::index
* @see app/Filament/Resources/RegionResource/Pages/ManageRegions.php:7
* @route '/admin/addresses/regions'
*/
index.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: index.url(options),
    method: 'head',
})

const regions = {
    index,
}

export default regions