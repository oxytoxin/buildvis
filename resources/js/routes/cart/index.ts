import { queryParams, type QueryParams } from './../../wayfinder'
/**
* @see \App\Http\Controllers\CartController::add
* @see app/Http/Controllers/CartController.php:16
* @route '/cart/add'
*/
export const add = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'post',
} => ({
    url: add.url(options),
    method: 'post',
})

add.definition = {
    methods: ['post'],
    url: '/cart/add',
}

/**
* @see \App\Http\Controllers\CartController::add
* @see app/Http/Controllers/CartController.php:16
* @route '/cart/add'
*/
add.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return add.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CartController::add
* @see app/Http/Controllers/CartController.php:16
* @route '/cart/add'
*/
add.post = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'post',
} => ({
    url: add.url(options),
    method: 'post',
})

const cart = {
    add,
}

export default cart