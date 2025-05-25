import { queryParams, type QueryParams } from './../../../../wayfinder'
/**
* @see \App\Filament\Store\Pages\BudgetEstimate::budgetEstimate
* @see app/Filament/Store/Pages/BudgetEstimate.php:7
* @route '/store/budget-estimate'
*/
export const budgetEstimate = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: budgetEstimate.url(options),
    method: 'get',
})

budgetEstimate.definition = {
    methods: ['get','head'],
    url: '/store/budget-estimate',
}

/**
* @see \App\Filament\Store\Pages\BudgetEstimate::budgetEstimate
* @see app/Filament/Store/Pages/BudgetEstimate.php:7
* @route '/store/budget-estimate'
*/
budgetEstimate.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return budgetEstimate.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Store\Pages\BudgetEstimate::budgetEstimate
* @see app/Filament/Store/Pages/BudgetEstimate.php:7
* @route '/store/budget-estimate'
*/
budgetEstimate.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: budgetEstimate.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Pages\BudgetEstimate::budgetEstimate
* @see app/Filament/Store/Pages/BudgetEstimate.php:7
* @route '/store/budget-estimate'
*/
budgetEstimate.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: budgetEstimate.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Store\Pages\CartIndex::cartIndex
* @see app/Filament/Store/Pages/CartIndex.php:7
* @route '/store/cart-index'
*/
export const cartIndex = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: cartIndex.url(options),
    method: 'get',
})

cartIndex.definition = {
    methods: ['get','head'],
    url: '/store/cart-index',
}

/**
* @see \App\Filament\Store\Pages\CartIndex::cartIndex
* @see app/Filament/Store/Pages/CartIndex.php:7
* @route '/store/cart-index'
*/
cartIndex.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return cartIndex.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Store\Pages\CartIndex::cartIndex
* @see app/Filament/Store/Pages/CartIndex.php:7
* @route '/store/cart-index'
*/
cartIndex.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: cartIndex.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Pages\CartIndex::cartIndex
* @see app/Filament/Store/Pages/CartIndex.php:7
* @route '/store/cart-index'
*/
cartIndex.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: cartIndex.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Store\Pages\CustomerProfile::customerProfile
* @see app/Filament/Store/Pages/CustomerProfile.php:7
* @route '/store/customer-profile'
*/
export const customerProfile = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: customerProfile.url(options),
    method: 'get',
})

customerProfile.definition = {
    methods: ['get','head'],
    url: '/store/customer-profile',
}

/**
* @see \App\Filament\Store\Pages\CustomerProfile::customerProfile
* @see app/Filament/Store/Pages/CustomerProfile.php:7
* @route '/store/customer-profile'
*/
customerProfile.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return customerProfile.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Store\Pages\CustomerProfile::customerProfile
* @see app/Filament/Store/Pages/CustomerProfile.php:7
* @route '/store/customer-profile'
*/
customerProfile.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: customerProfile.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Store\Pages\CustomerProfile::customerProfile
* @see app/Filament/Store/Pages/CustomerProfile.php:7
* @route '/store/customer-profile'
*/
customerProfile.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: customerProfile.url(options),
    method: 'head',
})

const pages = {
    budgetEstimate,
    cartIndex,
    customerProfile,
}

export default pages