@extends('layouts.app')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="col-lg-4">
            <h2 class="sub-header">Add fan pages as account</h2>
            {!! Form::open(array('url' => 'account/savepages', 'method' => 'post')) !!}
            <div class="form-group">
                <input type="hidden" value="{{$accountId}}" name="accountId">
                {!! Form::label('Fan pages') !!}
                <select style="width:100% !important;" class="js-example-basic-multiple" multiple="multiple" name="accounts[]">
                    @foreach($fanPages as $page)
                        <option value="{{$page['id']}}">{{$page['name']}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Add</button>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="col-lg-4">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

    </div>

@endsection

@section('scripts')
        <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script type="text/javascript">
        $(".js-example-basic-multiple").select2();
    </script>
@endsection