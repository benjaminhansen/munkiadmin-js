<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogsController extends Controller
{
    public function index() {
        $title = "Catalogs";
        return view('catalogs.index', compact('title'));
    }
}
