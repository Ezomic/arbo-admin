import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\ContractTypeController::index
* @see app/Http/Controllers/ContractTypeController.php:16
* @route '/contract-types'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/contract-types',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ContractTypeController::index
* @see app/Http/Controllers/ContractTypeController.php:16
* @route '/contract-types'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ContractTypeController::index
* @see app/Http/Controllers/ContractTypeController.php:16
* @route '/contract-types'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ContractTypeController::index
* @see app/Http/Controllers/ContractTypeController.php:16
* @route '/contract-types'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ContractTypeController::index
* @see app/Http/Controllers/ContractTypeController.php:16
* @route '/contract-types'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ContractTypeController::index
* @see app/Http/Controllers/ContractTypeController.php:16
* @route '/contract-types'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ContractTypeController::index
* @see app/Http/Controllers/ContractTypeController.php:16
* @route '/contract-types'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\ContractTypeController::store
* @see app/Http/Controllers/ContractTypeController.php:23
* @route '/contract-types'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/contract-types',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ContractTypeController::store
* @see app/Http/Controllers/ContractTypeController.php:23
* @route '/contract-types'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ContractTypeController::store
* @see app/Http/Controllers/ContractTypeController.php:23
* @route '/contract-types'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ContractTypeController::store
* @see app/Http/Controllers/ContractTypeController.php:23
* @route '/contract-types'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ContractTypeController::store
* @see app/Http/Controllers/ContractTypeController.php:23
* @route '/contract-types'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\ContractTypeController::edit
* @see app/Http/Controllers/ContractTypeController.php:35
* @route '/contract-types/{contractType}/edit'
*/
export const edit = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/contract-types/{contractType}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ContractTypeController::edit
* @see app/Http/Controllers/ContractTypeController.php:35
* @route '/contract-types/{contractType}/edit'
*/
edit.url = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contractType: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { contractType: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            contractType: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contractType: typeof args.contractType === 'object'
        ? args.contractType.id
        : args.contractType,
    }

    return edit.definition.url
            .replace('{contractType}', parsedArgs.contractType.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ContractTypeController::edit
* @see app/Http/Controllers/ContractTypeController.php:35
* @route '/contract-types/{contractType}/edit'
*/
edit.get = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ContractTypeController::edit
* @see app/Http/Controllers/ContractTypeController.php:35
* @route '/contract-types/{contractType}/edit'
*/
edit.head = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ContractTypeController::edit
* @see app/Http/Controllers/ContractTypeController.php:35
* @route '/contract-types/{contractType}/edit'
*/
const editForm = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ContractTypeController::edit
* @see app/Http/Controllers/ContractTypeController.php:35
* @route '/contract-types/{contractType}/edit'
*/
editForm.get = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ContractTypeController::edit
* @see app/Http/Controllers/ContractTypeController.php:35
* @route '/contract-types/{contractType}/edit'
*/
editForm.head = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\ContractTypeController::update
* @see app/Http/Controllers/ContractTypeController.php:49
* @route '/contract-types/{contractType}'
*/
export const update = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/contract-types/{contractType}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\ContractTypeController::update
* @see app/Http/Controllers/ContractTypeController.php:49
* @route '/contract-types/{contractType}'
*/
update.url = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contractType: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { contractType: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            contractType: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contractType: typeof args.contractType === 'object'
        ? args.contractType.id
        : args.contractType,
    }

    return update.definition.url
            .replace('{contractType}', parsedArgs.contractType.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ContractTypeController::update
* @see app/Http/Controllers/ContractTypeController.php:49
* @route '/contract-types/{contractType}'
*/
update.put = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\ContractTypeController::update
* @see app/Http/Controllers/ContractTypeController.php:49
* @route '/contract-types/{contractType}'
*/
const updateForm = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ContractTypeController::update
* @see app/Http/Controllers/ContractTypeController.php:49
* @route '/contract-types/{contractType}'
*/
updateForm.put = (args: { contractType: string | { id: string } } | [contractType: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

const contractTypes = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
}

export default contractTypes