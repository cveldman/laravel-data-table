<?php

namespace Veldman\DataTable;

use Illuminate\View\View;

class Column
{
    private string $name;
    private string $key;

    private bool $order;
    private bool $search;

    public function __construct($name)
    {
    }

    public function order()
    {
        return $this;
    }

    public function search()
    {
        return $this;
    }

    public function render()
    {

    }
}