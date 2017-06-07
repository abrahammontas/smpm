@extends('layouts.app')

@section('content')

  <div class="col-sm-12 col-md-12 main">
          <h2 class="sub-header">Account list</h2>
          <div class='<?php if(isset($class)){echo $class;}?>'>
            <?php if(isset($message)){echo $message;}?>
          </div>
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
                <tr>
                  <td>{{ $a->id }}</td>
                  <td>{{ $a->alias }}</td>
                  <td>{{ $a->provider }}</td>
                  <td>{{ $a->created_at }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

@endsection