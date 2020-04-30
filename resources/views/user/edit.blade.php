@extends('master')

@section('title_page', 'Edit Data - Pusat Informasi Penanganan Covid-19')

@section('content')
	<form action="/user/update" method="post">
		{{csrf_field()}}
		{{ method_field('PUT') }}
		<input type="hidden" name="id" value="{{$user->id}}">
		<div class="form-group">
			<label for="email">Email</label>
			<input class="form-control" type="email" name="email" id="email" value="{{$user->email}}">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input class="form-control" type="password" name="password" value="{{$user->password}}">
		</div>
		<button type="submit" class="btn btn-primary">Update User</button>
	</form>
@endsection