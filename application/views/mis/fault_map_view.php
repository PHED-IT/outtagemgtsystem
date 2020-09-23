  <div id="loader_submit"></div>
<div class="card">
 <div class="card-header"><h4>FAULT ON MAP VIEW </h4>
<div class="card-header-action">
   <button class="btn btn-sm btn-outline-primary justify-content-end" style="" data-target="#searchModal" data-toggle="modal"><span class="fa fa-search"></span></button>
</div>
 </div>
 <div class="card-body">
  <div class="alert alert-info" style="background-color: #ff776b">

    <marquee hspace = "20" onmouseover="this.stop();" onmouseout="this.start();"><span class="font-weight-bold">SUMMARY - </span>

      <?php
        foreach ($fault_summary as $key => $value) {
          if ($value->voltage_level=="33kv") {
              ?>
              <span><span class="fa fa-map-marker"></span> <?= $value->feeder33_name ?> 33kv * <?= $value->indicator ?>*</span>
              <?php

          } else {
            ?>
             <span><span class="fa fa-map-marker"></span> <?= $value->feeder11_name ?> 11kv * <?= $value->indicator ?>*</span>
            <?php
          }
          
          
        }
      ?>
    </marquee>
  </div>
  <button class="btn btn-outline-success" id="refresh"><span class="fa fa-refresh"></span></button>
  <h4 id="text_title"></h4>
  <p id="label_state"> <img src="http://localhost/phed_outage/assets/img/state.png" width="18" height="18"> - <span>State</span></p>
  <p id="label_station" style="display: none;"> <img src="http://localhost/phed_outage/assets/img/coil.png" width="18" height="18"> - <span>Station without affected feeders</span>  | <img src="http://localhost/phed_outage/assets/img/coild.png" width="18" height="18"> - <span>Station with affected feeders</span></p>
 
  <div id="map" style="">
 <center><div class="alert alert-info my-5"><span class="fa fa-spinner fa-spin fa-5x"></span> Loading customers coordinates...</div></center>
  </div>

</div>

        <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form id="searchForm">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Search Filter</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                    <div class="col-md-12">
                        
                        <label class="col-form-label" for="zone"> Zone</label>
                         <select class="form-control" required name="zone" id="zone_map">
                          <option value="">Choose zone</option>
                           <?php
                foreach ($zones as $key => $value) {
                  ?>
                  <option value="<?= $value->id ?>"><?= $value->name ?></option>
                  <?php
                }
               ?>
                      </select>
                        
                    </div>
                    
                </div>
                 <div class="row">
                    <div class="col-md-4">
                        
                        <label class="col-form-label" for=""> Voltage</label>
                         <select class="form-control" required name="voltage_level" id="voltage_level_map">

                         <!--  <option value="">Voltage</option> -->
                          <option value="33kv">33kv</option>
                          <option value="11kv">11kv</option>
                          
                      </select>
                        
                    </div>
                    <div class="col-md-8">
                        
                        <label class="col-form-label" required for=""> Feeder</label>
                         <select class="form-control" required name="feeder_id" id="feeder_id">
                          <option value="">Select zone first</option>
                          
                      </select>
                        
                    </div>
                    
                </div>
               <!--  <div class="row">
                    <div class="col-md-12">
                        
                        <label class="col-form-label" required for=""> Date</label>
                         <input type="text" required placeholder="Date and time fault occured" class="form-control" style="color: #333" type="text" name="outage_date" id="date_range_picker" />
                        
                    </div>
                    
                </div> -->
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-outline-success" type="submit" id="">Search</button>
            <button class="btn btn-sm btn-outline-danger" type="button" data-dismiss="modal">Cancel</button>
           
          </div>
          </form>
        </div>
      </div>
    </div>

</div>
       
<script type="text/javascript">

$(document).on('click','#refresh',function(e){
  $('#text_title').text('')
  $('#label_state').show()
  $('#label_station').hide()
  showStateMap();
})
$(document).on('submit','#searchForm',function(e){
  e.preventDefault();
  var assetType;
  var voltage_level=$('#voltage_level_map').val();

  var feeder_id=$('#feeder_id').val();
  var feeder_name=$( "#feeder_id option:selected" ).text();
  $('#text_title').text("Showing Affected Customers on "+feeder_name+" Feeder");
  $('#text_title').hide()
  if (voltage_level=="33kv") {
    assetType="FEEDER33ID";
  } else {
    assetType="FEEDER11ID";
  }
  $('#searchModal').modal('hide')
 // showMap(assetType,feeder_id) 
})


function showMap(resp,iss_faults,lat,long){
  //alert(assetid)
    
     //console.log("rec",enumx)
    var locations=[];
    if (resp.length>0) {
     // spinner.hide()
      //$('#text_title').show()
      console.log("jsom",resp)
      resp.map(function(item){
        console.log("jsddom",item.iss_coord.match("/(.*)")[1])
       
       if (item.iss_coord.match("/(.*)")[1]) {
           //console.log('d',item.iss_coord.match("/(.*)")[1])
          var card=iss_faults.some(function(iss_fault){
            console.log("ddzs",iss_fault.station_id);
            return (iss_fault.station_id == item.id);
           })
          console.log("log",card);
            if (card) {
              locations.push([item.iss_names,item.iss_coord.match("(.*)/")[1],item.iss_coord.match("/(.*)")[1],'http://localhost/phed_outage/assets/img/coild.png',item.id])
            } else {
              locations.push([item.iss_names,item.iss_coord.match("(.*)/")[1],item.iss_coord.match("/(.*)")[1],'http://localhost/phed_outage/assets/img/coil.png',item.id])
            }
            
           
          }
        
        
      })
      console.log("locx",locations)
      var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 9,
      center: new google.maps.LatLng(lat,long ),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  

      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon: locations[i][3],
        //label: "booo",
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        //var url=BASE_URL+"mis/get_fualt_feeder_by_iss";
        // $.post(url,{
        //   iss:locations[i][3]
        // },
        // function(result){
        //   console.log(result)
        // }
        // )

        return function() {
          var url=BASE_URL+"mis/get_fualt_feeder_by_iss";
          console.log(locations[i][4])
        $.post(url,{
          iss:locations[i][4]
        },
        function(result){
          var data=JSON.parse(result)
          infowindow.setContent("<b>ISS NAME:</b>"+"<span style='color:#3b5998'>"+locations[i][0]+"</span><br/><b><span style='color:red'>AFFECTED FEEDERS:</b> "+data.num+"</span>");
          infowindow.open(map, marker);
        }
        )
          
        }
      })(marker, i));
    }
    $("#map").css({"width": "100%","height":"450px"});
    }
    
  }




function showStateMap(){
  //alert(assetid)
    
     //console.log("rec",enumx)
    var locations=[
      ["Rivers State",4.74974, 6.82766,1],
      ["Bayelsa State",4.664030, 6.036987,2],
      ["Akwa Ibom State",5.0 ,7.83333,4],
      ["Cross River State",4.583331, 8.416665,3],
    ];
    
     // spinner.hide()
      //$('#text_title').show()
    
     
      console.log("locx",locations)
      var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: new google.maps.LatLng(4.8396,6.9112 ),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  

      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon: "http://localhost/phed_outage/assets/img/state.png",
         label: {
    text: locations[i][0],
    color: 'blue',
  }
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
       
        return function() {
          $('#text_title').text("Showing Stations in "+locations[i][0])
          $('#label_state').hide()
  $('#label_station').show()
           var url=BASE_URL+"mis/get_iss_by_state";
           console.log(locations[i][3])
        $.post(url,{
          state:locations[i][3]
        },
        function(result){
          
          var data=JSON.parse(result);
          console.log(data)
          showMap(data.iss,data.iss_faults,locations[i][1],locations[i][2])

        }
        )

        }
      })(marker, i));
    }
    $("#map").css({"width": "100%","height":"450px"});
    
    
  }


  $(document).ready(function(){
   showStateMap()
  })
    var locationx = [
      [ -33.890542, 151.274856],
      [ -33.923036, 151.259052],
      [ -34.028249, 151.157507],
      [-33.80010128657071, 151.28747820854187],
      [ -33.950198, 151.259302]
    ];
    console.log(locationx)

    
  </script>
   <!--  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC223rsW34u3YLJWAeFvquz-lxUL-SOUuk&callback=initMap">
    </script>   -->              
                       