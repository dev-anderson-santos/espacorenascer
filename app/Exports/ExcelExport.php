<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExcelExport implements FromView
{
     /**
     * @var string
     */
    protected $view;
    protected $data;

    public function __construct(string $view, $data = null)
    {   
        $this->view = $view;
        $this->data = $data;
    }

    /**
     * @return View
     */
    public function view() : View
    {
        return view($this->view, $this->data);
    }
}
