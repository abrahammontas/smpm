@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
@endsection

@section('content')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="col-lg-4">
			<h2 class="sub-header">Add a new post</h2>
			{!! Form::model($post, array('route' => array('post.update', $post->id),'method' => 'put')) !!}
			<div class="form-group">
				{!! Form::label('Text') !!}
				{!! Form::text('text', null,
                    array('class'=>'form-control',
                          'placeholder'=>'Get your best deals HEREE!!!')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Post time') !!}
				<div class='input-group date' id='post_time'>
					<input type='text' name="post_time" class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('Account') !!}
				<select class= "form-control" name="account_id" id="account_id">
					@foreach($accounts as $a)
						<option value="{{$a->id}}">{{ $a->alias }}</option>
					@endforeach
				</select>
			</div>

			<button class="btn btn-primary btn-block" type="submit">Add</button>
			{!! Form::close() !!}
			<br>
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment-with-locales.min.js"></script>
	<script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
	<script>

		$('#post_time').datetimepicker({
			format: 'YYYY/MM/D hh:mm:ss',
			minDate: moment()
		});

	</script>
@endsection