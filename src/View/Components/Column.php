<?php

namespace Veldman\DataTable\View\Components;

use Illuminate\View\Component;

class Column extends Component
{
    public $href;
    public $key;
    public $columns;

    public function __construct($order = null, $columns = null)
    {
        $this->columns = $columns;

        $this->key = $order;

        if ($order !== null) {
            $inputs = request()->input();

            $inputs['order'] = $order;

            if (array_key_exists('direction', $inputs)) {
                $inputs['direction'] = ($inputs['direction'] == 'asc') ? 'desc' : 'asc';
            } else {
                $inputs['direction'] = 'asc';
            }

            $this->href = route(request()->route()->getName(), $inputs);
        }
    }

    public function render()
    {
        return view('data-table::components.column');
    }
}
