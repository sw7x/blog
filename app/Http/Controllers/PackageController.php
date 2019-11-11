<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;




class PackageController extends Controller
{
    public function index(){

    	$package = new Package();
        $package->aaa();

        //$result = $package::get();
        $result = $package::orderBy('id','desc')->paginate(1);
        //dd($cRecord);

    	return view('packages')->with('records', $result);

	}



	public function singlePackage($pakageId){
		//dd($pakageId.'packages.single');
        $package = new Package();
        $result = $package::where('id', $pakageId)->first();

        return view('packdisplay')->with('record', $result);
	}


}
