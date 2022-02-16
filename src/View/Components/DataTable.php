<?php

namespace Veldman\DataTable\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    public $datatable;

    public $columns;

    public function __construct($datatable, $columns = [])
    {
        $this->datatable = $datatable;

        $this->columns = $columns;
    }

    public function render()
    {
        return view('data-table::components.data-table');
    }
}
