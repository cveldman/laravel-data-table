<?php

namespace Veldman\DataTable\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    public $columns;
    public $paginator;

    public function __construct($paginator, $columns = [])
    {
        $this->columns = $columns;
        $this->paginator = $paginator;
    }

    public function render()
    {
        return view('data-table::components.data-table');
    }
}
