import { queryParams, type QueryParams } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\EditWorkCategory::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/EditWorkCategory.php:7
* @route '/admin/work-categories/{record}/edit'
*/
const EditWorkCategory = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: EditWorkCategory.url(args, options),
    method: 'get',
})

EditWorkCategory.definition = {
    methods: ['get','head'],
    url: '/admin/work-categories/{record}/edit',
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\EditWorkCategory::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/EditWorkCategory.php:7
* @route '/admin/work-categories/{record}/edit'
*/
EditWorkCategory.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
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

    return EditWorkCategory.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\EditWorkCategory::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/EditWorkCategory.php:7
* @route '/admin/work-categories/{record}/edit'
*/
EditWorkCategory.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: EditWorkCategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\WorkCategoryResource\Pages\EditWorkCategory::__invoke
* @see app/Filament/Resources/WorkCategoryResource/Pages/EditWorkCategory.php:7
* @route '/admin/work-categories/{record}/edit'
*/
EditWorkCategory.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: EditWorkCategory.url(args, options),
    method: 'head',
})

export default EditWorkCategory