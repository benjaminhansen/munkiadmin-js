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

    public function newCatalog($catalog_name)
    {
        $catalog_path = $this->catalogsPath() . "/" . $catalog_name;
        $contents = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE plist PUBLIC \"-//Apple//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">\n<plist version=\"1.0\">\n<array>\n</array>\n</plist>";
        Storage::put($catalog_path, $contents);
    }

    public function __call($method, $args)
    {
        try {
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
        } catch(Exception $e) {
            die(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
        }
    }
}
