import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'

export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ['get', 'head'],
    url: '/tenant-settings',
} satisfies RouteDefinition<['get', 'head']>

show.url = (options?: RouteQueryOptions) => show.definition.url + queryParams(options)
show.get = show

const showForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(options),
    method: 'get',
})
showForm.get = showForm
show.form = showForm

export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ['put'],
    url: '/tenant-settings',
} satisfies RouteDefinition<['put']>

update.url = (options?: RouteQueryOptions) => update.definition.url + queryParams(options)
update.put = update

const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'post',
})
updateForm.put = updateForm
update.form = updateForm

const tenantSettings = { show, update }
export default tenantSettings
