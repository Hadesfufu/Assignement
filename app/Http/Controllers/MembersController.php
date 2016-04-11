<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use App\Project;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;

class MembersController extends Controller
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
        $members = DB::table('users')->where('old',false)->get();

        return view('members', ['members' => $members]);
    }

    public function details($id){
        if(!User::where('id', $id)->exists()) {
            return Redirect::to('/');
        }
        $member = User::where('id', $id)->get()[0];
        $projects = Project::where('creatorId', $id)->get();
        $user = User::find(Auth::user()->id)->get();
        $projectParticipations = DB::table('projects')->join('projects_members', 'projects.id', '=', 'projects_members.ProjectId')->select('projects.*')->where('projects_members.UserId', $id)->get();
        if(!empty($user))
            $user = $user[0];
        return view('membersDetails', ['member' => $member, 'projects' => $projects, 'currentUser' => $user, 'projectParticipations' => $projectParticipations]);
    }

    public function oldDisplay(){
        $members = DB::table('users')->where('old',true)->get();

        return view('members', ['members' => $members]);
    }

    public function setAdmin($id){
        if(!User::where('id', $id)->exists() || !User::find(Auth::user()->id)->exists()) {
            return Redirect::to('/');
        }
        $user = User::find(Auth::user()->id)->get()[0];
        if($user->administrator){
            $member = User::where('id', $id)->get()[0];
            $member->administrator = true;
            $member->save();
        }
        return Redirect::to('/members/'.$member->id);
    }

    public function setOld($id){
        if(!User::where('id', $id)->exists() || !User::find(Auth::user()->id)->exists()) {
            return Redirect::to('/');
        }
        $user = User::find(Auth::user()->id)->get()[0];
        if($user->administrator){
            $member = User::where('id', $id)->get()[0];
            $member->old = true;
            $member->save();
        }
        return Redirect::to('/members/'.$member->id);
    }

    public function unOld($id){
        if(!User::where('id', $id)->exists() || !User::find(Auth::user()->id)->exists()) {
            return Redirect::to('/');
        }
        $user = User::find(Auth::user()->id)->get()[0];
        if($user->administrator){
            $member = User::where('id', $id)->get()[0];
            $member->old = false;
            $member->save();
        }
        return Redirect::to('/members/'.$member->id);
    }
}
