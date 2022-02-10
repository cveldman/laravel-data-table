<?php

namespace Veldman\DataTable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
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


        \Illuminate\Database\Eloquent\Builder::macro('order', function (array $columns) {
            $order = request()->get('order', null);

            if ($order == null) {
                return $this;
            }

            $direction = request()->get('direction', null);

            if ($direction == null) {
                return $this;
            }

            // TODO: Check if asc or desc

            foreach ($columns as $column) {
                if (is_array($column)) {
                    if ($column[0] != $order) {
                        continue;
                    }

                    $q = $column[0]::select($column[1])->whereColumn($column[2], $column[3]);

                    $this->query->orderBy($q, $direction);
                } else {
                    if ($column != $order) {
                        continue;
                    }

                    $this->query->orderBy($column, $direction);
                }
            }

            return $this;


            /* if($value != null) {
                $direction = 'asc';

                foreach ($columns as $column) {
                    $this->query->when(
                        is_array($column),

                        // Relational order
                        function (Builder $query) use ($column, $direction) {
                            $q = $column[0]::select($column[1])->whereColumn($column[2], $column[3]);

                            return $query->orderBy($q, $direction);
                        },

                        // Default order
                        function (Builder $query) use ($column, $direction) {
                            return $query->orderBy($column, $direction);
                        }
                    );
                }
            }

            $table = 'customer';
            $column = 'name';

            $model = "App\Models\Customer";

            dd($model::select());


            $query = Customer::select('name')->whereColumn('projects.customer_id', 'customers.id');

            dd($query);

            $this->query->orderBy($query, 'desc'); */
            // $this->query

            // $this->query->orderBy('name', 'asc');

            // $this->query->orderBy('name', 'asc');

            return $this;
        });




        \Illuminate\Database\Query\Builder::macro('order', function (array $columns) {
            $order = request()->get('order', null);

            if ($order == null) {
                return $this;
            }

            $direction = request()->get('direction', null);

            if ($direction == null) {
                return $this;
            }

            // TODO: Check if asc or desc

            foreach ($columns as $column) {
                if (is_array($column)) {
                    if ($column[0] != $order) {
                        continue;
                    }

                    $q = $column[0]::select($column[1])->whereColumn($column[2], $column[3]);

                    $this->query->orderBy($q, $direction);
                } else {
                    if ($column != $order) {
                        continue;
                    }

                    $this->query->orderBy($column, $direction);
                }
            }

            return $this;
        });










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