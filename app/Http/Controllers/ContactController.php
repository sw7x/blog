<?php

namespace App\Http\Controllers;

use App\Inquiry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ContactController extends Controller
{
    //
	public function index(){
		return view('contact');
	}

	public function submit(Request $request){
		//dd('submit');

        $validator = Validator::make($request->all(),[
            'name'          => 'required|min:3|alpha_spaces',
            'email'         => 'required|email',
            'subject'       => 'required',
            'mobile'        => 'required']);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }else{

            try {

                //dd($request->input('g-recaptcha-response'));
                $data = [
                    'secret' => env('RECAPTCHA_SECRET'),
                    'response' => $request->input('g-recaptcha-response')
                ];

                //check google recpatcha
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

                $response = curl_exec($curl);
                $response = json_decode($response, true);
                if ($response['success'] === false) {
                    // Failure
                    throw new \Exception('Recaptcha validate failed');
                } else {
                    
                    DB::beginTransaction();

                    $inquiry = new Inquiry();
                    $inquiry->name        = $request->input('name');
                    $inquiry->email       = $request->input('email');
                    $inquiry->subject     = $request->input('subject');
                    $inquiry->mobile      = $request->input('mobile');
                    $inquiry->message     = $request->input('message');
                    $inquiry->save();
                    DB::commit();

                    //insert into db success
                    return redirect()->route('contact.submit')->with([
                        'status'=>'Form Submit success',
                        'msg' => 'Form has Successfully submitted',
                        'title' => 'Contact us Form - Submit Page'
                    ]);
                }

            } catch (\PDOException $e) {


                DB::rollBack();

                //insert into db fail
                return redirect()->route('contact.submit')->with([
                    'status'=>'Form Submit failed',
                    'msg' => 'Database Error',
                    'title' => 'Contact us Form - Submit Page'
                ]);

            }catch (\Exception $e) {

                DB::rollBack();

                //insert into db fail
                return redirect()->route('contact.submit')->with([
                    'status'=>'Form Submit failed',
                    'msg' => $e->getMessage(),
                    //'msg' => 'Error occurred while registration form submitting',
                    'title' => 'Contact us Form - Submit Page'
                ]);
            }

        }
	}

    public function loadSubmit(){
        return view('contact-submit');
	    //dd('failed');
    }

}
