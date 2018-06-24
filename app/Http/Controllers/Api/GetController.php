<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Munki;
use CFPropertyList;
use Storage;

class GetController extends Controller
{
    public $munki;

    public function __construct() {
        $this->munki = new Munki;
    }

    public function manifests($content = null) {
        $manifests = $this->munki->manifests();
        if(!is_null($content)) {
            $data = [];
            foreach($manifests as $manifest) {
                $content = Storage::get($manifest);
                $data[] = [
                    "file" => $manifest,
                    "content" => $content
                ];
            }
            return $data;
        } else {
            return $manifests;
        }
    }

    public function catalogs($content = null) {
        $catalogs = $this->munki->catalogs();
        if(!is_null($content)) {
            $data = [];
            foreach($catalogs as $catalog) {
                $content = Storage::get($catalog);
                $data[] = [
                    "file" => $catalog,
                    "content" => $content
                ];
            }
            return $data;
        } else {
            return $catalogs;
        }
    }

    public function icons() {
        return $this->munki->icons();
    }

    public function packages() {
        return $this->munki->packages();
    }

    public function packagesInfo($content = null) {
        $infos = $this->munki->packagesInfo();
        if(!is_null($content)) {
            $data = [];
            foreach($infos as $info) {
                $content = Storage::get($info);
                $data[] = [
                    "file" => $info,
                    "content" => $content
                ];
            }
            return $data;
        } else {
            return $infos;
        }
    }

    public function categories($query = null) {
        if(is_null($query)) {
            $categories = [];
            $package_plists = $this->packagesInfo(true);
            foreach($package_plists as $plist) {
                $contents = $plist['content'];

                $obj = new CFPropertyList;
                $obj->parse($contents);

                $category = $obj->getValue(true)->category;
                $categories[] = "All";
                if(is_null($category)) {
                    $categories[] = "Uncategorized";
                } else {
                    $categories[] = $category->getValue(true);
                }
            }
            $categories = array_unique($categories);
            return array_values($categories);
        } else {
            $packages = [];

            $package_plists = $this->packagesInfo(true);
            foreach($package_plists as $plist) {
                $contents = $plist['content'];

                $obj = new CFPropertyList;
                $obj->parse($contents);

                $category = $obj->getValue(true)->category;

                if(is_null($category)) {
                    if($query == "Unknown") {
                        $packages[] = $plist;
                    }
                } else {
                    if($query == $category->getValue(true)) {
                        $packages[] = $plist;
                    }
                }
            }

            return $packages;
        }
    }

    public function developers($query = null) {
        if(is_null($query)) {
            $developers = [];
            $package_plists = $this->packagesInfo(true);
            foreach($package_plists as $plist) {
                $contents = $plist['content'];

                $obj = new CFPropertyList;
                $obj->parse($contents);

                $developer = $obj->getValue(true)->developer;
                $developers[] = "All";
                if(is_null($developer)) {
                    $developers[] = "Unknown";
                } else {
                    $developers[] = $developer->getValue(true);
                }
            }
            $developers = array_unique($developers);
            return array_values($developers);
        } else {
            $packages = [];

            $package_plists = $this->packagesInfo(true);
            foreach($package_plists as $plist) {
                $contents = $plist['content'];

                $obj = new CFPropertyList;
                $obj->parse($contents);

                $developer = $obj->getValue(true)->developer;

                if(is_null($developer)) {
                    if($query == "Unknown") {
                        $packages[] = $plist;
                    }
                } else {
                    if($query == $developer->getValue(true)) {
                        $packages[] = $plist;
                    }
                }
            }

            return $packages;
        }
    }
}
