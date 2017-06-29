@extends('layouts.app')

@section('css')
    <!-- MetisMenu CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.0/metisMenu.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/3.3.7+1/css/sb-admin-2.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">                
                @if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
                @foreach($dashboard as $d)

                        <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-{{$d['account']->provider}} fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div>{{$d['account']->alias}}</div>
                                            <div><?php echo $d['published']; ?> published of <?php echo $d['total']; ?></div>
                                        </div>
                                </div>
                                <a href="#">
                                    <div class="panel-footer">
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                 @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
