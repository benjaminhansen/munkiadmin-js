<?php

namespace App\Support;

use Storage;
use Exception;

class Munki
{
    public $methods = ['catalogs', 'icons', 'manifests', 'packages', 'packagesInfo'];

    public function catalogsPath()
    {
        return "/catalogs";
    }

    public function iconsPath()
    {
        return "/icons";
    }

    public function manifestsPath()
    {
        return "/manifests";
    }

    public function packagesPath()
    {
        return "/pkgs";
    }

    public function packagesInfoPath()
    {
        return "/pkgsinfo";
    }

    public function __call($method, $args)
    {
        if(in_array($method, $this->methods)) {
            $method_name = "{$method}Path";
            $files = Storage::allFiles($this->{$method_name}());
            $files = array_filter($files, function($v){
                return !(starts_with(basename($v), "."));
            });
            return array_values($files);
        } else {
            throw new Exception("Invalid method [$method]!");
        }
    }
}
