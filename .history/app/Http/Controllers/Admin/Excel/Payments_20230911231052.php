<?php

namespace App\Http\Controllers\Admin\Excel;

use App\Models\Letter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class Payments implements FromView
{

    public $items;

    public function __construct( $items)
    {
        $this->items = $items;
      
    }
    public function view(): View
    {
        $items = $this->items;
        return view('excel.payments.main', compact('items'));
    }
}
