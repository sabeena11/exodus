<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontController extends FrontBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {   
        return view('front.index', $this->data);
    }
}
