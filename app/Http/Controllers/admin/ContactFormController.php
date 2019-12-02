<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactFormController extends Controller
{
    //

    public function viewComments(Request $request){

        // dd($request);
        $jTableResult = array();
        try
        {

            //var_dump ($request->action);
            //var_dump ($request->jtStartIndex);
            //var_dump ($request->jtPageSize);
            //var_dump ($request->jtSorting);


            $jTableResult['_____________StartIndex_____________'] = $StartIndex = $request->jtStartIndex;
            $jTableResult['_____________PageSize_____________'] = $PageSize = $request->jtPageSize;
            $jTableResult['_____________jtSorting_____________'] = $Sorting = $request->jtSorting;


            //First you have to enable query log it can be done using
            //DB::connection()->enableQueryLog();


            $Sorting = array('column' => 'id', 'order' => 'asc');

            if ($Sorting == 'undefined')
            {
                $inqRecords = Inquiry::limit ($PageSize)->offset ($StartIndex)->get ();

            }
            else
            {
                $inqRecords = Inquiry::orderBy ($Sorting['column'], $Sorting['order'])->limit ($PageSize)->offset ($StartIndex)->get ();
            }


            $inqTotRecCount = Inquiry::count();


            //var_dump ($inqRecCount);

            //then you can use below code to see the query log
            //$queries = DB::getQueryLog();

            //if you want to see the last executed query
            //$last_query = end($queries);

            //var_dump ($last_query);


            //dd($inquiry);


            //Add all records to an array
            $resultArr = array();
            foreach ($inqRecords as $result)
            {
                $resultArr[] = $result;
            }

            //Return result to jTable
            $jTableResult['Result'] = "OK";
            $jTableResult['Records'] = $resultArr;
            $jTableResult["TotalRecordCount"] = $inqTotRecCount;

            //var_dump($jTableResult);

        }catch(Exception $ex){

            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();
        }

        print json_encode ($jTableResult);


    }

    public function deleteCommentById(Request $request){

        $jTableResult = array();
        $recId = $request->id;


        try{

            //Delete from database
            Inquiry::destroy($recId);

            //Return result to jTable
            $jTableResult['Result'] = "OK";
            print json_encode ($jTableResult);

        }catch(Exception $ex){

            //Return error message
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message'] = $ex->getMessage();
        }

    }






}
