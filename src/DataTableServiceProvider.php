<?php

namespace Veldman\DataTable;

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
    }
}