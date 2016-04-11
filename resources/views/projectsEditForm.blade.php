@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Project</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('projects/edit/'.$project->id) }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">New project name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value={{$project->name}}>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' :     '' }}">
                                <label class="col-md-4 control-label">New project description</label>

                                <div class="col-md-6">
                                    <textarea type="textarea" class="form-control" name="description" rows="7" style="resize: none" >{{$project->description}}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">is it an Old Project?</label>

                                <div class="col-md-6">
                                    <input type="checkbox" class="form-control" name="old" value={{$project->old}}>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">New project image</label>

                                <img src={{ url($project->photo) }} height="34px" />
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="image">
                                </div>

                                @if(Session::has('fileError'))
                                    <div class="alert alert-error">
                                        {{Session::get('fileError')}}
                                    </div>
                                @endif
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-save"></i>Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        @if(Session::has('message'))
                            <div class="alert alert-info">
                                {{Session::get('message')}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
