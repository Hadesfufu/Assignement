@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Publication</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('publications/edit/'.$publication->id) }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Edit Publication name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value={{$publication->name}}>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' :     '' }}">
                                <label class="col-md-4 control-label">Edit Publication description</label>

                                <div class="col-md-6">
                                    <textarea type="textarea" class="form-control" name="description" rows="7" style="resize: none" >{{$publication->content}}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Edit Publication PDF</label>

                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="pdf">
                                </div>

                                @if(Session::has('fileError1'))
                                    <div class="alert alert-error">
                                        {{Session::get('fileError1')}}
                                    </div>
                                @endif
                                @if ($errors->has('pdf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pdf') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Edit Publication TXT</label>

                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="txt">
                                </div>

                                @if(Session::has('fileError2'))
                                    <div class="alert alert-error">
                                        {{Session::get('fileError2')}}
                                    </div>
                                @endif
                                @if ($errors->has('txt'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('txt') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-save"></i>Edit
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
