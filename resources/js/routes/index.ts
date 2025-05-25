import { queryParams, type QueryParams } from './../wayfinder'
/**
* @see \App\Livewire\Welcome::welcome
* @see app/Livewire/Welcome.php:7
* @route '/'
*/
export const welcome = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: welcome.url(options),
    method: 'get',
})

welcome.definition = {
    methods: ['get','head'],
    url: '/',
}

/**
* @see \App\Livewire\Welcome::welcome
* @see app/Livewire/Welcome.php:7
* @route '/'
*/
welcome.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return welcome.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Welcome::welcome
* @see app/Livewire/Welcome.php:7
* @route '/'
*/
welcome.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: welcome.url(options),
    method: 'get',
})

/**
* @see \App\Livewire\Welcome::welcome
* @see app/Livewire/Welcome.php:7
* @route '/'
*/
welcome.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: welcome.url(options),
    method: 'head',
})

/**
* @see \App\Livewire\Register::register
* @see app/Livewire/Register.php:7
* @route '/register'
*/
export const register = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: register.url(options),
    method: 'get',
})

register.definition = {
    methods: ['get','head'],
    url: '/register',
}

/**
* @see \App\Livewire\Register::register
* @see app/Livewire/Register.php:7
* @route '/register'
*/
register.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return register.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Register::register
* @see app/Livewire/Register.php:7
* @route '/register'
*/
register.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: register.url(options),
    method: 'get',
})

/**
* @see \App\Livewire\Register::register
* @see app/Livewire/Register.php:7
* @route '/register'
*/
register.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: register.url(options),
    method: 'head',
})

/**
* @see \App\Livewire\Login::login
* @see app/Livewire/Login.php:7
* @route '/login'
*/
export const login = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ['get','head'],
    url: '/login',
}

/**
* @see \App\Livewire\Login::login
* @see app/Livewire/Login.php:7
* @route '/login'
*/
login.url = (options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Login::login
* @see app/Livewire/Login.php:7
* @route '/login'
*/
login.get = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: login.url(options),
    method: 'get',
})

/**
* @see \App\Livewire\Login::login
* @see app/Livewire/Login.php:7
* @route '/login'
*/
login.head = (options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: login.url(options),
    method: 'head',
})

