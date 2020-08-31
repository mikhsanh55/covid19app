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
                        <!-- Form import excel -->
                        <form autocomplete="off" id="import-excel-form">
                            <div class="form-group row">
                                <label for="uploaded_file">Import data pasien via .CSV file</label>
                                <div class="col-sm-12">
                                    <input type="file" id="uploaded_file" class="form-control" required>
                                </div>
                            </div>    
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" id="btn-import" class="btn btn-sm btn-success">Import</button>
                                </div>
                            </div>
                        </form>

                        <form id="form-add-pasien" autocomplete="off">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
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
                        <div class="table-responsive table-wrapper">
                            <form class="m-2">
                                <div class="form-group row">
                                    <label for="tanggal" class="col-sm-1">Tanggal</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="tanggal" class="form-control d-inline w-25" id="filter-tanggal" value="{{$latest_date}}">
                                        <span id="filter-tanggal-status" class="d-inline ml-2"></span>
                                    </div>
                                </div>
                            </form>
                            <table class="pasien_table display table table-striped table-bordered table-hover" style="width:100%" id="positif_table">
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
                                    <!-- @if($pasiens->count() > 0)
                                        @foreach($pasiens as $pasien)
                                            <tr>
                                                <td>{{++$no}}</td>
                                                <td>{{$pasien->nama}}</td>
                                                <td>{{ ($pasien->data['Positif Aktif']) }}</td>
                                                <td>{{$pasien->data['Sembuh']}}</td>
                                                <td>{{$pasien->data['Meninggal']}}</td>
                                                <td>{{$pasien->data['Positif Aktif'] + $pasien->data['Meninggal'] + $pasien->data['Sembuh']}}</td>
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
                                    @endif       -->
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
                        <div class="table-responsive table-wrapper">
                            <table class="pasien_table display table table-striped table-bordered table-hover" style="width:100%" id="odp_table">
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
                                   <!--  @if($pasiens->count() > 0)
                                        @foreach($pasiens as $pasien)
                                            <tr>
                                                <td>{{++$no2}}</td>
                                                <td>{{$pasien->nama}}</td>
                                                <td>{{ ($pasien->data['Proses OTG']) }}</td>
                                                <td>{{$pasien->data['Selesai OTG']}}</td>
                                                <td>{{ ($pasien->data['Proses OTG']) + $pasien->data['Selesai OTG'] }}</td>

                                                <td>{{$pasien->data['Proses ODP']}}</td>
                                                <td>{{$pasien->data['Selesai ODP']}}</td>
                                                <td>{{ ($pasien->data['Proses ODP']) + $pasien->data['Selesai ODP'] }}</td>

                                                <td>{{$pasien->data['Proses PDP']}}</td>
                                                <td>{{$pasien->data['Selesai PDP']}}</td>
                                                <td>{{ ($pasien->data['Proses PDP']) + $pasien->data['Selesai PDP'] }}</td>
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
                                    @endif    -->   
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
            let tanggal = $(this).val(), _token = $('#_token').val()
            getPositifDataTable()
            getOdpDataTable()

            function getOdpDataTable(tgl = null) {
                $('#odp_table').DataTable({
                    "paging": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "type": "POST",
                        "url": "/pasien/get-datatables",
                        "data": {
                            "_token": _token,
                            "tanggal": tgl === null ? null : tgl
                        }
                    },
                    "columnDefs": [ // Disable order for some columns
                        {"orderable": false, "targets": 2},
                        {"orderable": false, "targets": 3},
                        {"orderable": false, "targets": 4},
                        {"orderable": false, "targets": 5},
                        {"orderable": false, "targets": 6},
                        {"orderable": false, "targets": 7},
                        {"orderable": false, "targets": 8},
                        {"orderable": false, "targets": 9},
                        {"orderable": false, "targets": 10},
                        {"orderable": false, "targets": 11},
                    ],
                    "columns": [ 
                        {"data": "no"},
                        {"data": "nama"},
                        {
                            "data": null,
                            "render": d => d.data['Proses OTG']
                        },
                        {
                            "data": null,
                            "render": d => d.data['Selesai OTG']
                        },
                        {
                            "data": null,
                            "render": d => ( parseInt(d.data['Proses OTG']) + parseInt(d.data['Selesai OTG']) )
                        },
                        {
                            "data": null,
                            "render": d => d.data['Proses ODP']
                        },
                        {
                            "data": null,
                            "render": d => d.data['Selesai ODP']
                        },
                        {
                            "data": null,
                            "render": d => ( parseInt(d.data['Proses ODP']) + parseInt(d.data['Selesai ODP']) )
                        },
                        {
                            "data": null,
                            "render": d => d.data['Proses PDP']
                        },
                        {
                            "data": null,
                            "render": d => d.data['Selesai PDP']
                        },
                        {
                            "data": null,
                            "render": d => ( parseInt(d.data['Proses PDP']) + parseInt(d.data['Selesai PDP']) )
                        },
                        {
                            "data": null,
                            "render": function(d) {
                                return `<a href="${'/pasien/detail/' + d.encrypt_id}" class="btn btn-primary btn-sm"> Detail </a>`
                            }
                        }
                    ]
                })
            }

            function getPositifDataTable(tgl = null) {
                $('#positif_table').DataTable({
                    "paging": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "type": "POST",
                        "url": "/pasien/get-datatables",
                        "data": {
                            "_token": _token,
                            "tanggal": tgl === null ? null : tgl
                        }
                    },
                    "columnDefs": [ // Disable order for some columns
                        {"orderable": false, "targets": 2},
                        {"orderable": false, "targets": 3},
                        {"orderable": false, "targets": 4},
                        {"orderable": false, "targets": 5},
                        {"orderable": false, "targets": 6},
                    ],
                    "columns": [
                        {"data": "no2"},
                        {"data": "nama"},
                        {
                            "data": null,
                            "render": function(d) {
                                return `${d.data['Positif Aktif']}`
                            }
                        },
                        {
                            "data": null,
                            "render": function(d) {
                                return `${d.data['Sembuh']}`
                            }
                        },
                        {
                            "data": null,
                            "render": function(d) {
                                return `${d.data['Meninggal']}`
                            }
                        },
                        {
                            "data": null,
                            "render": function(d) {
                                return `${parseInt(d.data['Positif Aktif']) + parseInt(d.data['Meninggal']) + parseInt(d.data['Sembuh'])}`
                            }
                        },
                        {
                            "data": null,
                            "render": function(d) {
                                return `<a href="${'/pasien/detail/' + d.encrypt_id}" class="btn btn-primary btn-sm"> Detail </a>`
                            }
                        }
                    ]
                })    
            }

            // Filter tanggal
            $('#filter-tanggal').change(function() {
                tanggal = $(this).val()

                // remove existing data
                $('#positif_table').DataTable().clear()
                $('#positif_table').DataTable().destroy()
                $('#odp_table').DataTable().clear()
                $('#odp_table').DataTable().destroy()

                // Make a requests
                getPositifDataTable(tanggal)
                getOdpDataTable(tanggal)
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

            // Import data
            $('#import-excel-form').submit(function(e) {
                e.preventDefault()

                var formData = new FormData()
                formData.append('uploaded_file', $('#uploaded_file').prop('files')[0])
                formData.append('_token', $('#_token').val())

                $('#errors-display').empty()
                $('#btn-import').html('Loading...').prop('disabled', true)
                $.ajax({
                    type:'POST',
                    url: '/pasien/import',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(data) {
                        $('#btn-import').html('Import').removeAttr('disabled')
                    },
                    statusCode: {
                        400: function(resp) {
                            $('#btn-import').html('Import').removeAttr('disabled')
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
                            $('#btn-import').html('Import').removeAttr('disabled')
                            alert('Something errors on server')
                            return false
                        }
                    }
                }).done(function() {
                    $('#btn-import').html('Import').removeAttr('disabled')
                    window.location.reload()
                })
            })

            // Insert data
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