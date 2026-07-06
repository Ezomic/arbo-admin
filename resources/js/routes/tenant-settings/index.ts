import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\TenantSettingsController::show
* @see app/Http/Controllers/TenantSettingsController.php:16
* @route '/tenant-settings'
*/
export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/tenant-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TenantSettingsController::show
* @see app/Http/Controllers/TenantSettingsController.php:16
* @route '/tenant-settings'
*/
show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\TenantSettingsController::show
* @see app/Http/Controllers/TenantSettingsController.php:16
* @route '/tenant-settings'
*/
show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TenantSettingsController::show
* @see app/Http/Controllers/TenantSettingsController.php:16
* @route '/tenant-settings'
*/
show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\TenantSettingsController::show
* @see app/Http/Controllers/TenantSettingsController.php:16
* @route '/tenant-settings'
*/
const showForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TenantSettingsController::show
* @see app/Http/Controllers/TenantSettingsController.php:16
* @route '/tenant-settings'
*/
showForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TenantSettingsController::show
* @see app/Http/Controllers/TenantSettingsController.php:16
* @route '/tenant-settings'
*/
showForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \App\Http\Controllers\TenantSettingsController::update
* @see app/Http/Controllers/TenantSettingsController.php:28
* @route '/tenant-settings'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/tenant-settings',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\TenantSettingsController::update
* @see app/Http/Controllers/TenantSettingsController.php:28
* @route '/tenant-settings'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\TenantSettingsController::update
* @see app/Http/Controllers/TenantSettingsController.php:28
* @route '/tenant-settings'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\TenantSettingsController::update
* @see app/Http/Controllers/TenantSettingsController.php:28
* @route '/tenant-settings'
*/
const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TenantSettingsController::update
* @see app/Http/Controllers/TenantSettingsController.php:28
* @route '/tenant-settings'
*/
updateForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

const tenantSettings = {
    show: Object.assign(show, show),
    update: Object.assign(update, update),
}

export default tenantSettings