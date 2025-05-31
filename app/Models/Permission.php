<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    /** @use HasFactory<\Database\Factories\PermissionFactory> */
    use HasFactory;

    protected $fillable = ['name', 'guard_name'];

    /**
     * Scope a query to include only the necessary columns to generate a HTML select list.
     */
    #[Scope]
    protected function options(Builder $query): Builder
    {
        return $query->select('id', 'name');
    }
}
