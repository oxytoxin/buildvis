import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\CreateWorkCategory::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/CreateWorkCategory.php:7
* @route '/admin/work-categories/create'
*/
const CreateWorkCategory = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CreateWorkCategory.url(options),
    method: 'get',
})

CreateWorkCategory.definition = {
    methods: ['get','head'],
    url: '/admin/work-categories/create',
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\CreateWorkCategory::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/CreateWorkCategory.php:7
* @route '/admin/work-categories/create'
*/
CreateWorkCategory.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return CreateWorkCategory.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\CreateWorkCategory::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/CreateWorkCategory.php:7
* @route '/admin/work-categories/create'
*/
CreateWorkCategory.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: CreateWorkCategory.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\CreateWorkCategory::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/CreateWorkCategory.php:7
* @route '/admin/work-categories/create'
*/
CreateWorkCategory.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: CreateWorkCategory.url(options),
    method: 'head',
})

export default CreateWorkCategory