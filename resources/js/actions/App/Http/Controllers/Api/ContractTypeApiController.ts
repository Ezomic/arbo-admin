import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
} from './../../../../../wayfinder';
/**
 * @see \App\Http\Controllers\Api\ContractTypeApiController::index
 * @see app/Http/Controllers/Api/ContractTypeApiController.php:12
 * @route '/api/contract-types'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

index.definition = {
    methods: ['get', 'head'],
    url: '/api/contract-types',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\Api\ContractTypeApiController::index
 * @see app/Http/Controllers/Api/ContractTypeApiController.php:12
 * @route '/api/contract-types'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\Api\ContractTypeApiController::index
 * @see app/Http/Controllers/Api/ContractTypeApiController.php:12
 * @route '/api/contract-types'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\Api\ContractTypeApiController::index
 * @see app/Http/Controllers/Api/ContractTypeApiController.php:12
 * @route '/api/contract-types'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\Api\ContractTypeApiController::index
 * @see app/Http/Controllers/Api/ContractTypeApiController.php:12
 * @route '/api/contract-types'
 */
const indexForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\Api\ContractTypeApiController::index
 * @see app/Http/Controllers/Api/ContractTypeApiController.php:12
 * @route '/api/contract-types'
 */
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\Api\ContractTypeApiController::index
 * @see app/Http/Controllers/Api/ContractTypeApiController.php:12
 * @route '/api/contract-types'
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

const ContractTypeApiController = { index };

export default ContractTypeApiController;
