import { queryParams, type QueryParams } from './../../wayfinder'
/**
* @see routes/web.php:42
* @route '/product/{product}'
*/
export const view = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ['get','head'],
    url: '/product/{product}',
}

/**
* @see routes/web.php:42
* @route '/product/{product}'
*/
view.url = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { product: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { product: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            product: args[0],
        }
    }

    const parsedArgs = {
        product: typeof args.product === 'object'
        ? args.product.id
        : args.product,
    }

    return view.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/web.php:42
* @route '/product/{product}'
*/
view.get = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see routes/web.php:42
* @route '/product/{product}'
*/
view.head = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: view.url(args, options),
    method: 'head',
})

const product = {
    view,
}

export default product