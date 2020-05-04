@extends('master')
@section('title_page', 'Pusat Informasi dan Koordinasi COVID-19 Papua Barat')
@section('content')
<div class="container mt-4">     
  <!--  -->
    <div class="alert alert-primary" role="alert">
               <h4> <p class="mb-0"><strong>Angka Kejadian Di Papua.</strong></p> </h4>
            <h4>   
                <small class="text-muted"><em> Update Terakhir {{$latest_update}} </em> </small>
            </h4>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <!-- CARD ICON -->
                    <div class="row">
                    <!-- Papua -->
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4" style="background-color:#ff6b6b; border-radius: 20px;">
                                <div class="card-body text-center"  >
                                     <h4><strong>POSITIF</strong></h4>
                                         <p class="text-primary text-16 line-height-2 m-0">Papua Barat</p>
                                    <h4><strong>{{ ($data_per_status['Positif Aktif'] - $data_per_status['Sembuh']) - $data_per_status['Meninggal'] }} Orang</strong></h4>
                                </div>
                            </div>
                        </div><!-- Papua -->
                         <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4" style="background-color:#1dd1a1; border-radius: 20px;">
                                <div class="card-body text-center"  >
                                     <h4><strong>SEMBUH</strong></h4>
                                         <p class="text-primary text-16 line-height-2 m-0">Papua Barat</p>
                                    <h4><strong>{{$data_per_status['Sembuh']}} Orang</strong></h4>
                                </div>
                            </div>
                        </div><!-- Papua -->
                         <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4" style="background-color:#feca57; border-radius: 20px;">
                                <div class="card-body text-center"  >
                                     <h4><strong>MENINGGAL</strong></h4>
                                         <p class="text-primary text-16 line-height-2 m-0">Papua Barat</p>
                                    <h4><strong>{{$data_per_status['Meninggal']}} Orang</strong></h4>
                                </div>
                            </div>
                        </div><!-- Papua -->
                         <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4" style="background-color:#1dd1a1; border-radius: 20px;">
                                <div class="card-body text-center"  >
                                     <h4><strong>ODP</strong></h4>
                                         <p class="text-primary text-16 line-height-2 m-0">Papua Barat</p>
                                    <h4><strong>
                                      @isset($data_per_status['Proses ODP'])
                                        {{$data_per_status['Proses ODP']}} Orang
                                      @endisset
                                    </strong></h4>
                                </div>
                            </div>
                        </div><!-- Papua -->
                         <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4" style="background-color:#feca57; border-radius: 20px;">
                                <div class="card-body text-center"  >
                                     <h4><strong>PDP</strong></h4>
                                         <p class="text-primary text-16 line-height-2 m-0">Papua Barat</p>
                                    <h4><strong>
                                      @isset($data_per_status['Proses PDP'])
                                      {{$data_per_status['Proses PDP']}} Orang
                                    @endisset
                                    </strong></h4>
                                </div>
                            </div>
                        </div><!-- Papua -->
                         <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4" style="background-color:#1dd1a1; border-radius: 20px;">
                                <div class="card-body text-center"  >
                                     <h4><strong>OTG</strong></h4>
                                         <p class="text-primary text-16 line-height-2 m-0">Papua Barat</p>
                                    <h4><strong>
                                      @isset($data_per_status['Proses OTG'])
                                      {{$data_per_status['Proses OTG']}} Orang
                                    @endisset
                                    </strong></h4>
                                </div>
                            </div>
                        </div><!-- Papua -->
                        
                    </div><!-- row -->
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <div class="carousel_wrap">
                                <div id="carouselExampleKeyboard" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleKeyboard" data-slide-to="0" class="active"></li>
                                        <li data-target="#carouselExampleKeyboard" data-slide-to="1"></li>
                                        <li data-target="#carouselExampleKeyboard" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        @if($slides->count() > 0)
                                        @foreach($slides as $i => $slide)
                                          @if($i == 0)
                                            <div class="carousel-item active" style="overflow: hidden;">
                                              <img class="d-block w-100" src="{{$slide->image}}" alt="{{$slide->nama}}">
                                            </div>
                                          @else
                                            <div class="carousel-item" style="overflow: hidden;">
                                              <img class="d-block w-100" src="{{$slide->image}}" alt="{{$slide->nama}}">
                                            </div>
                                          @endif
                                            
                                        @endforeach
                                      @else 
                                          <div class="carousel-item active">

                                              <img class="d-block w-100" src="{{ url('/public/images/products/cov2.jpg') }}" alt="First slide">

                                          </div>
                                          <div class="carousel-item">

                                              <img class="d-block w-100" src="{{ url('/public/images/products/cov1.jpg') }}" alt="Second slide">

                                          </div>
                                          <div class="carousel-item">

                                              <img class="d-block w-100" src="{{ url('/public/images/products/cov3.jpg') }}" alt="Third slide">

                                          </div>
                                        @endif
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleKeyboard" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleKeyboard" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
                
          <!-- TABLE NO DARURAT -->
            <div class="row">
                <div class="col-md-6">
                        <div class="card o-hidden mb-4" style="background-color:#00FA9A; border-radius: 10px">
                            <div class="card-header d-flex align-items-center">
                                <h3 class="w-50 float-left card-title m-0">Call Center</h3>
                                <blockquote class="blockquote">
                                  <p class="mb-0">Nomor Darurat</p>
                                  <footer class="blockquote-footer"><i><a href="tel:{{$no_darurat->call_center}} " class="cite"> {{$no_darurat->call_center}} </a></i><cite title="Source Title" class="cite">Nomor Darurat</cite></footer>
                                </blockquote> 
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card o-hidden mb-4"style="background-color:#00FA9A;border-radius: 10px">
                        <div class="card-header d-flex align-items-center" >
                            <h3 class="w-50 float-left card-title m-0">Diskes Papua Barat</h3>
                                 <blockquote class="blockquote">
                                    <p class="mb-0">Nomor Diskes Papua Barat</p>
                                <footer class="blockquote-footer"><i><a href="tel:{{$no_darurat->no_diskes}} " class="cite">08134567890 </a></i><cite title="Source Title" class="cite">Pertanyaan Umum</cite></footer>
                                </blockquote>           
                        </div>
                    </div>
                </div>
            </div>

        <br>
  <div class="row">
        <div class="col-md-12">
            <div class="card o-hidden mb-12">
                <div class="card-header d-flex align-items-center">
                      <h3 class="w-50 float-left card-title m-0"><b><strong>Titik Penyebaran COVID-19</strong></b></h3>
                      <div class="dropdown dropleft text-right w-50 float-right">
                          <button class="btn bg-gray-100" type="button" id="dropdownMenuButton_table1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="nav-icon i-Gear-2"></i>
                                  </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table1">
                              <a class="dropdown-item" href="#">Positif Corona</a>
                              <a class="dropdown-item" href="#">Sembuh</a>
                              <a class="dropdown-item" href="#">Meninggal</a>
                          </div>
                      </div>
               </div>
               <!-- Openlayers MAPS -->
               <div class="card-body" id="data-penyebaran">
                      <div id="map" class="map content-center"><div id="popup"></div></div>
                      <div id="markerDetail" class="d-none"></div>
                      <br>
                      <div class="w-100" style="margin:auto;">
                           <iframe id="arcgis" data-src="https://www.arcgis.com/apps/EmbedMinimal/index.html?appid=77486be2775647d29db48f56254b5e36" style="margin:auto;width:100% !important;height: 400px !important;" ></iframe>
                       </div>
               </div>
               <!-- iFrame arc -->
               
          </div>
      </div>   
    </div> <!-- endrow -->

      <div class="alert alert-succes" role="alert"></div>

              <!-- end of row -->
      <!-- Chart -->
      <div class="row">
          
        <!-- Sembuh, Positif Aktif, Meninggal Chart -->
        <div class="col-sm-12">
          <div class="card o-hidden mb-4">
            <section class="card-header d-flex align-items-center">
                <h4> <p class="mb-0"><b><strong>Grafik Perkembangan Pasien COVID-19</strong></b></p> </h4>
             </section>
             <section class="card-body row">
                <div class="col-lg-12 col-sm-12 m-4">
                    <canvas id="pasien-positif-chart"></canvas>       
                </div>  
             </section>
          </div>
          
        </div>
        
        <!-- ODP, PDP, OTG Chart -->
        <div class="col-sm-12">
          <div class="card o-hidden mb-4">
            <section class="card-header d-flex align-items-center">
                <h4> <p class="mb-0"><b><strong>Grafik Perkembangan Pasien COVID-19</strong></b></p> </h4>
             </section>
             <section class="card-body row">
                <div class="col-lg-12 col-sm-12 m-4">
                    <canvas id="pasien-odp-chart"></canvas>       
                </div>  
             </section>
          </div>
          
        </div>
        
      </div>
      <!-- End Chart -->
      <!-- Rumah Sakit dan Call Center -->
      <div class="row">
          <div class="col-md-12">
              <div class="card o-hidden mb-4" id="kontak">
                   <div class="card-header d-flex align-items-center">
                      <h4> <p class="mb-0"><b><strong>Daftar Rumah Sakit Rujukan Di Papua Barat</strong></b></p> </h4>
                   </div>
                  <div class="card-body">
                      <div class="table-responsive">

                          <table id="user_table" class="table dataTable-collapse text-justify">
                              <thead>
                                  <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Nama Rumah Sakit</th>
                                      <th scope="col">Alamat</th>
                                      <th scope="col" class="text-center">Nomor Kontak</th>
                                      <!-- <th scope="col">Status</th> -->
                                      <th scope="col">Keterangan</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($rumah_sakit as $rs)
                                  <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$rs->nama}}</td>
                                    <td>{{$rs->alamat}}</td>
                                    <td class="text-center"><a href="tel:{{$rs->no}}" class="btn  btn-sm btn-success btn-rounded">{{$rs->no}}</a></td>
                                    <td>{{$rs->ket}}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>      
          </div>
      </div> <!-- end of col-->

       <div class="alert alert-succes" role="alert">
         <h4> <p class="mb-0"><b><strong>Hubungi Call Center Kabupaten dan Kota</strong></b></p> </h4>
      </div>

          <div class="col-md-12">
              <div class="card o-hidden mb-12" id="call-center">
                  <div class="card-header d-flex align-items-center">
                      <h3 class="w-50 float-left card-title m-0">Call Center</h3>
                      <div class="dropdown dropleft text-right w-50 float-right">
                          <button class="btn bg-gray-100" type="button" id="dropdownMenuButton_table2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="nav-icon i-Gear-2"></i>
                                  </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                              <a class="dropdown-item" href="#">Add new user</a>
                              <a class="dropdown-item" href="#">View All users</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                          </div>
                      </div>

                  </div>
                  <div class="card-body">

                      <div class="table-responsive">

                          <table id="sales_table" class="table dataTable-collapse text-center">
                              <thead>
                                  <tr>
                                      <th scope="col">No</th>
                                      <th scope="col">Kab / Kota</th>
                                      <th scope="col">Call Center</th>
                                      <th scope="col">Hotline</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @php 
                                  $i = 0 
                                @endphp
                                @foreach($kontaks as $kontak)
                                  <tr>
                                    <td>{{++$i}}</td>
                                    <td align="left">{{$kontak->nama}}</td>
                                    <td><a href="tel:{{$kontak->call_center}}" class="btn btn-success btn-sm btn-rounded">{{$kontak->call_center}}</a></td>
                                    <td><a href="tel:{{$kontak->hotline}}" class="btn btn-danger btn-sm btn-rounded">{{$kontak->hotline}}</a></td>
                                  </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>

  <!-- BARU -->
          <!-- end of col-->
    </div> <!-- end of row-->


@endsection
@section('script')
@verbatim
<script type="text/javascript">
  $(document).ready(function() {
    $('#arcgis').prop('src', $('#arcgis').prop('data-src'))
    function convertDateToFriendly(date) {
      return new Date(date).toLocaleDateString()
    }
    function replaceEmptyDate(dates, data) {
      let arr = []  
      if(dates.length == data.length) {
        return data  
      }
        for(var i = 0;i < dates.length;i++) {
          data.forEach(function(item, ind) {
            if(arr.length <= dates.length) {
              if(dates[i] == item.tgl_input) {
                var duplicate = arr.find(data => data.tgl_input === dates[i] && data.jumlah > 0)
                
                if(!duplicate)
                  arr.pop()
                  arr.push(item)
              } 
              else {
                var duplicate = arr.find(data => data.tgl_input === dates[i])
                if(!duplicate)
                  arr.push({jumlah:0, tgl_input: dates[i]})
              }
            }
            else {
              return
            }
            
          })
        }

        if(arr.length < dates.length) {
          arr.unshift({jumlah:0, tgl_input:dates[0]})
        }

        return arr
        
    }

    function removeDuplicate(array, prop) {
      let newArray = []
      return array.filter((obj, pos, arr) => {
        
        var data = arr.map(mapObj => {
          return mapObj[prop]   
        }).indexOf(obj[prop])
        
        if(data !== pos) {
          arr[data].jumlah = parseInt(arr[data].jumlah)
          arr[data].jumlah += Number(arr[pos].jumlah)
        }
        return arr.map(mapObj => mapObj[prop]).indexOf(obj[prop]) === pos
      })
    }

    var labelOne = [], 
        datasetOne = [],
        data1 = {
          labels: [],
          datasets: []
        },
        data2 = {
            labels: [],
            datasets: []
        },
        ddPositif = [], ddSembuh = [], ddMeninggal = [], ddODP = [], ddPDP = [], ddOTG = []
    $.ajax({
      type: 'GET',
      url: '/home/get-data-chart',
      dataType: 'JSON',
      success: function(res) {
        data1.labels = res.tanggal
        data2.labels = res.tanggal
        // Data Sembuh
        data1.datasets.push({
          label: 'Sembuh',
          borderColor: 'rgb(46, 204, 113)',
          data:res.data.sembuh
        })

        // Data pPositif
        data1.datasets.push({
          label: 'Positif Aktif',
          borderColor: 'rgb(231, 76, 60)',
          data:res.data.aktif
        })

        // Data Meninggal
        data1.datasets.push({
          label: 'Meninggal',
          borderColor: 'rgb(45, 52, 54)',
          data:res.data.meninggal
        })

        // Data ODP
        data2.datasets.push({
          label: 'ODP',
          borderColor: 'rgb(52, 152, 219)',
          data:res.data.odp
        })

        // Data PDP
        data2.datasets.push({
          label: 'PDP',
          borderColor: 'rgb(241, 196, 15)',
          data:res.data.pdp
        })

        // Data OTG
        data2.datasets.push({
          label: 'OTG',
          borderColor: 'rgb(127, 140, 141)',
          data:res.data.otg
        })
      }
    }).done(function() {
        var ctx = $('#pasien-positif-chart').get(0).getContext('2d'),
            pasienChart = new Chart(ctx, {
              type: 'line',
              data: data1,
              options: {
                animation: {
                  duration: 0 // disable animation
                },
                devicePixelRatio: 1,
                hover: {
                  mode: 'y',
                  intersect: false,
                  axis: 'x',
                  animationDuration: 0,
                },
                scales: {
                  ticks: {
                      max: 5,
                      min: 2,
                      stepSize: 0.5,
                      sampleSize: 20
                  }
                }
              }
            })
        let odpCtx = $('#pasien-odp-chart').get(0).getContext('2d'),
            pasienOdpChart = new Chart(odpCtx, {
              type: 'line',
              data: data2,
              options: {
                animation: {
                  duration: 0 // disable animation
                },
                devicePixelRatio: 1,
                hover: {
                  mode: 'y',
                  intersect: false,
                  axis: 'x',
                  animationDuration: 0,
                },
                scales: {
                  ticks: {
                      max: 5,
                      min: 2,
                      stepSize: 0.5,
                      sampleSize: 20
                  }
                }
              }
            })
    })

    
  })
  
</script>
@endverbatim
@endsection