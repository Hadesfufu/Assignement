@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 style="margin-top: 10px">{{$project->name}}</h2>
                </div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <img src={{url($project->photo)}} style="width: 100%" />
                    </div>
                    <div class="col-md-8">
                        <div>
                            <h3>Creator</h3>
                            <a href={{url("members/".$user->id)}}>{{$user->name}}</a>
                        </div>
                        <div>
                            <h3>Created at</h3>
                            <p>{{$project->created_at}}</p>
                        </div>
                        <div>
                            <h3>Description</h3>
                            <p>{{$project->description}}</p>
                        </div>
                    </div>
                    <div>
                    @if(!empty($currentUser))
                        @if($user->id == $currentUser->id || $currentUser->administrator)
                            <a href={{url("projects/edit/".$project->id)}} class="btn btn-primary">
                                <i class="fa fa-btn fa-gear"></i>Edit
                            </a>
                        @else
                            <a href="" class="btn btn-primary" disabled=true>
                                <i class="fa fa-btn fa-gear"></i>Not Available
                            </a>
                        @endif
                        @if($currentUser->administrator)
                            @if(!$project->old)
                                <a href={{url("projects/setOld/".$project->id)}} class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-gear"></i>Set old
                                </a>
                            @else
                                <a href={{url("projects/unOld/".$project->id)}} class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-gear"></i>Unset old
                                </a>
                            @endif
                        @endif
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
