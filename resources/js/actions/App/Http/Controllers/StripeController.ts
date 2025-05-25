import { queryParams, type QueryParams } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StripeController::checkout
* @see app/Http/Controllers/StripeController.php:14
* @route '/stripe-checkout/{order}'
*/
export const checkout = (args: { order: number | { id: number } } | [order: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: checkout.url(args, options),
    method: 'get',
})

checkout.definition = {
    methods: ['get','head'],
    url: '/stripe-checkout/{order}',
}

/**
* @see \App\Http\Controllers\StripeController::checkout
* @see app/Http/Controllers/StripeController.php:14
* @route '/stripe-checkout/{order}'
*/
checkout.url = (args: { order: number | { id: number } } | [order: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { order: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { order: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            order: args[0],
        }
    }

    const parsedArgs = {
        order: typeof args.order === 'object'
        ? args.order.id
        : args.order,
    }

    return checkout.definition.url
            .replace('{order}', parsedArgs.order.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StripeController::checkout
* @see app/Http/Controllers/StripeController.php:14
* @route '/stripe-checkout/{order}'
*/
checkout.get = (args: { order: number | { id: number } } | [order: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: checkout.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StripeController::checkout
* @see app/Http/Controllers/StripeController.php:14
* @route '/stripe-checkout/{order}'
*/
checkout.head = (args: { order: number | { id: number } } | [order: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: checkout.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StripeController::cancel
* @see app/Http/Controllers/StripeController.php:63
* @route '/stripe-cancel/{order}'
*/
export const cancel = (args: { order: string | number } | [order: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: cancel.url(args, options),
    method: 'get',
})

cancel.definition = {
    methods: ['get','head'],
    url: '/stripe-cancel/{order}',
}

/**
* @see \App\Http\Controllers\StripeController::cancel
* @see app/Http/Controllers/StripeController.php:63
* @route '/stripe-cancel/{order}'
*/
cancel.url = (args: { order: string | number } | [order: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { order: args }
    }

    if (Array.isArray(args)) {
        args = {
            order: args[0],
        }
    }

    const parsedArgs = {
        order: args.order,
    }

    return cancel.definition.url
            .replace('{order}', parsedArgs.order.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StripeController::cancel
* @see app/Http/Controllers/StripeController.php:63
* @route '/stripe-cancel/{order}'
*/
cancel.get = (args: { order: string | number } | [order: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: cancel.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StripeController::cancel
* @see app/Http/Controllers/StripeController.php:63
* @route '/stripe-cancel/{order}'
*/
cancel.head = (args: { order: string | number } | [order: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: cancel.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StripeController::success
* @see app/Http/Controllers/StripeController.php:38
* @route '/stripe-success/{order}'
*/
export const success = (args: { order: number | { id: number } } | [order: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: success.url(args, options),
    method: 'get',
})

success.definition = {
    methods: ['get','head'],
    url: '/stripe-success/{order}',
}

/**
* @see \App\Http\Controllers\StripeController::success
* @see app/Http/Controllers/StripeController.php:38
* @route '/stripe-success/{order}'
*/
success.url = (args: { order: number | { id: number } } | [order: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { order: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { order: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            order: args[0],
        }
    }

    const parsedArgs = {
        order: typeof args.order === 'object'
        ? args.order.id
        : args.order,
    }

    return success.definition.url
            .replace('{order}', parsedArgs.order.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StripeController::success
* @see app/Http/Controllers/StripeController.php:38
* @route '/stripe-success/{order}'
*/
success.get = (args: { order: number | { id: number } } | [order: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: success.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StripeController::success
* @see app/Http/Controllers/StripeController.php:38
* @route '/stripe-success/{order}'
*/
success.head = (args: { order: number | { id: number } } | [order: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: success.url(args, options),
    method: 'head',
})

const StripeController = { checkout, cancel, success }

export default StripeController