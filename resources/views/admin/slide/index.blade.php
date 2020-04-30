@extends('admin')

@section('title_page', 'Slide Banner')

@section('content')
	<br><br><br>
	<div class="main-content-wrap sidenav-open d-flex flex-column">
		<div class="breadcrumb">
            <h1>{{$title}}</h1>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li>{{$title}}</li>
            </ul>
        </div>
        <div class="col-md-12 mb-4">
            <div class="card text-left">

                <div class="card-body">
                    <h4 class="card-title mb-3">{{$title}}</h4>
                    <div class="table-responsive">
                    	<button data-action="tambah" class="btn-slider btn btn-primary btn-sm mb-4 mt-2">Tambah</button>
                        <table id="kontak_table" class="display table table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@if($datas->count() > 0)
                            	@foreach($datas as $data)
                            		<tr>
                            			<td>{{++$no}}</td>
                            			<td>
                            				<img src="{{$data->image}}" width="70" height="70" class="img">
                            			</td>
                            			<td>{{$data->nama}}</td>
                            			<td class="btn-group w-100 d-flex justify-content-center">
                            				<button data-action="edit" data-id="{{$data->encrypt_id}}" class="btn btn-sm btn-primary btn-slider">Edit</button>
                            				<button data-action="hapus" data-id="{{$data->encrypt_id}}" class="btn btn-sm btn-danger btn-slider">Hapus</button>
                            				<!-- <button data-action="soft" data-id="{{$data->encrypt_id}}" class="btn-sm btn-slider btn btn-warning">
                            					Sampah
                            				</button> -->
                            			</td>
                            		</tr>
                            	@endforeach
                            	@else
                            		<tr>
                            			<td colspan="4" class="text-center">Data Belum ada</td>
                            			<td class="d-none"></td>
                            			<td class="d-none"></td>
                            			<td class="d-none"></td>
                            		</tr>
                            	@endif	
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
	</div>
	<!-- Modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal-slider">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Tambah Slide</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form id="form-slider" enctype="multipart/form-data">
	      	<input type="hidden" name="_token" value="{{csrf_token()}}">
	      <div class="modal-body">
	      		<div class="form-group">
		      		<label for="nama">Nama Slide</label>
		      		<input type="text" name="nama" value="" class="form-control" required>
		      	</div>
		      	<div class="form-group">
		      		<label for="image">Gambar</label>
		      		<input type="file" name="image" value="" placeholder="Masukkan Call Center" class="form-control" >
		      	</div>
	      	
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn-slider-submit-form btn btn-primary" data-action="insert" data-url="{{ url('/slider/insert') }}">Tambah</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>
@endsection
@section('script')
@verbatim
	<script>
		$(document).ready(function() {
			$('#kontak_table').DataTable()
			$('.btn-slider').click(function() {
				
				var action = ($(this).data('action')),
					labelModal = $('.modal-title'),
					btnDaruratSubmit = $('.btn-slider-submit-form'),
					id = $(this).data('id')

				switch(action) {
					case 'tambah' :
						labelModal.html('Tambah Slide')
						btnDaruratSubmit.text('Tambah')
						$('#modal-slider').modal('show')
						$('#form-slider').submit(function(e) {
							e.preventDefault()
							btnDaruratSubmit.text('Loading...')
							btnDaruratSubmit.prop('disabled', true)

							postData(new FormData(this), '/slider/insert')
							.then(function(data) {
								if(data.status)
									alert(data.msg)
									btnDaruratSubmit.text('Tambah')
									btnDaruratSubmit.removeAttr('disabled')
									$('#modal-slider').modal('hide')
									window.location.reload()
							})
							.catch(function(e) {
								alert('Something Error')
								btnDaruratSubmit.text('Tambah')
								btnDaruratSubmit.removeAttr('disabled')
								console.error(e)
								return false
							}) 
						})
					break;
					case 'edit' :
						$.ajax({
							type:'GET',
							url: '/slider/detail/' + id,
							dataType:'JSON',
							success:function(data) {

							}
						})
						.done(function(res) {
							$('input[name=nama]').val(res.data.nama)

							labelModal.html('Edit Slide')
							btnDaruratSubmit.text('Edit')
							$('#modal-slider').modal('show')
							$('#form-slider').submit(function(e) {
								e.preventDefault()
								btnDaruratSubmit.text('Loading...')
								btnDaruratSubmit.prop('disabled', true)
								// var data = $('#form-slider').serializeArray()
								// data.push({name: '_id', value:id})
								var data = new FormData(this)
								data.append('_id', id)

								postData(data, '/slider/update')
								.then(function(data) {
									if(data.status)
										alert(data.msg)
										btnDaruratSubmit.text('Edit')
										btnDaruratSubmit.removeAttr('disabled')
										$('#modal-slider').modal('hide')
										window.location.reload()
								})
								.catch(function(e) {
									var errors = JSON.parse(e.responseText)
									errors.msg.forEach(function(m) {
										alert(m)
									})
									btnDaruratSubmit.text('Edit')
									btnDaruratSubmit.removeAttr('disabled')
									console.error(e)
									return false
								}) 
							})	
						})
					break;
					case 'hapus':

						var conf = confirm('Kamu yakin?')
						if(conf)
							var token = $('input[type=hidden][name=_token]').val()
							var data = new FormData()
							data.append('_token', token)
							data.append('encrypt_id', id)
							postData(data, '/slider/delete')
							.then(function(data) {
								if(data.status)
									alert(data.msg)
									window.location.reload()
							})
							.catch(function(e) {
								var errors = JSON.parse(e.responseText)
								errors.msg.forEach(function(m) {
									alert(m)
								})
								
								console.error(e)
								return false
							}) 
						
					break;	

				}
			})

			function postData(data, url) {
				return new Promise((resolve, reject) => {
					$.ajax({
						type: 'POST',
						url: url,
						data: data,
						dataType:'JSON',
						cache: false,
						contentType:false,
						processData: false,
						success:function(res) {
							resolve(res)
						},
						error:function(e) {
							reject(e)
						}
					})
				})
			}
		})
	</script>
@endverbatim
@endsection