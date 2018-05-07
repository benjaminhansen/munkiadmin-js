<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Munki;

class GetController extends Controller
{
    public $munki;

    public function __construct() {
        $this->munki = new Munki;
    }

    public function manifests() {
        return $this->munki->manifests();
    }

    public function catalogs() {
        return $this->munki->catalogs();
    }

    public function icons() {
        return $this->munki->icons();
    }

    public function packages() {
        return $this->munki->packages();
    }

    public function packagesInfo() {
        return $this->munki->packagesInfo();
    }

    public function categories() {

    }

    public function developers() {
        
    }
}
