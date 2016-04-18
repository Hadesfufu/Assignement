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

/**
 * Class ProjectsController
 * @package App\Http\Controllers
 */

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
     * Show the tables of all projects.
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

    /**
     * Show the add project form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addIndex()
    {
        return view('projectsAddForm');
    }

    /**
     * Manage the request of the add form
     * @param Requests\ProjectCreationRequest $request
     * @return mixed
     */
    public function add(Requests\ProjectCreationRequest $request){

        $user = User::where('id',Auth::user()->id)->get()[0];
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

    /**
     * Show the edit project form
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editIndex($id){
        if(!Project::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('projects');
        }
        elseif(Auth::user()->administrator || Project::where('id', $id)->get()[0]->creatorId == Auth::user()->id) {
            $project = Project::where('id', $id)->get()[0];
            return view('projectsEditForm', ['project' => $project]);
        }
        else
            return Redirect::to('projects');
    }

    /**
     * Manage the edit project form request
     * @param $id
     * @param Requests\ProjectCreationRequest $request
     * @return mixed
     */
    public function edit($id, Requests\ProjectCreationRequest $request){
        if(!Project::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('/');
        }
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

    /**
     * Show details of a Project
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id){
        if(!Project::where('id', $id)->exists()) {
            return Redirect::to('/');
        }
        $project = Project::where('id', $id)->get()[0];
        $user = User::where('id', $project->creatorId)->get()[0];
        $currentUser = NULL;
        $members = DB::table('users')->join('projects_members', 'users.id', '=', 'projects_members.UserId')->select('users.*')->where('projects_members.ProjectId', $project->id)->get();
        $isIntheProject = NULL;
        if(Auth::check()) {
            $currentUser = User::where('id',Auth::user()->id);
            $isIntheProject = false;
            foreach ($members as $member) {
                if ($currentUser->id == $member->id)
                    $isIntheProject = true;
            }
        }
        return view('projectsDetails', ['project' => $project, 'user' => $user, 'currentUser' => $currentUser, 'members' => $members, "currentIsInTheProject" => $isIntheProject]);
    }

    /**
     * Show a table of all old projects
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function oldDisplay(){
        $projects = Project::where('old', true)->get();
        $users = array();
        foreach($projects as $project){
            $users[$project->id] = User::where('id', $project->creatorId)->get();
        }
        $user = Auth::user();
        return view('projects', ['projects' => $projects, 'users' => $users, 'currentUser' => $user]);
    }

    /**
     * Declare a project as old
     * @param $id
     * @return mixed
     */
    public function setOld($id){
        if(!Project::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('/');
        }
        $user = User::where('id',Auth::user()->id)->get()[0];
        if($user->administrator){
            $project = Project::where('id', $id)->get()[0];
            $project->old = true;
            $project->save();
        }
        return Redirect::to('/projects/'.$project->id);
    }

    /**
     * Declare a project as not old
     * @param $id
     * @return mixed
     */
    public function unOld($id){
        if(!Project::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('/');
        }
        $user = User::where('id',Auth::user()->id)->get()[0];
        if($user->administrator){
            $project = Project::where('id', $id)->get()[0];
            $project->old = false;
            $project->save();
        }
        return Redirect::to('/projects/'.$project->id);
    }

    /**
     * Add a member to a project
     * @param $id
     * @return mixed
     */
    public function addMember($id){
        if(!Project::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('/');
        }
        $project = Project::where('id',$id)->get()[0];
        $user = User::where('id',Auth::user()->id)->get()[0];
        DB::table('projects_members')->insert([
            'UserId' => $user->id,
            'ProjectId' => $project->id
        ]);
        return Redirect::to('/projects/'.$project->id);
    }

    /**
     * Remove a member to a project
     * @param $id
     * @return mixed
     */
    public function removeMember($id){
        if(!Project::where('id', $id)->exists() || !User::where('id',Auth::user()->id)->exists()) {
            return Redirect::to('/');
        }
        $project = Project::where('id',$id)->get()[0];
        $user = User::where('id',Auth::user()->id)->get()[0];
        DB::table('projects_members')->where([
            'UserId' => $user->id,
            'ProjectId' => $project->id
        ])->delete();
        return Redirect::to('/projects/'.$project->id);
    }
}
