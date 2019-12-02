<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class PackagesController extends Controller
{
    //
    public function loadPackagesTbl(){

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
                $packageRecords = Package::limit ($PageSize)->offset ($StartIndex)->get ();
            }
            else
            {
                $packageRecords = Package::orderBy ($Sorting['column'], $Sorting['order'])->limit ($PageSize)->offset ($StartIndex)->get ();
            }

            $packageRecCount = Package::count();

            //Add all records to an array
            $resultArr = array();
            foreach ($packageRecords as $result)
            {
                $resultArr[] = $result;
            }

            //Return result to jTable
            $jTableResult['Result'] = "OK";
            $jTableResult['Records'] = $resultArr;
            $jTableResult["TotalRecordCount"] = $packageRecCount;
            //var_dump($jTableResult);
        }catch(Exception $ex){
            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();
        }
        print json_encode($jTableResult);
    }

    public function deletePackageById(Request $request){
        $jTableResult = array();
        $recId = $request->id;

        try{
            $row  = Package::where('id', $recId)->first();
            $packageFolder = $row->folder;

            if($packageFolder != ''){
                $folderPath = public_path('/storage/package_images/'.$packageFolder);
                $response = File::deleteDirectory($folderPath);
            }

            //Delete from database
            Package::destroy($recId);

            //Return result to jTable
            $jTableResult['Result'] = "OK";
            print json_encode ($jTableResult);

        }catch(Exception $ex){
            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();
        }
    }

    public function createPackage(Request $request){

        $jTableResult = array();

        try{

            $validator = Validator::make($request->all(),[
                'title'             =>'required',
                'descriptionText'   =>'required',
                'duration'          =>'required',
                'price'             =>'required'
            ]);

            if ($validator->fails()) {
                // return back()->withErrors($validator)->withInput();
                $messages = $validator->messages();
                $errorMsg  =($messages->first('title') == '')?'':$messages->first('title').'<br>';
                $errorMsg .=($messages->first('descriptionText') == '')?'':$messages->first('descriptionText').'<br>';
                $errorMsg .=($messages->first('duration') == '')?'':$messages->first('duration').'<br>';
                $errorMsg .=($messages->first('price') == '')?'':$messages->first('price').'<br>';

                //dd($errorMsg);
                if($errorMsg){
                    throw new \Exception('validate failed');
                }

            }else{

                //check package already exsist
                $packageRecords  = Package::where('title', $request->title)->get();
                $packageRecCount = $packageRecords->count();
                if($packageRecCount){throw new \Exception('Package name already exsists');}

                // Handle File Upload
                if($request->hasFile('packageImg')){
                    // Get filename with the extension
                    $filenameWithExt = $request->file('packageImg')->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $request->file('packageImg')->getClientOriginalExtension();
                    // Filename to store
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    //upload folder
                    $folderName      = 'package_'.time();

                    $fileCheckPath = public_path().'/storage/package_images/'.$folderName.'/'. $fileNameToStore;
                    if (file_exists($fileCheckPath)){
                        //throw new exception($fileCheckPath . " already exists");
                        throw new exception("file already exists");
                    }

                    // Upload Image
                    $path = $request->file('packageImg')->storeAs('public/package_images/'.$folderName, $fileNameToStore);
                    //$fileStorePath   = '/storage/package_images/'.$folderName.'/'.$fileNameToStore;

                    $fileStorePath   = $folderName.'/'.$fileNameToStore;
                    $fileStoreFolder = $folderName;

                } else {
                    $fileStorePath   ='noimage.png';
                    $fileStoreFolder = '';
                }

                //package insert into database
                $package = new Package();
                $package->title        = $request->title;
                $package->price        = $request->price;
                $package->description  = $request->descriptionText;
                $package->image        = $fileStorePath;//$request->image;
                $package->folder       = $fileStoreFolder;//$request->image;
                $package->duration     = $request->duration;
                $package->highlights1  = $request->highlights1Text;
                $package->highlights2  = $request->highlights2Text;
                $package->highlights3  = $request->highlights3Text;
                $package->highlights4  = $request->highlights4Text;
                $package->highlights5  = $request->highlights5Text;
                $package->save();

                $lastRrowid = $package->id;
                $lastRrow  = Package::where('id', $lastRrowid)->first();

                //Return result to jTable
                $jTableResult['Result'] = "OK";
                $jTableResult['Record'] = $lastRrow;
            }
        }catch(\Exception $ex){
            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();
        }
        print json_encode ($jTableResult);
    }


    public function updatePackage(Request $request){

        $jTableResult = array();
        try{
            $validator = Validator::make($request->all(),[
                'title'             =>'required',
                'descriptionText'   =>'required',
                'duration'          =>'required',
                'price'             =>'required'
            ]);

            if ($validator->fails()) {
               // return back()->withErrors($validator)->withInput();
                $messages  = $validator->messages();
                $errorMsg  =($messages->first('title') == '')?'':$messages->first('title').'<br>';
                $errorMsg .=($messages->first('descriptionText') == '')?'':$messages->first('descriptionText').'<br>';
                $errorMsg .=($messages->first('duration') == '')?'':$messages->first('duration').'<br>';
                $errorMsg .=($messages->first('price') == '')?'':$messages->first('price').'<br>';

                //dd($errorMsg);
                if($errorMsg){
                    throw new \Exception('validate failed');
                }

            }else{

                //check package already exsist
                $packageRecords  = Package::where('title', $request->title)->where('id', '<>', $request->id)->get();
                $packageRecCount = $packageRecords->count();

                if($packageRecCount){throw new \Exception('Package name already exsists');}

                //check if image uploaded
                $row  = Package::where('id', $request->id)->first();
                $img = $row->image;
                $fol = $row->folder;

                // Handle File Upload
                if($request->hasFile('packageImg_update')){

                    $time = time();

                    if($fol == '' || !is_dir(public_path().'/storage/package_images/'.$fol)){
                        //upload folder
                        $folderName      = 'package_'.$time;
                    }else{
                        $folderName      = $fol;
                    }

                    // Get filename with the extension
                    $filenameWithExt = $request->file('packageImg_update')->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $request->file('packageImg_update')->getClientOriginalExtension();
                    // Filename to store
                    $fileNameToStore = $filename.'_'.$time.'.'.$extension;

                    //upload folder
                    //$folderName      = 'package_'.time();

                    $fileCheckPath = public_path().'/storage/package_images/'.$folderName.'/'. $fileNameToStore;
                    $sdd = '/storage/package_images/'.$folderName.'/'. $fileNameToStore;

                    if (file_exists($fileCheckPath)){
                        //throw new exception($fileCheckPath . " already exists");
                        throw new \Exception("file already exists");
                    }

                    // Upload Image
                    //public/package_images/'.$folderName
                    $path = $request->file('packageImg_update')->storeAs('public/package_images/'.$folderName, $fileNameToStore);
                    $fileStorePath = $folderName.'/'.$fileNameToStore;

                }else {

                    if($img){
                        $folderName = '';
                        $fileStorePath = $img;
                    }else{
                        $folderName = '';
                        $fileStorePath = $folderName.'/noimage.png';
                    }

                }

                //package insert into database
                $package = Package::find($request->id);
                $package->title        = $request->title;
                $package->price        = $request->price;
                $package->description  = $request->descriptionText;
                $package->image        = $fileStorePath;//$request->image;
                $package->folder       = $folderName;//$request->image;
                $package->duration     = $request->duration;
                $package->highlights1  = $request->highlights1Text;
                $package->highlights2  = $request->highlights2Text;
                $package->highlights3  = $request->highlights3Text;
                $package->highlights4  = $request->highlights4Text;
                $package->highlights5  = $request->highlights5Text;
                $package->save();

                $lastRowId = $package->id;
                $lastRow  = Package::where('id', $lastRowId)->first();

                //Return result to jTable
                $jTableResult['Result'] = "OK";
                $jTableResult['Record'] = $lastRow;
            }
        }catch(\Exception $ex){
            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();

        }
        print json_encode ($jTableResult);
    }

}
