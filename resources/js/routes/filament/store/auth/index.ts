import { queryParams, type QueryParams } from './../../../../wayfinder'
/**
* @see \Filament\Http\Controllers\Auth\LogoutController::logout
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/store/logout'
*/
export const logout = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'post',
} => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ['post'],
    url: '/store/logout',
}

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::logout
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/store/logout'
*/
logout.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::logout
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/store/logout'
*/
logout.post = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'post',
} => ({
    url: logout.url(options),
    method: 'post',
})

const auth = {
    logout,
}

export default auth