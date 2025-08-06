<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatrixController extends Controller
{
    //
    public function index()
    {

    }

    public function create()
    {
        return inertia('PerformanceMatrix/Create');
    }

    public function store()
    {

    }
}
