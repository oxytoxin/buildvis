import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages\ManageCityMunicipalities::index
* @see app/Filament/Clusters/PSGC/Resources/CityMunicipalityResource/Pages/ManageCityMunicipalities.php:7
* @route '/admin/addresses/city-municipalities'
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
    url: '/admin/addresses/city-municipalities',
}

/**
* @see \App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages\ManageCityMunicipalities::index
* @see app/Filament/Clusters/PSGC/Resources/CityMunicipalityResource/Pages/ManageCityMunicipalities.php:7
* @route '/admin/addresses/city-municipalities'
*/
index.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages\ManageCityMunicipalities::index
* @see app/Filament/Clusters/PSGC/Resources/CityMunicipalityResource/Pages/ManageCityMunicipalities.php:7
* @route '/admin/addresses/city-municipalities'
*/
index.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages\ManageCityMunicipalities::index
* @see app/Filament/Clusters/PSGC/Resources/CityMunicipalityResource/Pages/ManageCityMunicipalities.php:7
* @route '/admin/addresses/city-municipalities'
*/
index.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: index.url(options),
    method: 'head',
})

const cityMunicipalities = {
    index,
}

export default cityMunicipalities