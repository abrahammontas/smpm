@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="col-lg-4">
          <h2 class="sub-header">Edit your profile</h2>
            @if (Session::has('success'))
                <div class="alert alert-success">{!! Session::get('success') !!}</div>
            @endif
          {!! Form::open(array('url' => 'edit-profile', 'enctype' => 'multipart/form-data')) !!}
          	<div class="form-group">
			    {!! Form::label('Name') !!}
			    {!! Form::text('name', $user->name,
			        array('class'=>'form-control')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Avatar') !!}
				@if(isset($user->avatar))
				{{$user->avatar}}
	            	<img style="height:100px;" class="img img-responsive" src="/{{$user->avatar}}"/>
	    		@endif
				<div class='input-group date' id='avatar'>
					<input type='file' name="avatar" class="form-control" />
				</div>
			</div>

			<button class="btn btn-primary btn-block" type="submit">Edit</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.0/moment-with-locales.min.js"></script>
	<script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
	<script>

		$('#post_time').datetimepicker({
			format: 'YYYY/MM/D hh:mm:ss',
			minDate: moment()
		});

	</script>
@endsection