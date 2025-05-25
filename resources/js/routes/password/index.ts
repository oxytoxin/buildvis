import { queryParams, type QueryParams } from './../../wayfinder'
/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/forgot-password'
*/
export const request = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: request.url(options),
    method: 'get',
})

request.definition = {
    methods: ['get','head'],
    url: '/forgot-password',
}

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/forgot-password'
*/
request.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return request.definition.url + queryParams(options)
}

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/forgot-password'
*/
request.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: request.url(options),
    method: 'get',
})

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/forgot-password'
*/
request.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: request.url(options),
    method: 'head',
})

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/reset-password/{token}'
*/
export const reset = (args: { token: string | number } | [token: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: reset.url(args, options),
    method: 'get',
})

reset.definition = {
    methods: ['get','head'],
    url: '/reset-password/{token}',
}

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/reset-password/{token}'
*/
reset.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    if (Array.isArray(args)) {
        args = {
            token: args[0],
        }
    }

    const parsedArgs = {
        token: args.token,
    }

    return reset.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/reset-password/{token}'
*/
reset.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: reset.url(args, options),
    method: 'get',
})

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/reset-password/{token}'
*/
reset.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: reset.url(args, options),
    method: 'head',
})

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/confirm-password'
*/
export const confirm = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: confirm.url(options),
    method: 'get',
})

confirm.definition = {
    methods: ['get','head'],
    url: '/confirm-password',
}

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/confirm-password'
*/
confirm.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return confirm.definition.url + queryParams(options)
}

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/confirm-password'
*/
confirm.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: confirm.url(options),
    method: 'get',
})

/**
* @see vendor/livewire/volt/src/VoltManager.php:34
* @route '/confirm-password'
*/
confirm.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: confirm.url(options),
    method: 'head',
})

const password = {
    request,
    reset,
    confirm,
}

export default password