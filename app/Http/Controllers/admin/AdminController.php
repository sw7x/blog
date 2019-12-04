<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\HomeSlider;
use App\Package;
use App\Inquiry;
use App\User;

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




    public function changePassword(Request $request){

        // var_dump($request->pwOld);
        // var_dump($request->pwNew);
        // var_dump($request->userId);
        $response = array();
        $response['status'] = '';
        
        try{

            $user = User::find($request->userId);
            $hasher = app('hash');
            
            if ($hasher->check($request->pwOld, $user->password)) {
                // Success
                
                $user->password = Hash::make($request->pwNew);;
                $isUpdate = $user->save();

                if(!$isUpdate){
                    throw new \Exception('password update failed');
                }else{
                     $response['status'] = 'Successfully';
                }


            }else{
                throw new \Exception('old password not in database');
            }        

        }catch (\Exception $e) {
            //$response['status']=='failed';
            $response['status'] = $e->getMessage();
        }

        print json_encode($response);
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
