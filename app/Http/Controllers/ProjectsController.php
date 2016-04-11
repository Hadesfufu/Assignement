<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Project;
use DB;
use App\Http\Requests;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Http\Request;

class ProjectsController extends Controller
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
        $projects = Project::where('old', false)->get();
        $users = array();
        foreach($projects as $project){
            $users[$project->id] = User::where('id', $project->creatorId)->get();
        }
        $user = Auth::user();
        return view('projects', ['projects' => $projects, 'users' => $users, 'currentUser' => $user]);
    }

    public function addIndex()
    {
        return view('projectsAddForm');
    }

    public function add(Requests\ProjectCreationRequest $request){

        $user = User::find(Auth::user()->id);
        $project = new Project;
        $project->name = $request->name;
        $project->creatorId = $user->id;
        if(isset($request->description)) {
            $project->description = $request->description;
        }
        if($request->hasFile('image')) {
            $image = $request->file('image');
            if($image->isValid()){
                $extension = $image->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111,99999).'.'.$extension; // renameing image
                $image->move("img", $fileName);
                $project->photo = "img/".$fileName;
            }
            else {
                // sending back with error message.
                Session::flash('fileError', 'uploaded file is not valid');
                return Redirect::to('projectsAddForm');
            }
        }
        else {
            Session::flash('fileError', $request->image);
        }
        $project->save();
        return Redirect::to('projects/add')
            ->with('message', 'The project has been successfully created!');
    }

    public function editIndex($id){
        $project = Project::where('id', $id)->get()[0];

        return view('projectsEditForm', ['project' => $project]);
    }

    public function edit($id, Requests\ProjectCreationRequest $request){
        $project = Project::where('id', $id)->get()[0];
        $project->name = $request->name;
        if(isset($request->old))
            $project->old = true;
        else
            $project->old = false;
        if(isset($request->description)) {
            $project->description = $request->description;
        }
        if($request->hasFile('image')) {
            $image = $request->file('image');
            if($image->isValid()){
                $extension = $image->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111,99999).'.'.$extension; // renameing image
                $image->move("img", $fileName);
                $project->photo = "img/".$fileName;
            }
            else {
                // sending back with error message.
                Session::flash('fileError', 'uploaded file is not valid');
                return Redirect::to('projectsAddForm');
            }
        }
        else {
            Session::flash('fileError', $request->image);
        }
        $project->save();
        return Redirect::to('projects/edit/'.$id)
            ->with('message', 'The project has been successfully updated!');
    }

    public function details($id){
        $project = Project::where('id', $id)->get()[0];
        $user = User::where('id', $project->creatorId)->get()[0];
        $currentUser = NULL;
        if(Auth::check())
            $currentUser = User::find(Auth::user()->id);
        return view('projectsDetails', ['project' => $project, 'user' => $user, 'currentUser' => $currentUser]);
    }


    public function oldDisplay(){
        $projects = Project::where('old', true)->get();
        $users = array();
        foreach($projects as $project){
            $users[$project->id] = User::where('id', $project->creatorId)->get();
        }
        $user = Auth::user();
        return view('projects', ['projects' => $projects, 'users' => $users, 'currentUser' => $user]);
    }
}
