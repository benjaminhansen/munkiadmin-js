<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Response;

class FilesController extends Controller
{
    public function get_file($filename)
    {
        $file = Storage::get($filename);
        $mime = Storage::mimeType($filename);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $mime);

        return $response;
    }
}
