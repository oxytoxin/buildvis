import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\ListWorkCategories::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/ListWorkCategories.php:7
* @route '/admin/work-categories'
*/
const ListWorkCategories = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ListWorkCategories.url(options),
    method: 'get',
})

ListWorkCategories.definition = {
    methods: ['get','head'],
    url: '/admin/work-categories',
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\ListWorkCategories::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/ListWorkCategories.php:7
* @route '/admin/work-categories'
*/
ListWorkCategories.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return ListWorkCategories.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\ListWorkCategories::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/ListWorkCategories.php:7
* @route '/admin/work-categories'
*/
ListWorkCategories.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: ListWorkCategories.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\ListWorkCategories::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/ListWorkCategories.php:7
* @route '/admin/work-categories'
*/
ListWorkCategories.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: ListWorkCategories.url(options),
    method: 'head',
})

export default ListWorkCategories