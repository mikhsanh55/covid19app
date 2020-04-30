@extends('admin')
@section('title_page', 'Tambah Data')

@section('content')

<br><br><br>
    <!-- ============ Body content start ============= -->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <div class="breadcrumb">
            <h1>Tambah Data</h1>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li>Tambah Data</li>
            </ul>
        </div>

        <div class="separator-breadcrumb border-top"></div>
        
           <div class="col-md-12 mb-4">
                <div class="card text-left">
                     <div class="card-body">
                        <div class="card-title mb-3">Tambah Data</div>
                        <div class="mt-4 mb-4" id="errors-display"></div>
                        <form id="form-add-pasien" autocomplete="off">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group row">
                                <label for="kabkota" class="col-sm-2 col-form-label">Kab / Kota</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="kabkota" required name="kota">
                                        <option disabled selected=""> Pilih </option>
                                        @foreach($kotakab as $kota)
                                            <option value="{{$kota->id}}">{{$kota->nama}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>

                           <div class="form-group row">
                                <label for="tgl_input" class="col-sm-2 col-form-label">Tanggal Input</label>
                                <div class="col-sm-10">
                                    <input id="tgl_input" class="form-control" placeholder="yyyy-mm-dd" name="tgl_input" required type="date" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label" >Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" required name="main-status" id="status">
                                        <option disabled selected>Pilih</option>
                                        <option value="2">Positif</option>
                                        <option value="4">ODP (Orang Dalam Pemantauan)</option>
                                        <option value="5">PDP (Pasien Dalam Pengawasan)</option>
                                        <option value="6">OTG (Orang Tanpa Gejala)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="opsi-status" class="col-sm-2 col-form-label">Status Terbaru</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="opsi-status" required name="status" disabled>
                                        <option disabled selected=""> Pilih </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Data</label>
                                <div class="col-sm-10">
                                    <input  class="form-control" id="jumlah" placeholder="Jumlah angka yang akan diinput" name="jumlah" type="number">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-big" id="btn-add-pasien">Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div>
           </div>
       </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token">
       <!-- Table Positif Aktif, Sembuh, Meninggal -->
         <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Data Pasien (Positif Aktif, Sembuh, dan Meninggal)</h4>
                        <div class="table-responsive">
                            <form class="m-2">
                                <div class="form-group row">
                                    <label for="tanggal" class="col-sm-1">Tanggal</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="tanggal" class="form-control d-inline w-25" id="filter-tanggal" value="{{$latest_date}}">
                                        <span id="filter-tanggal-status" class="d-inline ml-2"></span>
                                    </div>
                                </div>
                            </form>
                            <table class="pasien_table display table table-striped table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kab / Kota</th>
                                        <th>Positif Aktif</th>
                                        <th>Sembuh</th>
                                        <th>Meninggal</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="positif-tbody">
                                    @if($pasiens->count() > 0)
                                        @foreach($pasiens as $pasien)
                                            <tr>
                                                <td>{{++$no}}</td>
                                                <td>{{$pasien->nama}}</td>
                                                <td>{{ ($pasien->data['Positif Aktif'] - $pasien->data['Sembuh']) - $pasien->data['Meninggal'] }}</td>
                                                <td>{{$pasien->data['Sembuh']}}</td>
                                                <td>{{$pasien->data['Meninggal']}}</td>
                                                <td>{{$pasien->data['Positif Aktif']}}</td>
                                                <td class="btn-group w-100">
                                                    <a class="btn btn-primary btn-sm" href="{{ url('/pasien/detail/') . '/'. $pasien->encrypt_id }}">Detail</a>
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
                                        <th>Kab / Kota</th>
                                        <th>Positif Aktif</th>
                                        <th>Sembuh</th>
                                        <th>Meninggal</th>
                                        <th>Jumlah</th>    
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        <!-- end  -->

        <!-- Table positif sembuh -->
        <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Data Pasien (OTG, ODP, PDP)</h4>
                        <div class="table-responsive">
                            <table class="pasien_table display table table-striped table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kab / Kota</th>
                                        <th>OTG Proses</th>
                                        <th>OTG Selesai</th>
                                        <th>Jumlah</th>
                                        <th>ODP Proses</th>
                                        <th>ODP Selesai</th>
                                        <th>Jumlah</th>    
                                        <th>PDP Proses</th>
                                        <th>PDP Selesai</th>
                                        <th>Jumlah</th>    
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="odp-tbody">
                                    @if($pasiens->count() > 0)
                                        @foreach($pasiens as $pasien)
                                            <tr>
                                                <td>{{++$no2}}</td>
                                                <td>{{$pasien->nama}}</td>
                                                <td>{{$pasien->data['Proses OTG'] - $pasien->data['Selesai OTG']}}</td>
                                                <td>{{$pasien->data['Selesai OTG']}}</td>
                                                <td>{{$pasien->data['Proses OTG']}}</td>

                                                <td>{{$pasien->data['Proses ODP'] - $pasien->data['Selesai ODP']}}</td>
                                                <td>{{$pasien->data['Selesai ODP']}}</td>
                                                <td>{{$pasien->data['Proses ODP']}}</td>

                                                <td>{{$pasien->data['Proses PDP'] - $pasien->data['Selesai PDP']}}</td>
                                                <td>{{$pasien->data['Selesai PDP']}}</td>
                                                <td>{{$pasien->data['Proses PDP']}}</td>
                                                <td class="btn-group w-100">
                                                    <a class="btn btn-primary btn-sm" href="{{ url('/pasien/detail/') . '/'. $pasien->encrypt_id }}">Detail</a>
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
                                        <th>Kab / Kota</th>
                                        <th>OTG Proses</th>
                                        <th>OTG Selesai</th>
                                        <th>Jumlah</th>
                                        <th>ODP Proses</th>
                                        <th>ODP Selesai</th>
                                        <th>Jumlah</th>    
                                        <th>PDP Proses</th>
                                        <th>PDP Selesai</th>
                                        <th>Jumlah</th>    
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        <!-- end  -->
    
    </div>
@endsection

@section('script')
@verbatim


    <script type="text/javascript">
        $(document).ready(function() {
            $('.pasien_table').DataTable()

            // Filter tanggal
            $('#filter-tanggal').change(function() {
                let tanggal = $(this).val(), _token = $('#_token').val(),
                    tbodyPositif = '', tbodyOdp = '', no = 0, no2 = 0
                $('#filter-tanggal-status').html('Loading...')
                $.ajax({
                    type:'POST',
                    url: '/pasien/data-filter',
                    data: {tanggal, _token},
                    dataType: 'JSON',
                    statusCode: {
                        400: function(resp) {
                            $('#filter-tanggal-status').empty()
                            var errors = resp.responseJSON, errorsHtml = ''
                            for(var error in errors) {
                                errorsHtml = `
                                <p class="alert alert-danger">
                                    <small>${errors[error][0]}</small>
                                </p>`
                            }
                            $('#filter-tanggal-status').html(errorsHtml)
                        },
                        500: function(resp) {
                            $('#filter-tanggal-status').empty()    
                            alert('Something errors on server')
                            return false
                        }
                    },
                    success: function(res) {
                        $('#filter-tanggal-status').empty()
                        res.data.forEach(function(item, i) {
                            item.data['Positif Aktif'] = parseInt(item.data['Positif Aktif'])
                            item.data['Sembuh'] = parseInt(item.data['Sembuh'])
                            item.data['Meninggal'] = parseInt(item.data['Meninggal'])
                            item.data['Proses OTG'] = parseInt(item.data['Proses OTG'])
                            item.data['Selesai OTG'] = parseInt(item.data['Selesai OTG'])
                            item.data['Proses ODP'] = parseInt(item.data['Proses ODP'])
                            item.data['Selesai ODP'] = parseInt(item.data['Selesai ODP'])
                            item.data['Proses PDP'] = parseInt(item.data['Proses PDP'])
                            item.data['Selesai PDP'] = parseInt(item.data['Selesai PDP'])
                            tbodyPositif += `
                                <tr>
                                    <td>${++no}</td>
                                    <td>${item.nama}</td>
                                    <td>${item.data['Positif Aktif']}</td>
                                    <td>${item.data['Sembuh']}</td>
                                    <td>${item.data['Meninggal']}</td>
                                    <td>${item.data['Positif Aktif'] + item.data['Sembuh'] + item.data['Meninggal']}</td>
                                    <td class="btn-group w-100">
                                        <a class="btn btn-primary btn-sm" href="/pasien/detail/${item.encrypt_id}">Detail</a>
                                    </td>
                                </tr>`

                            tbodyOdp += `
                                <tr>
                                    <td>${++no2}</td>
                                    <td>${item.nama}</td>
                                    <td>${item.data['Proses OTG']}</td>
                                    <td>${item.data['Selesai OTG']}</td>
                                    <td>${item.data['Proses OTG'] + item.data['Selesai OTG']}</td>

                                    <td>${item.data['Proses ODP']}</td>
                                    <td>${item.data['Selesai ODP']}</td>
                                    <td>${item.data['Proses ODP'] + item.data['Selesai ODP']}</td>

                                    <td>${item.data['Proses PDP']}</td>
                                    <td>${item.data['Selesai PDP']}</td>
                                    <td>${item.data['Proses PDP'] + item.data['Selesai PDP']}</td>
                                    
                                    <td class="btn-group w-100">
                                        <a class="btn btn-primary btn-sm" href="/pasien/detail/${item.encrypt_id}">Detail</a>
                                    </td>
                                </tr>`     
                        })

                        $('#positif-tbody').html(tbodyPositif)
                        $('#odp-tbody').html(tbodyOdp)             
                    }
                })

            })
            $('#status').change(function() {
                var html = '', val = $(this).val()
                // Positif
                if(val == 2){
                    html += `<option value="2">Positif Aktif</option>
                            <option value="1">Sembuh</option>
                            <option value="3">Meninggal</option>`
                }
                else if(val == 4){
                    html += `<option value="4">Proses Pemantauan</option>
                            <option value="7">Selesai Pemantauan</option>`
                }
                else if(val == 5){
                    html += `<option value="5">Proses Pengawasan</option>
                    <option value="8">Selesai Pengawasan</option>`
                }
                else if(val == 6) {
                    html += `<option value="6">Proses OTG</option>
                    <option value="11">Selesai OTG</option>`   
                }
                
                console.log(html)
                $('#opsi-status').html(html)
                $('#opsi-status').removeAttr('disabled')
            })
            $('#form-add-pasien').submit(function(e) {
                e.preventDefault()
                $('#errors-display').empty()
                $('#btn-add-pasien').html('Loading...').prop('disabled', true)
                $.ajax({
                    type: 'POST',
                    url: '/pasien/insert',
                    data: $('#form-add-pasien').serialize(),
                    dataType:'JSON',
                    success:function(data) {
                        $('#btn-add-pasien').html('Tambah').removeAttr('disabled')
                        alert(data.msg)
                    },
                    statusCode: {
                        400: function(resp) {
                            $('#btn-add-pasien').html('Tambah').removeAttr('disabled')
                            var errors = resp.responseJSON, errorsHtml = ''
                            for(var error in errors) {
                                errorsHtml = `
                                <p class="alert alert-danger">
                                    <small>${errors[error][0]}</small>
                                </p>`
                            }
                            $('#errors-display').html(errorsHtml)
                        },
                        500: function(resp) {
                            $('#btn-add-pasien').html('Tambah').removeAttr('disabled')
                            alert('Something errors on server')
                            return false
                        }
                    }
                }).done(function() {
                    $('#btn-add-pasien').html('Tambah').removeAttr('disabled')
                    window.location.reload()
                })
            })
        })
    </script>
@endverbatim    
@endsection