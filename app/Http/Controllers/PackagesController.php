<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PackagesController extends Controller
{
    public function index() {
        $title = "Packages";
        return view('packages.index', compact('title'));
    }
}
