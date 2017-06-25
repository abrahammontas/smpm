@extends('layouts.app')

@section('content')

  <div class="col-sm-12 col-md-12 main">
      <a class=" btn btn-warning" href="account/create">Add a new account</a>
          <h2 class="sub-header">Account list</h2>
          @if (session('message'))
              <div class="{{session('class')}}">
                  {{ session('message') }}
              </div>
          @endif
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Alias</th>
                  <th>Provider</th>
                  <th>Created at</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach($accounts as $a)
                <tr @if($a->error)class="danger"@endif>
                  <td>{{ $a->id }}</td>
                  <td>{{ $a->alias }}</td>
                  <td>{{ $a->provider }}</td>
                  <td>{{ $a->created_at }}</td>
                  <td>
                      {!! Form::open(array('method' => 'DELETE', 'route' => array('account.destroy', $a->id))) !!}
                      <div class="btn-group" role="group" aria-label="...">
                          <a href="{{url('account/'.$a->id.'/edit')}}" class='btn btn-primary'> Edit </a>
                          @if($a->provider == 'facebook' && $a->facebook_page == 0)
                            <a href="{{url('account/'.$a->id.'/pages')}}" class='btn btn-info'> Pages </a>
                          @endif
                          {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                      </div>
                      {!! Form::close() !!}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

@endsection