@extends('layouts.app')

@section('content')

  <div class="col-sm-12 col-md-12 main">
          <a class=" btn btn-warning" href="post/create">Add a new post</a>
          <h2 class="sub-header">Post list</h2>
          <div class='<?php if(isset($class)){echo $class;}?>'>
            <?php if(isset($message)){echo $message;}?>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Text</th>
                  <th>Post time</th>
                  <th>Account</th>
                  <th>Image</th>
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
                  <td></td>
                    <td>
                        {!! Form::open(array('method' => 'DELETE', 'route' => array('post.destroy', $p->id))) !!}
                        <div class="btn-group" role="group" aria-label="...">
                            <a href="{{url('post/'.$p->id.'/edit')}}" class='btn btn-primary'> Edit </a>
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