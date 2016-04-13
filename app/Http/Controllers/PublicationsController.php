<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use App\Publication;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;

class PublicationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::where('old', false)->get();
        $user = Auth::user();
        return view('publications', ['publications' => $publications, 'currentUser' => $user]);
    }

    public function oldDisplay(){
        $publications = Publication::where('old', true)->get();
        $user = Auth::user();
        return view('publications', ['publications' => $publications, 'currentUser' => $user]);
    }

    public function addIndex(){
        if(!Auth::check())
            return Redirect::to('publications');
        return view('publicationsAddForm');
    }

    public function add(Requests\PublicationCreationRequest $request){
        if(!Auth::check())
            return Redirect::to('publications');

        $publication = new Publication;
        $publication->name = $request->name;
        if(isset($request->description)) {
            $publication->content = $request->description;
        }
        if($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            if($pdf->isValid()){
                $extension = $pdf->getClientOriginalExtension(); // getting image extension
                if($extension == "pdf") {
                    $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                    $pdf->move("publications_upload/pdf", $fileName);
                    $publication->pdf = "publications_upload/pdf/" . $fileName;
                }
                else{
                    Session::flash('fileError1', 'You didnt upload a pdf file. sent:'.$extension );
                    return Redirect::back();
                }
            }
            else {
                // sending back with error message.
                Session::flash('fileError1', 'uploaded file is not valid');
                return Redirect::back();
            }
        }
        else {
            Session::flash('fileError', $request->image);
        }
        if($request->hasFile('txt')) {
            $txt = $request->file('txt');
            if($txt->isValid()){
                $extension = $txt->getClientOriginalExtension(); // getting image extension
                if($extension == "txt") {
                    $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                    $txt->move("publications_upload/txt", $fileName);
                    $publication->txt = "publications_upload/txt/" . $fileName;
                }
                else{
                    Session::flash('fileError2', 'You didnt upload a text file. sent:'.$extension );
                    return Redirect::back();
                }
            }
            else {
                // sending back with error message.
                Session::flash('fileError2', 'uploaded file is not valid');
                return Redirect::back();
            }
        }
        else {
            Session::flash('fileError', $request->image);
        }
        $publication->save();
        return Redirect::to('publications/add')
            ->with('message', 'The publication has been successfully created!');
    }

    public function details($id){
        if(!Publication::where('id', $id)->exists()) {
            return Redirect::to('publications');
        }
        $publication = Publication::where('id', $id)->get()[0];
        $currentUser = Auth::user();
        return view('publicationsDetails', ['publication' => $publication, 'currentUser' => $currentUser]);
    }


    public function setOld($id){
        if(!Publication::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('/publications');
        }
        $user = User::where('id',Auth::user()->id)->get()[0];
        if($user->administrator){
            $project = Publication::where('id', $id)->get()[0];
            $project->old = true;
            $project->save();
        }
        return Redirect::to('/publications/'.$project->id);
    }

    public function unOld($id){
        if(!Publication::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('/publications');
        }
        $user = User::where('id',Auth::user()->id)->get()[0];
        if($user->administrator){
            $project = Publication::where('id', $id)->get()[0];
            $project->old = false;
            $project->save();
        }
        return Redirect::to('/publications/'.$project->id);
    }


    public function editIndex($id){
        if(!Publication::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('publications');
        }
        else {
            $publication = Publication::where('id', $id)->get()[0];
            return view('publicationsEditForm', ['publication' => $publication]);
        }
    }

    public function edit($id,Requests\PublicationEditionRequest  $request){
        if(!Publication::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('/');
        }
        $publication = Publication::where('id', $id)->get()[0];
        $publication->name = $request->name;
        if(isset($request->description)) {
            $publication->content = $request->description;
        }
        if($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            if($pdf->isValid()){
                $extension = $pdf->getClientOriginalExtension(); // getting image extension
                if($extension == "pdf") {
                    $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                    $pdf->move("publications_upload/pdf", $fileName);
                    $publication->pdf = "publications_upload/pdf/" . $fileName;
                }
                else{
                    Session::flash('fileError1', 'You didnt upload a pdf file. sent:'.$extension );
                    return Redirect::back();
                }
            }
            else {
                // sending back with error message.
                Session::flash('fileError1', 'uploaded file is not valid');
                return Redirect::back();
            }
        }
        else {
            Session::flash('fileError', $request->image);
        }
        if($request->hasFile('txt')) {
            $txt = $request->file('txt');
            if($txt->isValid()){
                $extension = $txt->getClientOriginalExtension(); // getting image extension
                if($extension == "txt") {
                    $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                    $txt->move("publications_upload/txt", $fileName);
                    $publication->txt = "publications_upload/txt/" . $fileName;
                }
                else{
                    Session::flash('fileError2', 'You didnt upload a text file. sent:'.$extension );
                    return Redirect::back();
                }
            }
            else {
                // sending back with error message.
                Session::flash('fileError2', 'uploaded file is not valid');
                return Redirect::back();
            }
        }
        else {
            Session::flash('fileError', $request->image);
        }
        $publication->save();
        return Redirect::to('publications/edit/'.$id)
            ->with('message', 'The publication has been successfully edited!');
    }

}
