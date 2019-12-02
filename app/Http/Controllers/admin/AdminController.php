<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\HomeSlider;
use App\Package;
use App\Inquiry;


class AdminController extends Controller
{
    //
    public function index(){
        //dd('44444');
        //Auth::logout();
        //dd (Auth::check ());
        if(Auth::check ()){

            return redirect()->route('admin.dashboard');

        }else{

            //return redirect()->back();
            return view('admin.index');
        }
    }




    public function changePassword(){
        dd('changePassword');
        //return view('admin.index');
    }

    public function logout(){
        dd('logout');
        //return view('admin.index');
    }


    public function loadContactPage(){
        //dd('eee');
        return view('admin.contact');
    }

    public function loadDashboardPage(){

        $data = array(

            'homeSlider' => HomeSlider::count(),
            'package'    => Package::count(),
            'inquiry'    => Inquiry::count(),

        );
        return view('admin.dashboard')->with('data',$data);
    }

    public function loadPackagesPage(){
            return view('admin.packages');
    }

    

    public function loadDestinationsPage(){
        return view('admin.destinations');
    }

    public function loadHotelsPage(){
        return view('admin.hotels');
    }



}
