<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Transform\Rector\String_\StringToClassConstantRector;
use RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector;
use RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector;
// use RectorLaravel\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use RectorLaravel\Rector\ClassMethod\AddArgumentDefaultValueRector;
use RectorLaravel\Rector\Coalesce\ApplyDefaultInsteadOfNullCoalesceRector;
use RectorLaravel\Rector\Expr\AppEnvironmentComparisonToParameterRector;
use RectorLaravel\Rector\Expr\SubStrToStartsWithOrEndsWithStaticMethodCallRector\SubStrToStartsWithOrEndsWithStaticMethodCallRector;
use RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use RectorLaravel\Rector\FuncCall\NowFuncWithStartOfDayMethodCallToTodayFuncRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
// use RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector;
// use RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector;
// use RectorLaravel\Rector\MethodCall\ResponseHelperCallToJsonResponseRector;
// use RectorLaravel\Rector\MethodCall\ReplaceServiceContainerCallArgRector;
use RectorLaravel\Rector\FuncCall\TypeHintTappableCallRector;
use RectorLaravel\Rector\If_\AbortIfRector;
use RectorLaravel\Rector\MethodCall\AvoidNegatedCollectionFilterOrRejectRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
// use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use RectorLaravel\Rector\MethodCall\JsonCallToExplicitJsonCallRector;
// use RectorLaravel\Rector\PropertyFetch\ReplaceFakerInstanceWithHelperRector;
// use RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector;
// use RectorLaravel\Rector\StaticCall\RequestStaticValidateToInjectRector;
// use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
use RectorLaravel\Rector\MethodCall\RedirectBackToBackHelperRector;
use RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector;
use RectorLaravel\Rector\MethodCall\ReverseConditionableMethodCallRector;
use RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector;
use RectorLaravel\Rector\MethodCall\WhereToWhereLikeRector;
use RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database',
        // __DIR__.'/public',
        __DIR__.'/resources',
        __DIR__.'/routes',
        // __DIR__.'/tests',
    ]);
    $rectorConfig->sets([
        // SetList::DEAD_CODE,
        // SetList::CODE_QUALITY,
        LevelSetList::UP_TO_PHP_82,
        LaravelLevelSetList::UP_TO_LARAVEL_120, // scope
        LaravelSetList::LARAVEL_CODE_QUALITY,
        // LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        // LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        // LaravelSetList::LARAVEL_COLLECTION,
        // LaravelSetList::LARAVEL_STATIC_TO_INJECTION, // factory()->make()
        // LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
        // LaravelSetList::LARAVEL_IF_HELPERS, // throw_if
        // LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        // LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        // LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
    ]);

    $rectorConfig->rule(EloquentOrderByToLatestOrOldestRector::class);
    $rectorConfig->rule(RedirectRouteToToRouteHelperRector::class);
    $rectorConfig->rule(AddArgumentDefaultValueRector::class);
    $rectorConfig->rule(ReverseConditionableMethodCallRector::class);
    $rectorConfig->rule(AvoidNegatedCollectionFilterOrRejectRector::class);
    // $rectorConfig->rule(EloquentWhereRelationTypeHintingParameterRector::class);
    // $rectorConfig->rule(EloquentWhereTypeHintClosureParameterRector::class);
    $rectorConfig->rule(JsonCallToExplicitJsonCallRector::class);
    $rectorConfig->rule(ValidationRuleArrayStringValueToArrayRector::class);
    $rectorConfig->rule(RedirectBackToBackHelperRector::class);
    // $rectorConfig->rule(ResponseHelperCallToJsonResponseRector::class);
    $rectorConfig->rule(WhereToWhereLikeRector::class);
    // $rectorConfig->rule(ArgumentFuncCallToMethodCallRector::class);
    $rectorConfig->rule(NowFuncWithStartOfDayMethodCallToTodayFuncRector::class);
    $rectorConfig->rule(TypeHintTappableCallRector::class);
    // $rectorConfig->rule(HelperFuncCallToFacadeClassRector::class);
    $rectorConfig->rule(RemoveDumpDataDeadCodeRector::class);
    // $rectorConfig->rule(DispatchToHelperFunctionsRector::class);
    // $rectorConfig->rule(RequestStaticValidateToInjectRector::class);
    // $rectorConfig->rule(RouteActionCallableRector::class);
    $rectorConfig->rule(OptionalToNullsafeOperatorRector::class);
    // $rectorConfig->rule(ReplaceFakerInstanceWithHelperRector::class);
    $rectorConfig->rule(SubStrToStartsWithOrEndsWithStaticMethodCallRector::class);
    $rectorConfig->rule(AppEnvironmentComparisonToParameterRector::class);
    $rectorConfig->rule(ApplyDefaultInsteadOfNullCoalesceRector::class);
    $rectorConfig->rule(AbortIfRector::class);
    $rectorConfig->rule(UnifyModelDatesWithCastsRector::class);
    $rectorConfig->rule(ModelCastsPropertyToCastsMethodRector::class);
    $rectorConfig->rule(EloquentMagicMethodToQueryBuilderRector::class);
    $rectorConfig->skip([
        StringToClassConstantRector::class,
        StringClassNameToClassConstantRector::class,
        RenameClassRector::class,
        ClosureToArrowFunctionRector::class,
        // ReplaceServiceContainerCallArgRector::class,
        // HelperFuncCallToFacadeClassRector::class,
        // EloquentMagicMethodToQueryBuilderRector::class,
    ]);
};
