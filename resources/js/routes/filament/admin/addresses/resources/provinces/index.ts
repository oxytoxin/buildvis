import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\ProvinceResource\Pages\ManageProvinces::index
* @see app/Filament/Resources/ProvinceResource/Pages/ManageProvinces.php:7
* @route '/admin/addresses/provinces'
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
    url: '/admin/addresses/provinces',
}

/**
* @see \App\Filament\Resources\ProvinceResource\Pages\ManageProvinces::index
* @see app/Filament/Resources/ProvinceResource/Pages/ManageProvinces.php:7
* @route '/admin/addresses/provinces'
*/
index.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\ProvinceResource\Pages\ManageProvinces::index
* @see app/Filament/Resources/ProvinceResource/Pages/ManageProvinces.php:7
* @route '/admin/addresses/provinces'
*/
index.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ProvinceResource\Pages\ManageProvinces::index
* @see app/Filament/Resources/ProvinceResource/Pages/ManageProvinces.php:7
* @route '/admin/addresses/provinces'
*/
index.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: index.url(options),
    method: 'head',
})

const provinces = {
    index,
}

export default provinces