import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
} from './../../../../../wayfinder';
/**
 * @see \App\Http\Controllers\Api\RolePermissionApiController::index
 * @see app/Http/Controllers/Api/RolePermissionApiController.php:12
 * @route '/api/role-permissions'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

index.definition = {
    methods: ['get', 'head'],
    url: '/api/role-permissions',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\Api\RolePermissionApiController::index
 * @see app/Http/Controllers/Api/RolePermissionApiController.php:12
 * @route '/api/role-permissions'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\Api\RolePermissionApiController::index
 * @see app/Http/Controllers/Api/RolePermissionApiController.php:12
 * @route '/api/role-permissions'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\Api\RolePermissionApiController::index
 * @see app/Http/Controllers/Api/RolePermissionApiController.php:12
 * @route '/api/role-permissions'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\Api\RolePermissionApiController::index
 * @see app/Http/Controllers/Api/RolePermissionApiController.php:12
 * @route '/api/role-permissions'
 */
const indexForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\Api\RolePermissionApiController::index
 * @see app/Http/Controllers/Api/RolePermissionApiController.php:12
 * @route '/api/role-permissions'
 */
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\Api\RolePermissionApiController::index
 * @see app/Http/Controllers/Api/RolePermissionApiController.php:12
 * @route '/api/role-permissions'
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

const RolePermissionApiController = { index };

export default RolePermissionApiController;
