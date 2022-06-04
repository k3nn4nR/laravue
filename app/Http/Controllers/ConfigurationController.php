<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Position;
use App\Models\DocumentType;
use App\Models\Brand;
use App\Models\Design;

class ConfigurationController extends Controller
{
    public function configuration()
    {
        $areas= Area::get();
        $positions= Position::get();
        $docuemnt_types= DocumentType::get();
        $brands= Brand::get();
        $designs= Design::get();
        return view('configuration',compact('areas','positions','docuemnt_types','brands','designs'));
    }
}
