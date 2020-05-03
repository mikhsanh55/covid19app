@extends('admin')

@section('title_page', 'Data Pasien - Sistem Informasi Penanganan COVID-19 Papua Barat')

@section('content')
<br><br><br>
    <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="breadcrumb">
                <h1>{{$title}}</h1>
                <ul>
                    <li><a href="#">Dashboard</a></li>
                    <li>{{$title}} </li>
                </ul>
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
                                                <td>{{ ($pasien->data['Proses OTG'] - $pasien->data['Selesai OTG']) }}</td>
                                                <td>{{$pasien->data['Selesai OTG']}}</td>
                                                <td>{{ ($pasien->data['Proses OTG'] - $pasien->data['Selesai OTG']) + $pasien->data['Selesai OTG'] }}</td>

                                                <td>{{$pasien->data['Proses ODP'] - $pasien->data['Selesai ODP']}}</td>
                                                <td>{{$pasien->data['Selesai ODP']}}</td>
                                                <td>{{ ($pasien->data['Proses ODP'] - $pasien->data['Selesai ODP']) + $pasien->data['Selesai ODP'] }}</td>

                                                <td>{{$pasien->data['Proses PDP'] - $pasien->data['Selesai PDP']}}</td>
                                                <td>{{$pasien->data['Selesai PDP']}}</td>
                                                <td>{{ ($pasien->data['Proses PDP'] - $pasien->data['Selesai PDP']) + $pasien->data['Selesai PDP'] }}</td>
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
                                    <td>${item.data['Positif Aktif'] - item.data['Sembuh'] - item.data['Meninggal']}</td>
                                    
                                    <td>${item.data['Sembuh']}</td>
                                    <td>${item.data['Meninggal']}</td>
                                    <td>${item.data['Positif Aktif']}</td>
                                    <td class="btn-group w-100">
                                        <a class="btn btn-primary btn-sm" href="/pasien/detail/${item.encrypt_id}">Detail</a>
                                    </td>
                                </tr>`

                            tbodyOdp += `
                                <tr>
                                    <td>${++no2}</td>
                                    <td>${item.nama}</td>
                                    <td>${item.data['Proses OTG'] - item.data['Selesai OTG']}</td>
                                    <td>${item.data['Selesai OTG']}</td>
                                    <td>${item.data['Proses OTG']}</td>

                                    <td>${item.data['Proses ODP'] - item.data['Selesai ODP']}</td>
                                    <td>${item.data['Selesai ODP']}</td>
                                    <td>${item.data['Proses ODP']}</td>

                                    <td>${item.data['Proses PDP'] - item.data['Selesai PDP']}</td>
                                    <td>${item.data['Selesai PDP']}</td>
                                    <td>${item.data['Proses PDP']}</td>
                                    
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
        })
    </script>
@endverbatim    
@endsection