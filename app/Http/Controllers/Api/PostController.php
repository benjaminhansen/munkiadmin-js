<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Munki;
use Storage;
use Exception;

class PostController extends Controller
{
    public $munki;

    public function __construct() {
        $this->munki = new Munki;
    }

    public function new_catalog(Request $request)
    {
        $name = $request->name;
        $name = str_replace(" ", "-", $name);

        $catalogs = $this->munki->catalogs();

        if(in_array("catalogs/$name", $catalogs)) {
            return json_encode([
                'success' => false,
                'message' => 'The catalog ['.$request->name.'] already exists. Please choose a different name.'
            ]);
        } else {
            try {
                $this->munki->newCatalog($name);

                return json_encode([
                    'success' => true,
                    'message' => 'New catalog ['.$request->name.'] created successfully!'
                ]);
            } catch(Exception $e) {
                return json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }
}
