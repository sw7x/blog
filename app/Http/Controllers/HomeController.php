<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HomeSlider;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {       

        //get slider images
        $sliderImageRows     = HomeSlider::where('enable', true)->get();
        //dd($sliderImageRows);
        return view('index')->with('sliderImages',$sliderImageRows);
    }
}
