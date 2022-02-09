<?php

namespace Veldman\DataTable\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    public $columns;

    public function __construct($columns = [])
    {
        $this->columns = $columns;
    }

    public function render()
    {
        return view('data-table::components.data-table');
    }
}
