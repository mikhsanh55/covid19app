@extends('admin')

@section('title_page', 'No Darurat')

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
                    	<button data-action="tambah" class="btn-no-darurat btn btn-primary btn-sm mb-4 mt-2">Tambah</button>
                        <table id="no_darurat_table" class="display table table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Call Center</th>
                                    <th>No Diskes</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@if($datas->count() > 0)
                            	@foreach($datas as $data)
                            		<tr>
                            			<td>{{++$no}}</td>
                            			<td>{{$data->call_center}}</td>
                            			<td>{{$data->no_diskes}}</td>
                            			<td class="btn-group w-100 d-flex justify-content-center">
                            				<button data-action="edit" data-id="{{$data->encrypt_id}}" class="btn btn-sm btn-primary btn-no-darurat">Edit</button>
                            				<button data-action="hapus" data-id="{{$data->encrypt_id}}" class="btn btn-sm btn-danger btn-no-darurat">Hapus</button>
                            				<!-- <button data-action="soft" data-id="{{$data->encrypt_id}}" class="btn-sm btn-no-darurat btn btn-warning">
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
                                    <th>Call Center</th>
                                    <th>No Diskes</th>
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
	<div class="modal fade" tabindex="-1" role="dialog" id="modal-no-darurat">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Tambah No Darurat</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form id="form-no-darurat">
	      	<input type="hidden" name="_token" value="{{csrf_token()}}">
	      <div class="modal-body">
	      	
		      	<div class="form-group">
		      		<label for="call_center">Call Center</label>
		      		<input type="text" name="call_center" value="" placeholder="Masukkan Call Center" class="form-control" required>
		      	</div>
		      	<div class="form-group">
		      		<label for="no_diskes">No Diskes</label>
		      		<input type="text" name="no_diskes" value="" placeholder="Masukkan No Diskes" class="form-control" required>
		      	</div>
	      	
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn-no-darurat-submit-form btn btn-primary" data-action="insert" data-url="{{ url('/no-darurat/insert') }}">Tambah</button>
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
			$('#no_darurat_table').DataTable({
				columns: [
					{visible: true},
					{visible: true},
					{visible: true},
					{visible: true}
				]
			})
			$('.btn-no-darurat').click(function() {
				
				var action = ($(this).data('action')),
					labelModal = $('.modal-title'),
					btnDaruratSubmit = $('.btn-no-darurat-submit-form'),
					id = $(this).data('id')

				switch(action) {
					case 'tambah' :
						labelModal.html('Tambah No Darurat')
						btnDaruratSubmit.text('Tambah')
						$('#modal-no-darurat').modal('show')
						$('#form-no-darurat').submit(function(e) {
							e.preventDefault()
							btnDaruratSubmit.text('Loading...')
							btnDaruratSubmit.prop('disabled', true)

							postData($('#form-no-darurat').serialize(), '/no-darurat/insert')
							.then(function(data) {
								if(data.status)
									alert(data.msg)
									btnDaruratSubmit.text('Tambah')
									btnDaruratSubmit.removeAttr('disabled')
									$('#modal-no-darurat').modal('hide')
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
							url: '/no-darurat/detail/' + id,
							dataType:'JSON',
							success:function(data) {

							}
						})
						.done(function(res) {
							$('input[name=call_center]').val(res.data.call_center)
							$('input[name=no_diskes]').val(res.data.no_diskes)

							labelModal.html('Edit No Darurat')
							btnDaruratSubmit.text('Edit')
							$('#modal-no-darurat').modal('show')
							$('#form-no-darurat').submit(function(e) {
								e.preventDefault()
								btnDaruratSubmit.text('Loading...')
								btnDaruratSubmit.prop('disabled', true)
								var data = $('#form-no-darurat').serializeArray()
								data.push({name: '_no', value:id})

								postData(data, '/no-darurat/update')
								.then(function(data) {
									if(data.status)
										alert(data.msg)
										btnDaruratSubmit.text('Edit')
										btnDaruratSubmit.removeAttr('disabled')
										$('#modal-no-darurat').modal('hide')
										window.location.reload()
								})
								.catch(function(e) {
									alert('Something Error')
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
							postData({encrypt_id: id, _token:token}, '/no-darurat/delete')
							.then(function(data) {
								if(data.status)
									alert(data.msg)
									window.location.reload()
							})
							.catch(function(e) {
								alert('Something Error')
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