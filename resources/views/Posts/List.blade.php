@extends('layouts.app')

@section('content')

  <div class="col-sm-12 col-md-12 main">
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
                </tr>
              </thead>
              <tbody>
                @foreach($posts as $p)
                <tr>
                  <td>{{ $p->id }}</td>
                  <td>{{ $p->text }}</td>
                  <td>{{ $p->post_time }}</td>
                  <td>{{ $p->account->name }}</td>
                  <td></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

@endsection