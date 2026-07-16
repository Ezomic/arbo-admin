import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
    applyUrlDefaults,
} from './../../wayfinder';
/**
 * @see \App\Http\Controllers\TaskTypeController::index
 * @see app/Http/Controllers/TaskTypeController.php:17
 * @route '/task-types'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

index.definition = {
    methods: ['get', 'head'],
    url: '/task-types',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\TaskTypeController::index
 * @see app/Http/Controllers/TaskTypeController.php:17
 * @route '/task-types'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\TaskTypeController::index
 * @see app/Http/Controllers/TaskTypeController.php:17
 * @route '/task-types'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::index
 * @see app/Http/Controllers/TaskTypeController.php:17
 * @route '/task-types'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::index
 * @see app/Http/Controllers/TaskTypeController.php:17
 * @route '/task-types'
 */
const indexForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::index
 * @see app/Http/Controllers/TaskTypeController.php:17
 * @route '/task-types'
 */
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::index
 * @see app/Http/Controllers/TaskTypeController.php:17
 * @route '/task-types'
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
 * @see \App\Http\Controllers\TaskTypeController::store
 * @see app/Http/Controllers/TaskTypeController.php:24
 * @route '/task-types'
 */
export const store = (
    options?: RouteQueryOptions,
): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
});

store.definition = {
    methods: ['post'],
    url: '/task-types',
} satisfies RouteDefinition<['post']>;

/**
 * @see \App\Http\Controllers\TaskTypeController::store
 * @see app/Http/Controllers/TaskTypeController.php:24
 * @route '/task-types'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\TaskTypeController::store
 * @see app/Http/Controllers/TaskTypeController.php:24
 * @route '/task-types'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::store
 * @see app/Http/Controllers/TaskTypeController.php:24
 * @route '/task-types'
 */
const storeForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::store
 * @see app/Http/Controllers/TaskTypeController.php:24
 * @route '/task-types'
 */
storeForm.post = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
});

store.form = storeForm;

/**
 * @see \App\Http\Controllers\TaskTypeController::edit
 * @see app/Http/Controllers/TaskTypeController.php:38
 * @route '/task-types/{taskType}/edit'
 */
export const edit = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
});

edit.definition = {
    methods: ['get', 'head'],
    url: '/task-types/{taskType}/edit',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\TaskTypeController::edit
 * @see app/Http/Controllers/TaskTypeController.php:38
 * @route '/task-types/{taskType}/edit'
 */
edit.url = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { taskType: args };
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { taskType: args.id };
    }

    if (Array.isArray(args)) {
        args = {
            taskType: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        taskType:
            typeof args.taskType === 'object'
                ? args.taskType.id
                : args.taskType,
    };

    return (
        edit.definition.url
            .replace('{taskType}', parsedArgs.taskType.toString())
            .replace(/\/+$/, '') + queryParams(options)
    );
};

/**
 * @see \App\Http\Controllers\TaskTypeController::edit
 * @see app/Http/Controllers/TaskTypeController.php:38
 * @route '/task-types/{taskType}/edit'
 */
edit.get = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::edit
 * @see app/Http/Controllers/TaskTypeController.php:38
 * @route '/task-types/{taskType}/edit'
 */
edit.head = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::edit
 * @see app/Http/Controllers/TaskTypeController.php:38
 * @route '/task-types/{taskType}/edit'
 */
const editForm = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::edit
 * @see app/Http/Controllers/TaskTypeController.php:38
 * @route '/task-types/{taskType}/edit'
 */
editForm.get = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::edit
 * @see app/Http/Controllers/TaskTypeController.php:38
 * @route '/task-types/{taskType}/edit'
 */
editForm.head = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

edit.form = editForm;

/**
 * @see \App\Http\Controllers\TaskTypeController::update
 * @see app/Http/Controllers/TaskTypeController.php:58
 * @route '/task-types/{taskType}'
 */
export const update = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
});

update.definition = {
    methods: ['put'],
    url: '/task-types/{taskType}',
} satisfies RouteDefinition<['put']>;

/**
 * @see \App\Http\Controllers\TaskTypeController::update
 * @see app/Http/Controllers/TaskTypeController.php:58
 * @route '/task-types/{taskType}'
 */
update.url = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { taskType: args };
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { taskType: args.id };
    }

    if (Array.isArray(args)) {
        args = {
            taskType: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        taskType:
            typeof args.taskType === 'object'
                ? args.taskType.id
                : args.taskType,
    };

    return (
        update.definition.url
            .replace('{taskType}', parsedArgs.taskType.toString())
            .replace(/\/+$/, '') + queryParams(options)
    );
};

/**
 * @see \App\Http\Controllers\TaskTypeController::update
 * @see app/Http/Controllers/TaskTypeController.php:58
 * @route '/task-types/{taskType}'
 */
update.put = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::update
 * @see app/Http/Controllers/TaskTypeController.php:58
 * @route '/task-types/{taskType}'
 */
const updateForm = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\TaskTypeController::update
 * @see app/Http/Controllers/TaskTypeController.php:58
 * @route '/task-types/{taskType}'
 */
updateForm.put = (
    args:
        | { taskType: string | { id: string } }
        | [taskType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'post',
});

update.form = updateForm;

const taskTypes = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
};

export default taskTypes;
