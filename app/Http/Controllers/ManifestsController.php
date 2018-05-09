<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManifestsController extends Controller
{
    public function index() {
        $title = "Manifests";
        return view('manifests.index', compact('title'));
    }
}
