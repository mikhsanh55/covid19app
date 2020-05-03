window.onload = function() {
  var array = [],
defaultSliderData = ''  

// Call data
$.ajax({
  type: 'GET',
  url: '/home/get-coordinates',
  dataType: 'JSON',
  success: function(res) {
    if(res.status)
      var i = 0, labelStatus = '', jumlah = '', data_wilayah = []
      /*
      * NOTE: Ieu bagian paling mumet as* :'(',
      * lain dina struktur front-endna, emang urangna we lambat, mugi digancangkeun ngodingna.  
      */
      res.data.forEach(function(dt, index) {

        for(let key in dt.data) {
          // dt.data['Positif Aktif'] = (dt.data['Positif Aktif'] - dt.data['Sembuh']) - dt.data['Meninggal']
          // dt.data['Proses ODP']  = dt.data['Proses ODP'] - dt.data['Selesai ODP']
          // dt.data['Proses PDP']  = dt.data['Proses PDP'] - dt.data['Selesai PDP']
          // dt.data['Proses OTG']  = dt.data['Proses OTG'] - dt.data['Selesai OTG']
          data_wilayah.push({
            lat: dt.latitude,
            lng: dt.longitude,
            data: dt.data
          })
          }

        array.push({
          lat: dt.latitude, lng: dt.longitude, kota: dt.nama,
          data: dt.data
        })
      })
  }
}).done(function() {
  // create source for layer
  var vectorSource = new ol.source.Vector();

  var features = []
  for(var i = 0;i < array.length;i++) {
    var st = '', stLabel = '' // st == status, stLabel == color of each label
    var __coord = ol.proj.fromLonLat( [ array[i]['lng'], array[i]['lat'] ] )
    var dataHtml = `<p>Kota: ${array[i]['kota']}`
    for(var status in array[i].data) {
      dataHtml +=  `<p>${status} : ${array[i].data[status]}</p>`
    }
    var marker = new ol.Feature({
      geometry: new ol.geom.Point(
        __coord
      ),
      name: dataHtml
    })

    // Main marker
    var markerStyleObj = {
      src: base_uri + '/markers.png',
      crossOrigin: 'anonymous',
      zIndex: i,
      scale: .4
    }

    var markerStyle = new ol.style.Style({
      image: new ol.style.Icon(markerStyleObj)
    })
    marker.setStyle(markerStyle)
    vectorSource.addFeature(marker)

  }

  var vectorLayer = new ol.layer.Vector({
    source: vectorSource,
    updateWhileAnimating: true,
      updateWhileInteracting: true
  });
    

  var map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM()
        }),
        vectorLayer
      ],
      
    view: new ol.View({
      center: ol.proj.fromLonLat([132.669980, -1.290754]),
      zoom: 7
    }),
    loadTilesWhileAnimating: true,
  }); 

  var element = document.getElementById('popup')
  var popup = new ol.Overlay({
    element: element,
    positioning: 'bottom-center',
    stopEvent: false,
    offset: [0, -25]
  })
  map.addOverlay(popup)
  // display pop when marker click
  map.on('click', function(evt) {
    displayPopup(evt)
  })

  map.on('pointermove', function(evt) {
    displayPopup(evt)
  })

  function displayPopup(evt) {
    var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
      return feature
    })

    if(feature) {
      var coordinates = feature.getGeometry().getCoordinates()
      popup.setPosition(coordinates)
      $('#markerDetail').html(feature.values_.name)
      $(element).popover({
        placement: 'top',
        html: true,
        content: function() {
          return $('#markerDetail').html()
        }
      })

      $(element).popover('show')
    }
    else {
      $(element).popover('hide')
    }
  }
})  
}
