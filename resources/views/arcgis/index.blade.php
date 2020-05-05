@extends('admin')

@section('title_page', 'Pusat Informasi dan Koordinasi COVID-19 Papua Barat')
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
                        <table class="display table table-borderless" style="width:100%">
                            
                            <tbody>
                            	
                        		<tr>
                        			<td>Link Arcgis</td>
                        			<td><input type="text" class="form-control" value="{{$data->src}}" disabled readonly></td>
                        			<td class="btn-group w-100 d-flex justify-content-center">
                        				<button data-src="{{$data->src}}" data-id="{{$data->encrypt_id}}" class="btn btn-sm btn-primary btn-arcgis">Edit</button>
                        			</td>
                        		</tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
	</div>
	<!-- Modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal-arcgis">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit Link Arcgis</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form id="form-arcgis">
	      	<input type="hidden" name="_token" value="{{csrf_token()}}">
	      	<input type="hidden" name="_id" value="">
	      <div class="modal-body">
	      		<div class="form-group">
		      		<label for="nama">Link</label>
		      		<input type="text" name="arcgis_src" value="" class="form-control" required>
		      	</div>
	      	
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn-arcgis-submit-form btn btn-primary">Edit</button>
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
		$('.btn-arcgis').click(function(e) {
			var id = $(this).data('id'),
				value = $(this).data('src')

			$('input[type=text][name=arcgis_src]').val(value)
			$('input[type=hidden][name=_id]').val(id)
			$('#modal-arcgis').modal('show')
			$('#form-arcgis').submit(function(e) {
				e.preventDefault()
				$('.btn-arcgis-submit-form').text('Loading...')
				$('.btn-arcgis-submit-form').prop('disabled', true)

				postData($('#form-arcgis').serialize(), '/arcgis/update')
				.then(res => {
					$('.btn-arcgis-submit-form').text('Edit')
					$('.btn-arcgis-submit-form').removeAttr('disabled')
					$('#modal-arcgis').modal('hide')
					window.location.reload()
				})
				.catch(e => {
					$('.btn-arcgis-submit-form').text('Edit')
					$('.btn-arcgis-submit-form').removeAttr('disabled')
					alert('Something wrong on server')
					return false
				})
			})

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