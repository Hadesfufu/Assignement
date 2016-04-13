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
                    <div class="panel-heading">Publications</div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>PDF/Text</th>
                                <th>Title</th>
                                <th>Register date</th>
                                @if(!empty($currentUser))
                                    <th>Edit</th>
                                @endif
                            </tr>
                            @foreach ($publications as $publication)
                                <tr onclick="navigate('{{url("publications/".$publication->id)}}')" style="cursor : pointer">
                                    @if(!empty($publication->pdf))
                                        <td><a href={{url($publication->pdf)}} height="40px"><i class="fa fa-btn fa-file-pdf-o"></i></a></td>
                                    @else
                                        <td><a href={{url($publication->txt)}} height="40px"><i class="fa fa-btn fa-file-text"></i></a></td>
                                    @endif
                                    <td><p>{{ $publication->name }}</p></td>
                                    <td><p>{{ $publication->created_at }}</p></td>
                                    @if(!empty($currentUser))
                                        <td>
                                            <a href={{url("publications/edit/".$publication->id)}} class="btn btn-primary" >
                                            <i class="fa fa-btn fa-gear"></i>Edit
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="panel-footer">
                        @unless (!Auth::check())
                            <a href={{url("publications/add")}} class="btn btn-primary" >
                            <i class="fa fa-btn fa-plus"></i>Add Publication
                            </a>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
