import { queryParams, type QueryParams } from './../../../../../wayfinder'
/**
* @see \Filament\Http\Controllers\Auth\LogoutController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/admin/logout'
*/
const LogoutController2297a63ceae31609a74e9d0701fa1bd0 = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'post',
} => ({
    url: LogoutController2297a63ceae31609a74e9d0701fa1bd0.url(options),
    method: 'post',
})

LogoutController2297a63ceae31609a74e9d0701fa1bd0.definition = {
    methods: ['post'],
    url: '/admin/logout',
}

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/admin/logout'
*/
LogoutController2297a63ceae31609a74e9d0701fa1bd0.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return LogoutController2297a63ceae31609a74e9d0701fa1bd0.definition.url + queryParams(options)
}

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/admin/logout'
*/
LogoutController2297a63ceae31609a74e9d0701fa1bd0.post = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'post',
} => ({
    url: LogoutController2297a63ceae31609a74e9d0701fa1bd0.url(options),
    method: 'post',
})

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/store/logout'
*/
const LogoutController414887521f8e89529c5bec1346d8fbe0 = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'post',
} => ({
    url: LogoutController414887521f8e89529c5bec1346d8fbe0.url(options),
    method: 'post',
})

LogoutController414887521f8e89529c5bec1346d8fbe0.definition = {
    methods: ['post'],
    url: '/store/logout',
}

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/store/logout'
*/
LogoutController414887521f8e89529c5bec1346d8fbe0.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return LogoutController414887521f8e89529c5bec1346d8fbe0.definition.url + queryParams(options)
}

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/store/logout'
*/
LogoutController414887521f8e89529c5bec1346d8fbe0.post = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'post',
} => ({
    url: LogoutController414887521f8e89529c5bec1346d8fbe0.url(options),
    method: 'post',
})

const LogoutController = {
    '/admin/logout': LogoutController2297a63ceae31609a74e9d0701fa1bd0,
    '/store/logout': LogoutController414887521f8e89529c5bec1346d8fbe0,
}

export default LogoutController