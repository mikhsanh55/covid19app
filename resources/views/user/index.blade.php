@extends('master')

@section('title_page', 'User Pusat Informasi')

@section('content')
	<main class="">
		<section class="mt-4 mb-4">
			<a href="/user/add" class="btn btn-primary btn-sm">Tambah User</a>
		</section>
		<table class="table table-bordered table-striped" id="user_table">
			<thead>
				<tr>
					<th>No</th>
					<th>Email</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>{{++$no}}</td>
						<td>{{$user->email}}</td>
						<td class="btn-group w-100">
							<a href="/user/edit/{{$user->id}}" class="btn btn-primary btn-sm">Edit</a>
							<a type="button" class="btn btn-danger btn-sm" href="/user/hapus/{{$user->id}}">Hapus</a>
						</td>
					</tr>
				@endforeach	
			</tbody>
		</table>
	</main>
@endsection

@section('script')
	@verbatim
		<script type="text/javascript">
			$(document).ready(function() {
				$('#user_table').DataTable()	
			})
		</script>
	@endverbatim
@endsection