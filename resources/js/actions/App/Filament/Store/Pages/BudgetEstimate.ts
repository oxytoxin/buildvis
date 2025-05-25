import { queryParams, type QueryParams } from './../../../../../wayfinder'
/**
* @see \App\Filament\Store\Pages\BudgetEstimate::__invoke
* @see app/Filament/Store/Pages/BudgetEstimate.php:7
* @route '/store/budget-estimate'
*/
const BudgetEstimate = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: BudgetEstimate.url(options),
    method: 'get',
})

BudgetEstimate.definition = {
    methods: ['get','head'],
    url: '/store/budget-estimate',
}

/**
* @see \App\Filament\Store\Pages\BudgetEstimate::__invoke
* @see app/Filament/Store/Pages/BudgetEstimate.php:7
* @route '/store/budget-estimate'
*/
BudgetEstimate.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return BudgetEstimate.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Store\Pages\BudgetEstimate::__invoke
* @see app/Filament/Store/Pages/BudgetEstimate.php:7
* @route '/store/budget-estimate'
*/
BudgetEstimate.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: BudgetEstimate.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Pages\BudgetEstimate::__invoke
* @see app/Filament/Store/Pages/BudgetEstimate.php:7
* @route '/store/budget-estimate'
*/
BudgetEstimate.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: BudgetEstimate.url(options),
    method: 'head',
})

export default BudgetEstimate