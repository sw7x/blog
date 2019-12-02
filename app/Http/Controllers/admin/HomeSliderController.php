<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HomeSlider;
use Illuminate\Support\Facades\File;


class HomeSliderController extends Controller
{
    public function loadHomeSliderPage(){
        return view('admin.home-slider');
    }


	public function loadHomeSliderTbl(){

        $jTableResult = array();
        try
        {
            //var_dump ($request->action);
            //var_dump ($request->jtStartIndex);
            //var_dump ($request->jtPageSize);
            //var_dump ($request->jtSorting);

            $jTableResult['______StartIndex______'] = $StartIndex= $_REQUEST['jtStartIndex'];
            $jTableResult['______PageSize______'] = $PageSize = $_REQUEST['jtPageSize'];
            $jTableResult['______jtSorting______'] = $Sorting = $_REQUEST['jtSorting'];

            //First you have to enable query log it can be done using
            //DB::connection()->enableQueryLog();

            $Sorting = array('column' => 'id', 'order' => 'asc');

            if ($Sorting == 'undefined')
            {
                $homeSliderRecords = HomeSlider::limit ($PageSize)->offset ($StartIndex)->get ();
            }
            else
            {
                $homeSliderRecords = HomeSlider::orderBy ($Sorting['column'], $Sorting['order'])->limit($PageSize)->offset($StartIndex)->get();
            }

            $homeSliderRecordCount = HomeSlider::count();

            //Add all records to an array
            $resultArr = array();
            foreach ($homeSliderRecords as $result)
            {
                $resultArr[] = $result;
            }

            //Return result to jTable
            $jTableResult['Result'] = "OK";
            $jTableResult['Records'] = $resultArr;
            $jTableResult["TotalRecordCount"] = $homeSliderRecordCount;
            //var_dump($jTableResult);
        }catch(Exception $ex){
            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();
        }
        print json_encode($jTableResult);
    }

    public function deleteHomeSliderById(Request $request){
        $jTableResult = array();

        $recId = $request->id;

        try{
            $row  = HomeSlider::where('id', $recId)->first();
            $slideImage = $row->image;

            if($slideImage != ''){
                $folderPath = public_path('/storage/'.$slideImage);

                //dd($folderPath);
                $response = File::delete($folderPath);
            }

            //Delete from database
            HomeSlider::destroy($recId);

            //Return result to jTable
            $jTableResult['Result'] = "OK";
            print json_encode ($jTableResult);

        }catch(Exception $ex){
            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();
        }
    }

    public function createHomeSlider(Request $request){

        $jTableResult = array();
        $imgStat = ($request->image_status=="enable")?true:false;       

        try{
               
            // Handle File Upload
            if($request->hasFile('homesliderImg')){

                // Get filename with the extension
                $filenameWithExt = $request->file('homesliderImg')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('homesliderImg')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;


	            //check package already exsist
	            $homeSliderRecords  = HomeSlider::where('image', $fileNameToStore)->get();
	            $homeSliderRecordCount = $homeSliderRecords->count();
	            if($homeSliderRecordCount){throw new \Exception('slider image already exsists');}


                //upload folder
                $folderName      = 'home-slider';

                $fileCheckPath = public_path().'/storage/'.$folderName.'/'. $fileNameToStore;
                if (file_exists($fileCheckPath)){
                    //throw new exception($fileCheckPath . " already exists");
                    throw new exception("file already exists");
                }

                // Upload Image
                $path = $request->file('homesliderImg')->storeAs('public/'.$folderName, $fileNameToStore);
                //$fileStorePath   = '/storage/package_images/'.$folderName.'/'.$fileNameToStore;

                $fileStorePath   = $folderName.'/'.$fileNameToStore;                

            } else {
                throw new \Exception('slider image need to upload');               
            }

            //package insert into database
            $homeSlider = new HomeSlider();
            $homeSlider->image        = $fileStorePath;//$request->image;
            $homeSlider->enable       = $imgStat;//$request->image;            
            $homeSlider->save();

            $lastRrowid = $homeSlider->id;
            $lastRrow   = HomeSlider::where('id', $lastRrowid)->first();

            //Return result to jTable
            $jTableResult['Result'] = "OK";
            $jTableResult['Record'] = $lastRrow;
            
        }catch(\Exception $ex){
            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();
        }
        print json_encode ($jTableResult);
    }


    public function updateHomeSlider(Request $request){

        $jTableResult = array();
              
        try{                      

            //check if image uploaded
            $row     = HomeSlider::where('id', $request->id)->first();
            $img     = $row->image;
            $imgStat = $row->enable;

            
            // Handle File Upload
            if($request->hasFile('homesliderImg_update')){

                $time = time();
                
                // Get filename with the extension
                $filenameWithExt = $request->file('homesliderImg_update')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('homesliderImg_update')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'_'.$time.'.'.$extension;
                //upload folder
                $folderName      = 'home-slider';

                $fileCheckPath = public_path().'/storage/'.$folderName.'/'. $fileNameToStore;                

                if (file_exists($fileCheckPath)){
                    //throw new exception($fileCheckPath . " already exists");
                    throw new \Exception("file already exists");
                }

                // Upload Image                
                $path = $request->file('homesliderImg_update')->storeAs('public/'.$folderName.'/', $fileNameToStore);
                $fileStorePath = $folderName.'/'.$fileNameToStore;


                //delete old file
                if (file_exists(public_path().'/storage/'.$img)){
                    $response = File::delete(public_path().'/storage/'.$img);
                }         


            }else {

            	$fileStorePath = $img;
            }

            $imgStat = ($request->image_status=="enable")?true:false;

            //homeSlider insert into database
            $homeSlider = HomeSlider::find($request->id);
            $homeSlider->image        = $fileStorePath;//$request->image;
            $homeSlider->enable       = $imgStat;//$request->image;            
            $homeSlider->save();

            $lastRowId = $homeSlider->id;
            $lastRow  = HomeSlider::where('id', $lastRowId)->first();

            //Return result to jTable
            $jTableResult['Result'] = "OK";
            $jTableResult['Record'] = $lastRow;
            
        }catch(\Exception $ex){
            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();

        }
        print json_encode ($jTableResult);
    }


}
