@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Show post</h2>
		<div class="col-lg-4">
          	<div class="form-group">
			    {!! Form::label('Text:') !!}
			    {{$post->text}}
			</div>
          	<div class="form-group">
			    {!! Form::label('Account:') !!}
			    {{$post->account->alias}}
			</div>
          	<div class="form-group">
			    {!! Form::label('Post Time:') !!}
			    {{$post->post_time}}
			</div>
          	<div class="form-group">
			    {!! Form::label('Status:') !!}
			    @if($post->published)
			        <span class="label label-success">Published</span>
			    @else
			    	<span class="label label-primary">Scheduled</span>
			    @endif
			</div>
          	<div class="form-group">
			    {!! Form::label('Created at:') !!}
			    {{$post->created_at}}
			</div>
          	<div class="form-group">
			    {!! Form::label('Updated at:') !!}
			    {{$post->updated_at}}
			</div>
		</div>	
		<div class="col-lg-4">
              @foreach($post->images as $image)
                  <img style="height:100px;" class="img img-responsive" src="/storage/posts/{{$image->image}}"/>
              @endforeach
        </div>	
</div>

@endsection

@section('scripts')
@endsection