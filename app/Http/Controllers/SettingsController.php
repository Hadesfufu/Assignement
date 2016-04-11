<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('settings', ['user' => $user]);
    }

    public function update(Requests\SettingsFormRequest $request){
        echo "test";
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request->password))
            $user->password = bcrypt($request->password);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            if($image->isValid()){
                $extension = $image->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111,99999).'.'.$extension; // renameing image
                $image->move("img", $fileName);
                $user->photo = "img/".$fileName;
            }
            else {
                // sending back with error message.
                Session::flash('fileError', 'uploaded file is not valid');
                return Redirect::to('settings');
            }
        }
        else {
            Session::flash('fileError', $request->image);
        }
        $user->save();
        Auth::setUser($user);
        /*
        DB::table('users')
            ->where('id', $user->id)
            ->update(['name' => $request->name,
            'email' => $request->email]);

        if(isset($request->photo))
            DB::table('users')
                ->where('id', $user->id)
                ->update(['photo' => $request->photo]);

        if(isset($request->password))
            DB::table('users')
                ->where('id', $user->id)
                ->update(['password' => bcrypt($request->password)  ]);

        $user = Auth::user();
        */

        return \Redirect::route('settings')
            ->with('message', 'Your data have been updated successfully!');
    }
    /*public function upload() {
        // getting all of the post data
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return Redirect::to('settings')->withInput()->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $destinationPath = 'uploads'; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111,99999).'.'.$extension; // renameing image
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
                // sending back with message
                Session::flash('success', 'Upload successfully');
                return Redirect::to('settings');
            }
            else {
                // sending back with error message.
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('settings');
            }
        }
    }*/
}
