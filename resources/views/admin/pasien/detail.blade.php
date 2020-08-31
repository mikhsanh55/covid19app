@extends('admin')
@section('title_page', 'Detail Pasien')

@section('content')
<br><br><br>
    <!-- ============ Body content start ============= -->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <div class="breadcrumb">
            <h1>Detail Pasien</h1>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li>Detail Pasien</li>
            </ul>
        </div>
        
       <!-- Table Positif Aktif, Sembuh, Meninggal -->
         <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Data Pasien (Positif Aktif, Sembuh, dan Meninggal)</h4>
                        <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
                        <input type="hidden" name="_id" value="{{Request::segment(3)}}" id="_id">
                        <div class="table-responsive">
                            <form class="ml-2 mb-4 mt-2">
                                <div class="form-group row">
                                    <label for="tanggal" class="col-sm-1">Tanggal</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="tanggal" class="form-control d-inline w-25" id="filter-tanggal" 
                                            >
                                        <span id="filter-tanggal-status" class="d-inline ml-2"></span>
                                    </div>
                                </div>
                            </form>
                            <table class="pasien_table display table table-striped table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kota / Kab</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@if(count($datas) > 0)

                                		@foreach($datas as $i => $data)
                                			<tr>
                                				<td>{{++$no}}</td>
                                				<td>{{$data->nama}}</td>
                                				<td>{{ $data->tgl_input}}</td>
                                				<td>{{$data->jml}}</td>
                                				<td>{{$data->value}}</td>
                                				<td class="btn-group w-100">
                                					<button class="btn btn-danger btn-sm delete-pasien" data-date="{{ $data->tgl_input }}"
                                					data-id="{{$data->encrypt_id}}"
                                					>Hapus</button>
                                				</td>
                                			</tr>
                                		@endforeach
                                	@else
                                		<tr>
                                			<td colspan="6" class="text-center">
                                				Belum ada data
                                			</td>
                                            <td class="d-none"></td>
                                            <td class="d-none"></td>
                                            <td class="d-none"></td>
                                            <td class="d-none"></td>
                                		</tr>
                                	@endif		
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Kota / Kab</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        <!-- end  -->        
        <!-- end  -->
    
    </div>

@endsection
@section('script')
@verbatim
	<script>
		$(document).ready(function() {
			$('.pasien_table').DataTable()

			$('.delete-pasien').on('click', function() {
				var conf = confirm('Kamu Yakin?')
				if(conf) {
					var id = $(this).data('id'),
						date = $(this).data('date')

					$.ajax({
						type: 'POST',
						url: '/pasien/delete',
						data: {id, date, _token:$('#_token').val()},
						dataType: 'JSON',
						success:function(data) {
							if(data.status)
								window.location.reload()
						}
					})
                }
                else {
                    return false
                }
			})

            // Filter tanggal
            $('#filter-tanggal').change(function() {
                let tanggal = $(this).val(), _token = $('#_token').val(), _id = $('#_id').val()
                    tbody = '', no = 0
                $('#filter-tanggal-status').html('Loading...')
                $.ajax({
                    type:'POST',
                    url: '/pasien/data-detail-filter',
                    data: {tanggal, _token, _id},
                    dataType: 'JSON',
                    success: function(res) {

                        $('#filter-tanggal-status').empty()
                        if(res.data.length > 0) {
                            res.data.forEach(function(item, i) {
                                tbody += `<tr>
                                            <td>${++no}</td>
                                            <td>${item.nama}</td>
                                            <td>${item.tgl_input}</td>
                                            <td>${item.jml}</td>
                                            <td>${item.value}</td>
                                            <td class="btn-group w-100">
                                                <button class="btn btn-danger btn-sm delete-pasien" data-date="${item.tgl_input}"
                                                data-id="${item.encrypt_id}"
                                                >Hapus</button>
                                            </td>
                                        </tr>
                                `
                            })
                        }
                        else {
                            tbody += `<tr>
                                            <td class="btn-group w-100 text-center" colspan="6">
                                                Belum ada data      
                                            </td>
                                        </tr>
                                `
                        }

                        $('tbody').html(tbody)             
                        $('.delete-pasien').on('click', function() {
                            var conf = confirm('Kamu Yakin?')
                            if(conf) {
                                var id = $(this).data('id'),
                                    date = $(this).data('date')

                                $.ajax({
                                    type: 'POST',
                                    url: '/pasien/delete',
                                    data: {id, date, _token:$('#_token').val()},
                                    dataType: 'JSON',
                                    success:function(data) {
                                        if(data.status)
                                            window.location.reload()
                                    }
                                })
                            }
                            else {
                                return false
                            }
                        })
                    }
                })


            })
		})
	</script>
@endverbatim
@endsection