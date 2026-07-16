import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
    applyUrlDefaults,
} from './../../wayfinder';
/**
 * @see \App\Http\Controllers\DataBreachController::index
 * @see app/Http/Controllers/DataBreachController.php:17
 * @route '/data-breaches'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

index.definition = {
    methods: ['get', 'head'],
    url: '/data-breaches',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\DataBreachController::index
 * @see app/Http/Controllers/DataBreachController.php:17
 * @route '/data-breaches'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\DataBreachController::index
 * @see app/Http/Controllers/DataBreachController.php:17
 * @route '/data-breaches'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\DataBreachController::index
 * @see app/Http/Controllers/DataBreachController.php:17
 * @route '/data-breaches'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\DataBreachController::index
 * @see app/Http/Controllers/DataBreachController.php:17
 * @route '/data-breaches'
 */
const indexForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\DataBreachController::index
 * @see app/Http/Controllers/DataBreachController.php:17
 * @route '/data-breaches'
 */
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\DataBreachController::index
 * @see app/Http/Controllers/DataBreachController.php:17
 * @route '/data-breaches'
 */
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

index.form = indexForm;

/**
 * @see \App\Http\Controllers\DataBreachController::create
 * @see app/Http/Controllers/DataBreachController.php:26
 * @route '/data-breaches/create'
 */
export const create = (
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
});

create.definition = {
    methods: ['get', 'head'],
    url: '/data-breaches/create',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\DataBreachController::create
 * @see app/Http/Controllers/DataBreachController.php:26
 * @route '/data-breaches/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\DataBreachController::create
 * @see app/Http/Controllers/DataBreachController.php:26
 * @route '/data-breaches/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\DataBreachController::create
 * @see app/Http/Controllers/DataBreachController.php:26
 * @route '/data-breaches/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\DataBreachController::create
 * @see app/Http/Controllers/DataBreachController.php:26
 * @route '/data-breaches/create'
 */
const createForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\DataBreachController::create
 * @see app/Http/Controllers/DataBreachController.php:26
 * @route '/data-breaches/create'
 */
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\DataBreachController::create
 * @see app/Http/Controllers/DataBreachController.php:26
 * @route '/data-breaches/create'
 */
createForm.head = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

create.form = createForm;

/**
 * @see \App\Http\Controllers\DataBreachController::store
 * @see app/Http/Controllers/DataBreachController.php:31
 * @route '/data-breaches'
 */
export const store = (
    options?: RouteQueryOptions,
): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
});

store.definition = {
    methods: ['post'],
    url: '/data-breaches',
} satisfies RouteDefinition<['post']>;

/**
 * @see \App\Http\Controllers\DataBreachController::store
 * @see app/Http/Controllers/DataBreachController.php:31
 * @route '/data-breaches'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\DataBreachController::store
 * @see app/Http/Controllers/DataBreachController.php:31
 * @route '/data-breaches'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\DataBreachController::store
 * @see app/Http/Controllers/DataBreachController.php:31
 * @route '/data-breaches'
 */
const storeForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\DataBreachController::store
 * @see app/Http/Controllers/DataBreachController.php:31
 * @route '/data-breaches'
 */
storeForm.post = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
});

store.form = storeForm;

/**
 * @see \App\Http\Controllers\DataBreachController::notify
 * @see app/Http/Controllers/DataBreachController.php:60
 * @route '/data-breaches/{dataBreach}/notify'
 */
export const notify = (
    args:
        | { dataBreach: string | { id: string } }
        | [dataBreach: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'patch'> => ({
    url: notify.url(args, options),
    method: 'patch',
});

notify.definition = {
    methods: ['patch'],
    url: '/data-breaches/{dataBreach}/notify',
} satisfies RouteDefinition<['patch']>;

/**
 * @see \App\Http\Controllers\DataBreachController::notify
 * @see app/Http/Controllers/DataBreachController.php:60
 * @route '/data-breaches/{dataBreach}/notify'
 */
notify.url = (
    args:
        | { dataBreach: string | { id: string } }
        | [dataBreach: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dataBreach: args };
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { dataBreach: args.id };
    }

    if (Array.isArray(args)) {
        args = {
            dataBreach: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        dataBreach:
            typeof args.dataBreach === 'object'
                ? args.dataBreach.id
                : args.dataBreach,
    };

    return (
        notify.definition.url
            .replace('{dataBreach}', parsedArgs.dataBreach.toString())
            .replace(/\/+$/, '') + queryParams(options)
    );
};

/**
 * @see \App\Http\Controllers\DataBreachController::notify
 * @see app/Http/Controllers/DataBreachController.php:60
 * @route '/data-breaches/{dataBreach}/notify'
 */
notify.patch = (
    args:
        | { dataBreach: string | { id: string } }
        | [dataBreach: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'patch'> => ({
    url: notify.url(args, options),
    method: 'patch',
});

/**
 * @see \App\Http\Controllers\DataBreachController::notify
 * @see app/Http/Controllers/DataBreachController.php:60
 * @route '/data-breaches/{dataBreach}/notify'
 */
const notifyForm = (
    args:
        | { dataBreach: string | { id: string } }
        | [dataBreach: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: notify.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\DataBreachController::notify
 * @see app/Http/Controllers/DataBreachController.php:60
 * @route '/data-breaches/{dataBreach}/notify'
 */
notifyForm.patch = (
    args:
        | { dataBreach: string | { id: string } }
        | [dataBreach: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: notify.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'post',
});

notify.form = notifyForm;

const dataBreaches = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    notify: Object.assign(notify, notify),
};

export default dataBreaches;
