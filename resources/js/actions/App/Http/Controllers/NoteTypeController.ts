import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
    applyUrlDefaults,
} from './../../../../wayfinder';
/**
 * @see \App\Http\Controllers\NoteTypeController::index
 * @see app/Http/Controllers/NoteTypeController.php:21
 * @route '/note-types'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

index.definition = {
    methods: ['get', 'head'],
    url: '/note-types',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\NoteTypeController::index
 * @see app/Http/Controllers/NoteTypeController.php:21
 * @route '/note-types'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\NoteTypeController::index
 * @see app/Http/Controllers/NoteTypeController.php:21
 * @route '/note-types'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\NoteTypeController::index
 * @see app/Http/Controllers/NoteTypeController.php:21
 * @route '/note-types'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\NoteTypeController::index
 * @see app/Http/Controllers/NoteTypeController.php:21
 * @route '/note-types'
 */
const indexForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\NoteTypeController::index
 * @see app/Http/Controllers/NoteTypeController.php:21
 * @route '/note-types'
 */
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\NoteTypeController::index
 * @see app/Http/Controllers/NoteTypeController.php:21
 * @route '/note-types'
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
 * @see \App\Http\Controllers\NoteTypeController::store
 * @see app/Http/Controllers/NoteTypeController.php:52
 * @route '/note-types'
 */
export const store = (
    options?: RouteQueryOptions,
): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
});

store.definition = {
    methods: ['post'],
    url: '/note-types',
} satisfies RouteDefinition<['post']>;

/**
 * @see \App\Http\Controllers\NoteTypeController::store
 * @see app/Http/Controllers/NoteTypeController.php:52
 * @route '/note-types'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\NoteTypeController::store
 * @see app/Http/Controllers/NoteTypeController.php:52
 * @route '/note-types'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\NoteTypeController::store
 * @see app/Http/Controllers/NoteTypeController.php:52
 * @route '/note-types'
 */
const storeForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\NoteTypeController::store
 * @see app/Http/Controllers/NoteTypeController.php:52
 * @route '/note-types'
 */
storeForm.post = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
});

store.form = storeForm;

/**
 * @see \App\Http\Controllers\NoteTypeController::update
 * @see app/Http/Controllers/NoteTypeController.php:79
 * @route '/note-types/{noteType}'
 */
export const update = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
});

update.definition = {
    methods: ['put'],
    url: '/note-types/{noteType}',
} satisfies RouteDefinition<['put']>;

/**
 * @see \App\Http\Controllers\NoteTypeController::update
 * @see app/Http/Controllers/NoteTypeController.php:79
 * @route '/note-types/{noteType}'
 */
update.url = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { noteType: args };
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { noteType: args.id };
    }

    if (Array.isArray(args)) {
        args = {
            noteType: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        noteType:
            typeof args.noteType === 'object'
                ? args.noteType.id
                : args.noteType,
    };

    return (
        update.definition.url
            .replace('{noteType}', parsedArgs.noteType.toString())
            .replace(/\/+$/, '') + queryParams(options)
    );
};

/**
 * @see \App\Http\Controllers\NoteTypeController::update
 * @see app/Http/Controllers/NoteTypeController.php:79
 * @route '/note-types/{noteType}'
 */
update.put = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
});

/**
 * @see \App\Http\Controllers\NoteTypeController::update
 * @see app/Http/Controllers/NoteTypeController.php:79
 * @route '/note-types/{noteType}'
 */
const updateForm = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
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
 * @see \App\Http\Controllers\NoteTypeController::update
 * @see app/Http/Controllers/NoteTypeController.php:79
 * @route '/note-types/{noteType}'
 */
updateForm.put = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
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

/**
 * @see \App\Http\Controllers\NoteTypeController::destroy
 * @see app/Http/Controllers/NoteTypeController.php:114
 * @route '/note-types/{noteType}'
 */
export const destroy = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
});

destroy.definition = {
    methods: ['delete'],
    url: '/note-types/{noteType}',
} satisfies RouteDefinition<['delete']>;

/**
 * @see \App\Http\Controllers\NoteTypeController::destroy
 * @see app/Http/Controllers/NoteTypeController.php:114
 * @route '/note-types/{noteType}'
 */
destroy.url = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { noteType: args };
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { noteType: args.id };
    }

    if (Array.isArray(args)) {
        args = {
            noteType: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        noteType:
            typeof args.noteType === 'object'
                ? args.noteType.id
                : args.noteType,
    };

    return (
        destroy.definition.url
            .replace('{noteType}', parsedArgs.noteType.toString())
            .replace(/\/+$/, '') + queryParams(options)
    );
};

/**
 * @see \App\Http\Controllers\NoteTypeController::destroy
 * @see app/Http/Controllers/NoteTypeController.php:114
 * @route '/note-types/{noteType}'
 */
destroy.delete = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
});

/**
 * @see \App\Http\Controllers\NoteTypeController::destroy
 * @see app/Http/Controllers/NoteTypeController.php:114
 * @route '/note-types/{noteType}'
 */
const destroyForm = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\NoteTypeController::destroy
 * @see app/Http/Controllers/NoteTypeController.php:114
 * @route '/note-types/{noteType}'
 */
destroyForm.delete = (
    args:
        | { noteType: string | { id: string } }
        | [noteType: string | { id: string }]
        | string
        | { id: string },
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'post',
});

destroy.form = destroyForm;

const NoteTypeController = { index, store, update, destroy };

export default NoteTypeController;
