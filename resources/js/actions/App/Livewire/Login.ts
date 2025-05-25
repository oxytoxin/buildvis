import { queryParams, type QueryParams } from './../../../wayfinder'
/**
* @see \App\Livewire\Login::__invoke
* @see app/Livewire/Login.php:7
* @route '/login'
*/
const Login = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: Login.url(options),
    method: 'get',
})

Login.definition = {
    methods: ['get','head'],
    url: '/login',
}

/**
* @see \App\Livewire\Login::__invoke
* @see app/Livewire/Login.php:7
* @route '/login'
*/
Login.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return Login.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Login::__invoke
* @see app/Livewire/Login.php:7
* @route '/login'
*/
Login.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: Login.url(options),
    method: 'get',
})

/**
* @see \App\Livewire\Login::__invoke
* @see app/Livewire/Login.php:7
* @route '/login'
*/
Login.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: Login.url(options),
    method: 'head',
})

export default Login