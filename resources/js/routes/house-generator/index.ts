import { queryParams, type QueryParams } from './../../wayfinder'
/**
* @see routes/web.php:50
* @route '/house-generator'
*/
export const view = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: view.url(options),
    method: 'get',
})

view.definition = {
    methods: ['get','head'],
    url: '/house-generator',
}

/**
* @see routes/web.php:50
* @route '/house-generator'
*/
view.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return view.definition.url + queryParams(options)
}

/**
* @see routes/web.php:50
* @route '/house-generator'
*/
view.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: view.url(options),
    method: 'get',
})

/**
* @see routes/web.php:50
* @route '/house-generator'
*/
view.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: view.url(options),
    method: 'head',
})

const houseGenerator = {
    view,
}

export default houseGenerator