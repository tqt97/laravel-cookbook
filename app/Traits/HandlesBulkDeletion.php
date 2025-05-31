<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait HandlesBulkDeletion
{
    /**
     * Handles the bulk deletion of model records based on the provided request.
     */
    public function performBulkDeletion(
        Request $request,
        string $modelClass,
        ?string $successMessageKey = null,
        ?string $failMessageKey = null,
        ?string $emptyMessageKey = null
    ): RedirectResponse {
        try {
            $ids = (array) $request->input('ids', []);

            if (empty($ids)) {
                $key = $emptyMessageKey ?? $this->resolveMessageKey($modelClass, 'bulk_delete_empty');

                return back()->with('warning', __($key));
            }

            DB::transaction(function () use ($modelClass, $ids) {
                $modelClass::query()->whereIn('id', $ids)->delete();
            });

            $key = $successMessageKey ?? $this->resolveMessageKey($modelClass, 'bulk_delete_success');

            return back()->with('success', __($key));
        } catch (\Throwable $th) {
            Log::error($th);
            $key = $failMessageKey ?? $this->resolveMessageKey($modelClass, 'bulk_delete_fail');

            return back()->with('error', __($key));
        }
    }

    /**
     * Resolves the translation message key for a given model class and suffix.
     *
     * @param  string  $modelClass  The fully qualified class name of the model.
     * @param  string  $suffix  The message suffix to append.
     * @return string The resolved translation message key in the format 'model.messages.suffix'.
     */
    protected function resolveMessageKey(string $modelClass, string $suffix): string
    {
        $basename = class_basename($modelClass);
        $key = strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $basename));

        return "{$key}.messages.{$suffix}";
    }
}
