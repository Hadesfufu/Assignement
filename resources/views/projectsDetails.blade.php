@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        function navigate(url)
        {
            document.location.href = url;
        }
    </script>
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
                        @if(count($members) > 0)
                            <table class="table">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Register date</th>
                                </tr>
                                @foreach ($members as $member)
                                    <tr onclick="navigate('{{url("members/".$member->id)}}')" style="cursor:pointer">
                                        <td text-align="center" style="padding : 3px"><img src={{url($member->photo)}} height="40px" /></td>
                                        <td><p>{{ $member->name }}</p></td>
                                        <td><p>{{ $member->email }}</p></td>
                                        <td><p>{{ $member->created_at }}</p></td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                        @if(isset($currentUser))
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
                                <a href={{url("projects/setOld/".$project->id)}} class="btn btn-primary">
                                    <i class="fa fa-btn fa-gear"></i>Set old
                                </a>
                            @else
                                <a href={{url("projects/unOld/".$project->id)}} class="btn btn-primary">
                                    <i class="fa fa-btn fa-gear"></i>Unset old
                                </a>
                            @endif
                        @endif
                        @if(!$currentIsInTheProject)
                        <a href={{url("projects/addMember/".$project->id)}} class="btn btn-primary pull-right">
                            <i class="fa fa-btn fa-plus"></i>Add me!
                        </a>
                        @else
                        <a href={{url("projects/removeMember/".$project->id)}} class="btn btn-primary pull-right">
                        <i class="fa fa-btn fa-minus"></i>Remove me!
                        </a>
                        @endif
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
