@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info">
                @include('partials.planes')
            </div>
        </div>

        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">Welcome to the planes sections</div>
                <div class="panel-body">
                    <h3>Random Plane:</h3>
                    @foreach ($reg as $item)<br>
                        {{$item['reg']}}<br>
                        {{$item['type']}}<br>
                        {{$item['conNumber']}}
                    @endforeach                
                
                <hr>

                  <form action="/planes/search" method="get">
                     {{ csrf_field() }}
                    Reg Search
                    <input type="text" size="10" name="q">
                    <input type="submit" value="search">
                    </form>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        


        </div>
    </div>
</div>
@endsection
