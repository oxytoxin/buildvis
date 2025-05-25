import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\ProvinceResource\Pages\ManageProvinces::__invoke
* @see app/Filament/Resources/ProvinceResource/Pages/ManageProvinces.php:7
* @route '/admin/addresses/provinces'
*/
const ManageProvinces = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ManageProvinces.url(options),
    method: 'get',
})

ManageProvinces.definition = {
    methods: ['get','head'],
    url: '/admin/addresses/provinces',
}

/**
* @see \App\Filament\Resources\ProvinceResource\Pages\ManageProvinces::__invoke
* @see app/Filament/Resources/ProvinceResource/Pages/ManageProvinces.php:7
* @route '/admin/addresses/provinces'
*/
ManageProvinces.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return ManageProvinces.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\ProvinceResource\Pages\ManageProvinces::__invoke
* @see app/Filament/Resources/ProvinceResource/Pages/ManageProvinces.php:7
* @route '/admin/addresses/provinces'
*/
ManageProvinces.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ManageProvinces.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ProvinceResource\Pages\ManageProvinces::__invoke
* @see app/Filament/Resources/ProvinceResource/Pages/ManageProvinces.php:7
* @route '/admin/addresses/provinces'
*/
ManageProvinces.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: ManageProvinces.url(options),
    method: 'head',
})

export default ManageProvinces