<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metatag;
use App\Models\Catalog;
use Illuminate\Support\Facades\DB;

class HeadController extends Controller
{
    public function head(){

        return view('main', ["Title"=>"Aster Bt"]);
    }

    public function getMainData(Request $request){
        
        return view('welcome', []);

    }
}
