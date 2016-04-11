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
                    <div class="panel-heading">Members</div>
                    <div class="panel-body">
                        @if (count($members) < 1)
                            <p>There is no members in this list</p>
                        @else
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
