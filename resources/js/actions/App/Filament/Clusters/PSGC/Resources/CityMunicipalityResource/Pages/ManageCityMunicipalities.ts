import { queryParams, type QueryParams } from './../../../../../../../../wayfinder'
/**
* @see \App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages\ManageCityMunicipalities::__invoke
* @see app/Filament/Clusters/PSGC/Resources/CityMunicipalityResource/Pages/ManageCityMunicipalities.php:7
* @route '/admin/addresses/city-municipalities'
*/
const ManageCityMunicipalities = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ManageCityMunicipalities.url(options),
    method: 'get',
})

ManageCityMunicipalities.definition = {
    methods: ['get','head'],
    url: '/admin/addresses/city-municipalities',
}

/**
* @see \App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages\ManageCityMunicipalities::__invoke
* @see app/Filament/Clusters/PSGC/Resources/CityMunicipalityResource/Pages/ManageCityMunicipalities.php:7
* @route '/admin/addresses/city-municipalities'
*/
ManageCityMunicipalities.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return ManageCityMunicipalities.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages\ManageCityMunicipalities::__invoke
* @see app/Filament/Clusters/PSGC/Resources/CityMunicipalityResource/Pages/ManageCityMunicipalities.php:7
* @route '/admin/addresses/city-municipalities'
*/
ManageCityMunicipalities.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ManageCityMunicipalities.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages\ManageCityMunicipalities::__invoke
* @see app/Filament/Clusters/PSGC/Resources/CityMunicipalityResource/Pages/ManageCityMunicipalities.php:7
* @route '/admin/addresses/city-municipalities'
*/
ManageCityMunicipalities.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: ManageCityMunicipalities.url(options),
    method: 'head',
})

export default ManageCityMunicipalities