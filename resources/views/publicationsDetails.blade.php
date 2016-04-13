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
                    <h2 style="margin-top: 10px">{{$publication->name}}</h2>
                </div>
                <div class="panel-body">
                    <div class="col-md-4">
                        @if(!empty($publication->pdf))
                            <div>
                                <h3>PDF File</h3>
                                <a href={{url($publication->pdf)}} style="font-size:50px"><i class="fa fa-btn fa-file-pdf-o"></i></a>
                            </div>
                        @endif
                        <div>
                            <h3>TXT File</h3>
                            <a href={{url($publication->txt)}}  style="font-size:50px"><i class="fa fa-btn fa-file-text"></i></a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            <h3>Created at</h3>
                            <p>{{$publication->created_at}}</p>
                        </div>
                        <div>
                            <h3>Description</h3>
                            <p>{{$publication->content}}</p>
                        </div>
                    @if(!empty($currentUser))
                        <a href={{url("publications/edit/".$publication->id)}} class="btn btn-primary">
                            <i class="fa fa-btn fa-gear"></i>Edit
                        </a>
                        @if($currentUser->administrator)
                            @if(!$publication->old)
                                <a href={{url("publications/setOld/".$publication->id)}} class="btn btn-primary">
                                    <i class="fa fa-btn fa-gear"></i>Set old
                                </a>
                            @else
                                <a href={{url("publications/unOld/".$publication->id)}} class="btn btn-primary">
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
