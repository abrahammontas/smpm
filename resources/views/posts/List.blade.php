@extends('layouts.app')

@section('content')

  <div class="col-sm-12 col-md-12 main">
          <a class=" btn btn-warning" href="post/create">Add a new post</a>
          <h2 class="sub-header">Post list</h2>
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
                  <th>Text</th>
                  <th>Post time</th>
                  <th>Account</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach($posts as $p)
                <tr>
                  <td>{{ $p->id }}</td>
                  <td>{{ $p->text }}</td>
                  <td>{{ $p->post_time }}</td>
                  <td>{{ $p->account->alias }}</td>
                  <td>
                      @if(isset($p->images->first()->image))
                          <img style="height:100px;" class="img img-responsive" src="storage/posts/{{$p->images->first()->image}}"/>
                      @endif
                  </td>
                  <td>
                      @if($p->published)
                          <span class="label label-success">Published</span>
                      @else
                        <span class="label label-primary">Scheduled</span>
                      @endif
                  </td>
                    <td>
                        {!! Form::open(array('method' => 'DELETE', 'route' => array('post.destroy', $p->id))) !!}
                        <div class="btn-group" role="group" aria-label="...">
                            <a href=" @if($p->published)# @else{{url('post/'.$p->id.'/edit')}}@endif"  @if($p->published) disabled @endif class='btn btn-primary'> Edit </a>
                              <a href="{{url('post/'.$p->id)}}" class='btn btn-info'> Show </a>
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