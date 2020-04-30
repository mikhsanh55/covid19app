@extends('master')

@section('title_page', 'Tambah User - Pusat Informasi Penanganan Corona Papua Barat')

@section('content')
	<form action="/user/insert" method="post">
		{{csrf_field()}}
		<div class="form-group">
			<label for="email">Email</label>
			<input class="form-control" type="email" name="email" id="email">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input class="form-control" type="password" name="password">
		</div>
		<button type="submit" class="btn btn-primary">Tambah User</button>
	</form>
@endsection 