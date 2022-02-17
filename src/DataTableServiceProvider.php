<?php

namespace Veldman\DataTable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Veldman\DataTable\View\Components\Column;
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
        Blade::component('dcolumn', Column::class);

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
                if (Str::contains($column, '.')) {
                    if ($column != $order) {
                        continue;
                    }

                    $parts = explode('.', $column);
                    $relationColumn = array_pop($parts);
                    $relationName = join('.', $parts);

                    $inputs = [
                        get_class($this->model->$relationName()->getRelated()),
                        $relationColumn,
                        $this->model->$relationName()->getQualifiedForeignKeyName(),
                        $this->model->$relationName()->getQualifiedOwnerKeyName()
                    ];

                    // dd($inputs, ['App\Models\Customer', 'name', 'projects.customer_id', 'customers.id']);

                    $q = $inputs[0]::select($inputs[1])->whereColumn($inputs[2], $inputs[3]);

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

        \Illuminate\Database\Eloquent\Builder::macro('datatable', function (array $columns) {

            $this->order($columns);

            $this->search($columns);

            if(request()->has('perPage')) {
                session(['perPage' => request()->query('perPage')]);
            }

            return $this->paginate(session()->query('perPage', 15));
        });
    }
}