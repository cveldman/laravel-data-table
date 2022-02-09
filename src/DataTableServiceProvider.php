<?php

namespace Veldman\DataTable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Veldman\DataTable\View\Components\DataTable;

class DataTableServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'data-table');

        Blade::component('data-table', DataTable::class);

        \Illuminate\Database\Eloquent\Builder::macro('search', function (array $columns) {
            $value = request()->get('search', null);

            if($value != null) {
                $this->where(function (Builder $query) use ($columns, $value) {
                    foreach (Arr::wrap($columns) as $column) {
                        $query->when(
                            Str::contains($column, '.'),

                            // Relational searches
                            function (Builder $query) use ($column, $value) {
                                $parts = explode('.', $column);
                                $relationColumn = array_pop($parts);
                                $relationName = join('.', $parts);

                                return $query->orWhereHas(
                                    $relationName,
                                    function (Builder $query) use ($relationColumn, $value) {
                                        $query->where($relationColumn, 'LIKE', "%{$value}%");
                                    }
                                );
                            },

                            // Default searches
                            function (Builder $query) use ($column, $value) {
                                return $query->orWhere($column, 'LIKE', "%{$value}%");
                            }
                        );
                    }
                });
            }

            return $this;
        });

        \Illuminate\Database\Query\Builder::macro('search', function (array $columns) {
            $value = request()->get('search', null);

            if($value != null) {
                $this->where(function (Builder $query) use ($columns, $value) {
                    foreach (Arr::wrap($columns) as $column) {
                        $query->when(
                            Str::contains($column, '.'),

                            // Relational searches
                            function (Builder $query) use ($column, $value) {
                                $parts = explode('.', $column);
                                $relationColumn = array_pop($parts);
                                $relationName = join('.', $parts);

                                return $query->orWhereHas(
                                    $relationName,
                                    function (Builder $query) use ($relationColumn, $value) {
                                        $query->where($relationColumn, 'LIKE', "%{$value}%");
                                    }
                                );
                            },

                            // Default searches
                            function (Builder $query) use ($column, $value) {
                                return $query->orWhere($column, 'LIKE', "%{$value}%");
                            }
                        );
                    }
                });
            }

            return $this;
        });
    }
}