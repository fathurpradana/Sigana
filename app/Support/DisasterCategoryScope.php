<?php

namespace App\Support;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

final class DisasterCategoryScope
{
    /** Keep the web experience focused on floods and earthquakes. */
    public static function apply(Builder $query, string $column = 'name'): Builder
    {
        return $query->where(function (Builder $scope) use ($column) {
            $scope->whereRaw("LOWER({$column}) = ?", ['banjir'])
                ->orWhereRaw("LOWER({$column}) LIKE ?", ['gempa%']);
        });
    }

    public static function query(): Builder
    {
        return self::apply(DB::table('disaster_categories'));
    }
}
