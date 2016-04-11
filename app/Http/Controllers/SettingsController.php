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
        return \Redirect::route('settings')
            ->with('message', 'Your data have been updated successfully!');
    }
}
