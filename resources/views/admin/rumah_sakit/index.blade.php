@extends('admin')

@section('title_page', 'Rumah Sakit')

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
                        <button data-action="tambah" class="btn-rumah-sakit btn btn-primary btn-sm mb-4 mt-2">Tambah</button>
                        <table id="rumah_sakit_table" class="display table table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No Rumah Sakit</th>
                                    <th>Keterangan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($datas->count() > 0)
                                @foreach($datas as $data)
                                    <tr>
                                        <td>{{++$no}}</td>
                                        <td>{{$data->nama}}</td>
                                        <td>{{$data->alamat}}</td>
                                        <td>{{$data->no}}</td>
                                        <td>{{$data->ket}}</td>
                                        <td class="btn-group w-100 d-flex justify-content-center">
                                            <button data-action="edit" data-id="{{$data->encrypt_id}}" class="btn btn-sm btn-primary btn-rumah-sakit">Edit</button>
                                            <button data-action="hapus" data-id="{{$data->encrypt_id}}" class="btn btn-sm btn-danger btn-rumah-sakit">Hapus</button>
                                            <!-- <button data-action="soft" data-id="{{$data->encrypt_id}}" class="btn-sm btn-rumah-sakit btn btn-warning">
                                                Sampah
                                            </button> -->
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Data Belum ada</td>
                                        <td class="d-none"></td>
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
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No Rumah Sakit</th>
                                    <th>Keterangan</th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-rumah-sakit">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah No Darurat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="form-rumah-sakit">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="modal-body">
            
                <div class="form-group">
                    <label for="nama">Nama Rumah Sakit</label>
                    <input type="text" name="nama" value="" placeholder="Masukkan Nama Rumah Sakit" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea rows="3"  name="alamat" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="no">Nomor Rumah Sakit</label>
                    <input type="text" name="no" value="" placeholder="Masukkan Nomor Rumah Sakit" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ket">Keterangan</label>
                    <textarea rows="3"  name="ket" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="ket">Rumah Sakit Rujukan?</label>
                    <select name="rujukan" class="form-control" required>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>

            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn-rumah-sakit-submit-form btn btn-primary" data-action="insert" data-url="{{ url('/no-darurat/insert') }}">Tambah</button>
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
            $('#rumah_sakit_table').DataTable()
            $('.btn-rumah-sakit').click(function() {
                
                var action = ($(this).data('action')),
                    labelModal = $('.modal-title'),
                    btnRumahSakitSubmit = $('.btn-rumah-sakit-submit-form'),
                    id = $(this).data('id')

                switch(action) {
                    case 'tambah' :
                        labelModal.html('Tambah Rumah Sakit')
                        btnRumahSakitSubmit.text('Tambah')
                        $('#modal-rumah-sakit').modal('show')
                        $('#form-rumah-sakit').submit(function(e) {
                            e.preventDefault()
                            btnRumahSakitSubmit.text('Loading...')
                            btnRumahSakitSubmit.prop('disabled', true)

                            postData($('#form-rumah-sakit').serialize(), '/rumah-sakit/insert')
                            .then(function(data) {
                                if(data.status)
                                    alert(data.msg)
                                    btnRumahSakitSubmit.text('Tambah')
                                    btnRumahSakitSubmit.removeAttr('disabled')
                                    $('#modal-rumah-sakit').modal('hide')
                                    window.location.reload()
                            })
                            .catch(function(e) {
                                alert('Something Error')
                                btnRumahSakitSubmit.text('Tambah')
                                btnRumahSakitSubmit.removeAttr('disabled')
                                console.error(e)
                                return false
                            }) 
                        })
                    break;
                    case 'edit' :
                        $.ajax({
                            type:'GET',
                            url: '/rumah-sakit/detail/' + id,
                            dataType:'JSON',
                            success:function(data) {

                            }
                        })
                        .done(function(res) {
                            $('input[name=nama]').val(res.data.nama)
                            $('textarea[name=alamat]').val(res.data.alamat)
                            $('input[name=no]').val(res.data.no)
                            $('textarea[name=ket]').val(res.data.ket)
                            $('select[name=rujukan]').val(res.data.rujukan)

                            labelModal.html('Edit Rumah Sakit')
                            btnRumahSakitSubmit.text('Edit')
                            $('#modal-rumah-sakit').modal('show')
                            $('#form-rumah-sakit').submit(function(e) {
                                e.preventDefault()
                                btnRumahSakitSubmit.text('Loading...')
                                btnRumahSakitSubmit.prop('disabled', true)
                                var data = $('#form-rumah-sakit').serializeArray()
                                data.push({name: '_id', value:id})

                                postData(data, '/rumah-sakit/update')
                                .then(function(data) {
                                    if(data.status)
                                        alert(data.msg)
                                        btnRumahSakitSubmit.text('Edit')
                                        btnRumahSakitSubmit.removeAttr('disabled')
                                        $('#modal-rumah-sakit').modal('hide')
                                        window.location.reload()
                                })
                                .catch(function(e) {
                                    alert('Something Error')
                                    btnRumahSakitSubmit.text('Edit')
                                    btnRumahSakitSubmit.removeAttr('disabled')
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
                            postData({encrypt_id: id, _token:token}, '/rumah-sakit/delete')
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