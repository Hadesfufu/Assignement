<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use App\Project;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class MembersController
 * Controller made for all member related routes
 * @package App\Http\Controllers
 */
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
     * Show the members table
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = DB::table('users')->where('old',false)->get();
        $isAdmin = false;
        if(Auth::check())
            $isAdmin = Auth::user()->administrator;
        return view('members', ['members' => $members, 'isAdmin' => $isAdmin]);
    }

    /**
     * Show the details of a member
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id){
        if(!User::where('id', $id)->exists()) {
            return Redirect::to('/');
        }
        $member = User::where('id', $id)->get()[0];
        $projects = Project::where('creatorId', $id)->get();
        $user = User::find(Auth::user()->id)->get();
        $projectParticipations = DB::table('projects')->join('projects_members', 'projects.id', '=', 'projects_members.ProjectId')->select('projects.*')->where('projects_members.UserId', $id)->get();
        $supervisor = User::where('id', $member->supervisor_id)->get();
        $students = User::where('supervisor_id', $id)->get();
        if ($member->isStudent)
            $supervisor = $supervisor[0];

        if(!empty($user))
            $user = $user[0];
        return view('membersDetails', ['member' => $member, 'projects' => $projects, 'currentUser' => $user, 'projectParticipations' => $projectParticipations, 'supervisor' => $supervisor, 'students' => $students]);
    }

    /**
     * Show the table of all old members
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function oldDisplay(){
        $members = DB::table('users')->where('old',true)->get();
        $isAdmin = false;
        if (Auth::check())
            $isAdmin = Auth::user()->administrator;
        return view('members', ['members' => $members, 'isAdmin' => $isAdmin]);
    }

    /**
     * grants administrator priviledges to a member
     * @param $id
     * @return mixed
     */
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

    /**
     * set old to a member
     * @param $id
     * @return mixed
     */
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

    /**
     * unset old to a member
     * @param $id
     * @return mixed
     */
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
