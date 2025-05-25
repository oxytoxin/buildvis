import { queryParams, type QueryParams } from './../../../wayfinder'
/**
* @see \App\Livewire\Welcome::__invoke
* @see app/Livewire/Welcome.php:7
* @route '/'
*/
const Welcome = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: Welcome.url(options),
    method: 'get',
})

Welcome.definition = {
    methods: ['get','head'],
    url: '/',
}

/**
* @see \App\Livewire\Welcome::__invoke
* @see app/Livewire/Welcome.php:7
* @route '/'
*/
Welcome.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return Welcome.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Welcome::__invoke
* @see app/Livewire/Welcome.php:7
* @route '/'
*/
Welcome.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: Welcome.url(options),
    method: 'get',
})

/**
* @see \App\Livewire\Welcome::__invoke
* @see app/Livewire/Welcome.php:7
* @route '/'
*/
Welcome.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: Welcome.url(options),
    method: 'head',
})

export default Welcome