import { queryParams, type QueryParams } from './../../../../../wayfinder'
/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\ListWorkCategories::index
* @see app/Filament/Resources/WorkCategoryResource/Pages/ListWorkCategories.php:7
* @route '/admin/work-categories'
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
    url: '/admin/work-categories',
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\ListWorkCategories::index
* @see app/Filament/Resources/WorkCategoryResource/Pages/ListWorkCategories.php:7
* @route '/admin/work-categories'
*/
index.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\ListWorkCategories::index
* @see app/Filament/Resources/WorkCategoryResource/Pages/ListWorkCategories.php:7
* @route '/admin/work-categories'
*/
index.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\ListWorkCategories::index
* @see app/Filament/Resources/WorkCategoryResource/Pages/ListWorkCategories.php:7
* @route '/admin/work-categories'
*/
index.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\CreateWorkCategory::create
* @see app/Filament/Resources/WorkCategoryResource/Pages/CreateWorkCategory.php:7
* @route '/admin/work-categories/create'
*/
export const create = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ['get','head'],
    url: '/admin/work-categories/create',
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\CreateWorkCategory::create
* @see app/Filament/Resources/WorkCategoryResource/Pages/CreateWorkCategory.php:7
* @route '/admin/work-categories/create'
*/
create.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\CreateWorkCategory::create
* @see app/Filament/Resources/WorkCategoryResource/Pages/CreateWorkCategory.php:7
* @route '/admin/work-categories/create'
*/
create.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\CreateWorkCategory::create
* @see app/Filament/Resources/WorkCategoryResource/Pages/CreateWorkCategory.php:7
* @route '/admin/work-categories/create'
*/
create.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\EditWorkCategory::edit
* @see app/Filament/Resources/WorkCategoryResource/Pages/EditWorkCategory.php:7
* @route '/admin/work-categories/{record}/edit'
*/
export const edit = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ['get','head'],
    url: '/admin/work-categories/{record}/edit',
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\EditWorkCategory::edit
* @see app/Filament/Resources/WorkCategoryResource/Pages/EditWorkCategory.php:7
* @route '/admin/work-categories/{record}/edit'
*/
edit.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    const parsedArgs = {
        record: args.record,
    }

    return edit.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\EditWorkCategory::edit
* @see app/Filament/Resources/WorkCategoryResource/Pages/EditWorkCategory.php:7
* @route '/admin/work-categories/{record}/edit'
*/
edit.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\EditWorkCategory::edit
* @see app/Filament/Resources/WorkCategoryResource/Pages/EditWorkCategory.php:7
* @route '/admin/work-categories/{record}/edit'
*/
edit.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: edit.url(args, options),
    method: 'head',
})

const workCategories = {
    index,
    create,
    edit,
}

export default workCategories