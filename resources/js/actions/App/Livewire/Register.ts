import { queryParams, type QueryParams } from './../../../wayfinder'
/**
* @see \App\Livewire\Register::__invoke
* @see app/Livewire/Register.php:7
* @route '/register'
*/
const Register = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: Register.url(options),
    method: 'get',
})

Register.definition = {
    methods: ['get','head'],
    url: '/register',
}

/**
* @see \App\Livewire\Register::__invoke
* @see app/Livewire/Register.php:7
* @route '/register'
*/
Register.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return Register.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Register::__invoke
* @see app/Livewire/Register.php:7
* @route '/register'
*/
Register.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: Register.url(options),
    method: 'get',
})

/**
* @see \App\Livewire\Register::__invoke
* @see app/Livewire/Register.php:7
* @route '/register'
*/
Register.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: Register.url(options),
    method: 'head',
})

export default Register