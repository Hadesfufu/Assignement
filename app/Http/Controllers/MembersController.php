<?php

namespace App\Http\Controllers;

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
        $member = User::where('id', $id)->get()[0];
        $projects = Project::where('creatorId', $id)->get();
        return view('membersDetails', ['member' => $member, 'projects' => $projects]);
    }

    public function oldDisplay(){
        $members = DB::table('users')->where('old',true)->get();

        return view('members', ['members' => $members]);
    }
}
