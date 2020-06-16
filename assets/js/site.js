
$(document).ready(function(){

    //get menus from 
$('#choose_menu').change(function(){
    if ($(this).val()!='') {
        var url=BASE_URL+"admin/get_submenus_menu_id";
    $.ajax({
        url:url,
        type:'POST',
        data:{
            menu_id:$(this).val()
        },
        success:function(response){
            console.log(response)
            var menus=JSON.parse(response);
            $('#sub_menu').html('');
            if (menus.length>0) {
            $.each(menus,function(index,value){
                $('#sub_menu').append('<option value="'+value.id+'">'+value.name_alias+'</option>')
            })
        }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})

$('#component').change(function(){
    if ($(this).val()!='') {
        var url=BASE_URL+"tripping/get_fault_inidcators_by_id";
    $.ajax({
        url:url,
        type:'POST',
        data:{
            component_id:$(this).val()
        },
        success:function(response){
            console.log(response)
            var faults=JSON.parse(response);
            $('#fault').html('');
            if (faults.length>0) {
            $.each(faults,function(index,value){
                //$('#fault').html('<option value="">Choose component</option>')
                $('#fault').append('<option value="'+value.id+'">'+value.indicator+'</option>')
            })
        }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})
$('#iss_transformer').change(function(){
    if ($(this).val()!='') {
        var url=BASE_URL+"admin/iss_transformer";
    $.ajax({
        url:url,
        type:'POST',
        data:{
            iss_id:$(this).val()
        },
        success:function(response){
            console.log(response)
            var transformer=JSON.parse(response);
            $('#transformer').html('');
            if (transformer.length>0) {
            $.each(transformer,function(index,value){
                //$('#fault').html('<option value="">Choose component</option>')
                $('#transformer').append('<option value="'+value.id+'">'+value.names_trans+'</option>')
            })
        }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})

$('#ts_transformer').change(function(){
    if ($(this).val()!='') {
        var url=BASE_URL+"admin/ts_transformer";
    $.ajax({
        url:url,
        type:'POST',
        data:{
            ts_id:$(this).val()
        },
        success:function(response){
            console.log(response)
            var transformer=JSON.parse(response);
            $('#transformer').html('');
            if (transformer.length>0) {
            $.each(transformer,function(index,value){
                //$('#fault').html('<option value="">Choose component</option>')
                $('#transformer').append('<option value="'+value.id+'">'+value.names_trans+'</option>')
            })
        }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})

$(document).on('submit','#logForm',function(e){
    
    e.preventDefault();
    var hour=$('#hour').val();
      var selectedIndex = $("#hour").prop("selectedIndex");
    var voltage_level=$('#voltage_level').val();
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to submit",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
    if (result.value) {
    var spinner = $('#loader_submit');
    spinner.show();
    var url=BASE_URL+"input/store_log";
    var form=$(this);
    var data=form.serialize();
    $.ajax({
        type:"POST",
        url:url,
        data:data,
        success:function(response){
            console.log(response)
            var dataX=JSON.parse(response);
            spinner.hide();
            if (dataX.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: dataX.data,
                  showConfirmButton: false,
                  timer: 1500
                });
                var latest_entry="Last entry date: "+$('#captured_date').val()+" | Hour: "+hour+".00"
                $('#latest_entry').text(latest_entry);

                if (voltage_level=="33kv") {
                    $('.current').val('');
                    $('.loadmvr').val('');
                    $('.loadmw').val('');
                    if (hour!=23) {
                        $('#hour').prop("selectedIndex",selectedIndex+1);
                    }
                    
                }else{
                    //11kv 
                    $('.current').val('');
                    $('.loadmvr').val('');
                    $('.loadmw').val('');
                    $('.voltage').val('');
                    $('.pf_input').val('');
                    $('.frequency').val('');
                    $('.remarks').val('');

                   // $('#tbody').html('');
                   // $('#button-container').hide();
                }
                
           // $('#station_id').val('')
            //$('#station_type').val("")
           // $('#button-container').hide();
            //$('#latest_entry').hide();
                //$("#logForm")[0].reset()

            } else {
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: dataX.data,
                  showConfirmButton: false,
                  timer: 3500
                });
            }
            
        },
        error:function(response){
            console.log(response)
            var dataX=JSON.stringify(response);
            spinner.hide();
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: dataX,
                  showConfirmButton: false,
                  timer: 3500
                });
        }
    })
}
})
})
$(document).on('submit','#logFormNew',function(e){
    
    e.preventDefault();
    
    var voltage_level=$('#voltage_level').val();
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to submit",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
    if (result.value) {
    var spinner = $('#loader_submit');
    spinner.show();
    var url=BASE_URL+"input/store_log_new";
    var form=$(this);
    var data=form.serialize();
    $.ajax({
        type:"POST",
        url:url,
        data:data,
        success:function(response){
            console.log(response)
            var dataX=JSON.parse(response);
            spinner.hide();
            if (dataX.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: dataX.data,
                  showConfirmButton: false,
                  timer: 1500
                });
                //var latest_entry="Last entry date: "+$('#captured_date').val()+" | Hour: "+hour+".00"
                //$('#latest_entry').text(latest_entry);

                if (voltage_level=="33kv") {
                   $('.current').val('');
                    $('.loadmvr').val('');
                    $('.loadmw').val('');
                    //$('.voltage').val('');
                    //$('.pf_input').val('');
                    //$('.frequency').val('');
                   $('.remarks').val('');
                    $('.status_feeder').prop("selectedIndex",0);
                    
                }else{
                    //11kv 
                    $('.current').val('');
                    $('.loadmvr').val('');
                    $('.loadmw').val('');
                    $('.voltage').val('');
                    $('.pf_input').val('');
                    $('.frequency').val('');
                    $('.remarks').val('');

                   // $('#tbody').html('');
                   // $('#button-container').hide();
                }
                
           // $('#station_id').val('')
            //$('#station_type').val("")
           // $('#button-container').hide();
            //$('#latest_entry').hide();
                //$("#logForm")[0].reset()

            } else {
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: dataX.data,
                  showConfirmButton: false,
                  timer: 3500
                });
            }
            
        },
        error:function(response){
            console.log(response)
            var dataX=JSON.stringify(response);
            spinner.hide();
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: dataX,
                  showConfirmButton: false,
                  timer: 3500
                });
        }
    })
}
})
})
$(document).on('submit','#add_feeder',function(e){
    e.preventDefault();
    //var spinner = $('#loader_submit');
    //spinner.show();
    var url=BASE_URL+"admin/add_feeder";
    var form=$(this);
    var data=form.serialize();
    console.log(data)
    $("#add_button").prop("disabled",true)
    $("#add_button").html("Saving...")
    $.ajax({
        type:"POST",
        url:url,
        data:data,
        success:function(response){
            console.log(response)
            var dataX=JSON.parse(response);
           // spinner.hide();
           $("#add_button").prop("disabled",false)
    $("#add_button").html("Submit")
            if (dataX.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Added successfully",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('.feeder').val('');

            } else {
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: dataX.data,
                  showConfirmButton: false,
                  timer: 3500
                });
            }
            
        },
        error:function(response){
            console.log(response)
            var dataX=JSON.stringify(response);
            $("#add_button").prop("disabled",false)
    $("#add_button").html("Submit")
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Failed",
                  showConfirmButton: false,
                  timer: 3500
                });
        }
    })
})
$(document).on('submit','#add_feeder_zone',function(e){
    e.preventDefault();
    //var spinner = $('#loader_submit');
    //spinner.show();
    var url=BASE_URL+"admin/add_feeder_zone";
    var form=$(this);
    var data=form.serialize();
    console.log(data)
    $("#add_button").prop("disabled",true)
    $("#add_button").html("Saving...")
    $.ajax({
        type:"POST",
        url:url,
        data:data,
        success:function(response){
            console.log(response)
            var dataX=JSON.parse(response);
           // spinner.hide();
           $("#add_button").prop("disabled",false)
    $("#add_button").html("Submit")
            if (dataX.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Added successfully",
                  showConfirmButton: false,
                  timer: 1500
                });
                //$('.feeder').val('');

            } else {
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: dataX.data,
                  showConfirmButton: false,
                  timer: 3500
                });
            }
            
        },
        error:function(response){
            console.log(response)
            var dataX=JSON.stringify(response);
            $("#add_button").prop("disabled",false)
    $("#add_button").html("Submit")
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Failed",
                  showConfirmButton: false,
                  timer: 3500
                });
        }
    })
})

$(document).on('submit','#energyLogForm',function(e){
    e.preventDefault();
    var hour=$('#hour').val();
    var spinner = $('#loader_submit');
    spinner.show();
    var url=BASE_URL+"input/store_energy_log";
    var form=$(this);
    var data=form.serialize();
    $.ajax({
        type:"POST",
        url:url,
        data:data,
        success:function(response){
            console.log(response)
            var dataX=JSON.parse(response);
            spinner.hide();
            if (dataX.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: dataX.data,
                  showConfirmButton: false,
                  timer: 1500
                });
                var latest_entry="Last entry date: "+$('#captured_date').val()+" | Hour: "+hour+".00"
                $('#latest_entry').text(latest_entry);
                $('#tbody').html('');
            //$('#station_id').val('')
            //$('#station_type').val("")
            $('#button-container').hide();
                
                //$("#energyLogForm")[0].reset()
            } else {
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: dataX.data,
                  showConfirmButton: false,
                  timer: 3500
                });
            }
            
        },
        error:function(response){
            console.log(response)
            var dataX=JSON.stringify(response);
            spinner.hide();
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: dataX,
                  showConfirmButton: false,
                  timer: 2000
                });
        }
    })
})


//this gets all transformer for this transmission station
$('#trans_st').change(function(){
    if ($(this).val()!='') {
        var logType=$('#logType').val()
        //alert(logType)
        var url=BASE_URL+"input/get_transformer_ts";
        //$('#tbody').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>');
        //var logType=$('#logType').val();
        //alert($(this).val())
        var station_id=$(this).val();
    $.ajax({
        url:url,
        type:'POST',
        data:{
            trans_st:$(this).val()
        },
        success:function(response){
            console.log(response)
            var transformers=JSON.parse(response);
            
                if (transformers.length>0) {
                $('#tbody').html('');
            $('#station_id').val(station_id)
            $('#voltage_level').val("33kv")
            $('#button-container').hide();
           
            $('#transformer_33').html('');
            $('#feeder_name').html('');
            $('#transformer_33').append('<option value="" >All Transformers</option>');
           $('#feeder_name').append('<option value="" >All feeders</option>');
             $.each(transformers,function(index,obj){
                    //var html='<option>';
                html="<option value='"+obj.id+"'>";
                html+=obj.names_trans
                html+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#transformer_33').append(html);
            })
        }else{
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "No transformers for this transmission station",
                  showConfirmButton: false,
                  timer: 2000
                });
        }
            }
            
        ,
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})


//this gets feeders and transformer for this transmision
$('#trans_station_new').change(function(){
    if ($(this).val()!='') {
        var logType=$('#logType').val()
        //alert(logType)
        var url=BASE_URL+"input/get_feeders_by_transmission";
        $('#tbody').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>');
        //var logType=$('#logType').val();
        //alert($(this).val())
        var station_id=$(this).val();
    $.ajax({
        url:url,
        type:'POST',
        data:{
            trans_st:$(this).val()
        },
        success:function(response){
           console.log(response)
            var responseD=JSON.parse(response);
             var feeders=responseD.record[0];
             var transformers=responseD.record[1];

             console.log(transformers)

             if (transformers.length>0) {
                console.log(transformers.length)
                $('#tbody').html('');
             $.each(transformers,function(index,obj){
               
                 var firstTr="<tr>";
                firstTr+="<td>INCOMMER "+obj.transformer;
                firstTr+="<input name='feeders[]' value='"+obj.id+"' type='hidden' id='incommer' /><input type='hidden' name='isIncommer[]' class='isIncommer' id='isIncommer' /></td>";
                //firstTr+="<td>";
                firstTr+="<td><select class='status_feeder' name='status[]'>";
                 firstTr+="<option value='on'>On</option>";
                  firstTr+="<option value='EF'>EF</option>";
                firstTr+="<option value='OC'>OC</option>";
                firstTr+="<option value='IMB'>IMB</option>";
                firstTr+="<option value='LS'>LS</option>";
                firstTr+="<option value='LS'>LSG</option>";
                firstTr+="<option value='SG'>SG</option>";
                firstTr+="<option value='OUT'>OUT</option>";
                firstTr+="<option value='BF'>BF</option>";
                firstTr+="<option value='NS'>NS</option>";
                firstTr+="<option value='OFF'>OFF</option>";
                firstTr+="<option value='EMG'>EMG</option>";
                firstTr+="<option value='SS'>SS</option>";
                firstTr+="<option value='RF'>RF</option>";
                firstTr+="<option value='DCF'>DCF</option>";
                firstTr+="</select></td>";
                firstTr+="<td><input name='voltage[]' autocomplete='off' value='33' class='reading_input log_input voltage st_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='current[]' autocomplete='off' class='reading_input log_input current st_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='pf[]' autocomplete='off' value='0.8' class='pf_input log_input st_input' placeholder='0.00' /></td>";
                
               
                
                firstTr+="<td><input name='frequency[]' autocomplete='off' value='50' class='reading_input log_input st_input frequency' placeholder='0.00' /></td>";
                firstTr+="<td><input name='loadmw' autocomplete='off' class='reading_input log_input loadmw st_input' readonly placeholder='0.00' /></td>";
                 firstTr+="<td><input name='load_mvr[]' autocomplete='off' value='0.00' class='reading_input log_input loadmvr st_input' readonly  placeholder='0.00' /></td>";
                firstTr+="<td><input name='remarks[]' autocomplete='off' class='remarks' placeholder=''  /></td>";
                firstTr+="</tr>";

               
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#tbody').append(firstTr);
            })
             $('.isIncommer').val("true");
        }

            if (feeders.length>0) {
                 
            $('#station_id').val(station_id);
            $('#voltage_level').val("33kv");
            $('#button-container').hide();
                

            $.each(feeders,function(index,obj){
                
                var html=loadParameter(obj,33)
                
                
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#tbody').append(html);
            })
           
            
            //$('#incommer').val(incommer);
             $('#latest_entry').text('');
                     console.log("sdsd",responseD.last_reading)
                 latest_entry=responseD.last_reading?"Latest entry date: "+moment(responseD.last_reading.created_at).format("DD-MM-YYYY")+" | Hour: "+responseD.last_reading.hour+".00":"";
            $('#button-container').show();
            $('#latest_entry').text(latest_entry)
            
        }

        else{
            $('#tbody').html('<p class="text-danger">No feader found </p>');
        }


            }
            
        ,
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})

$('#iss_name').change(function(){
    if ($(this).val()!='') {
        //var logType=$('#logType').val()
        var url=BASE_URL+"input/get_transformer_iss";
        //$('#tbody').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>');
        
        //alert($(this).val())
        var iss_id=$(this).val();
    $.ajax({
        url:url,
        type:'POST',
        data:{
            iss_id:$(this).val()
        },
        success:function(response){
            console.log(response)
            var transformers=JSON.parse(response);
            if (transformers.length>0) {
            $('#tbody').html('');
            $('#station_id').val(iss_id)
            $('#voltage_level').val("11kv")
            $('#button-container').hide();
            $('#latest_entry').text('');
            $('#transformer_iss').html('');
            $('#feeder_name').html('');
            $('#transformer_iss').append('<option value="" >All Transformers</option>');
            $('#feeder_name').append('<option value="" >All Feeders</option>');
             $.each(transformers,function(index,obj){
                    //var html='<option>';
                html="<option value='"+obj.id+"'>";
                html+=obj.names_trans
                html+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#transformer_iss').append(html);
            })
             
        }else{
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "No transformers for this injection substation",
                  showConfirmButton: false,
                  timer: 2000
                });
        }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})

//this fetches feeder by transformer id
$('#transformer_33').change(function(){
    if ($(this).val()!='') {
        var logType=$('#logType').val()
        //alert(logType)
        var url=BASE_URL+"input/get_feeders_ts";
        $('#tbody').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>');
        $('#button-container').hide();
        //alert($(this).val())
        var incommer=$(this).val();
    $.ajax({
        url:url,
        type:'POST',
        data:{
            trans_st:$(this).val(),logType:logType
        },
        success:function(response){
            console.log(response)

            // $('#station_id').val(station_id)
            // $('#station_type').val("TS")
            var feeders1=JSON.parse(response);
            var feeders;
            var latest_entry="";
            // if (logType=="load") {
            //     $('#tbody').prepend(firstTr);
                 
            // } else {
            //     $('#tbody').prepend(energyIncomer);
            //      }
            if (logType) {
                feeders=feeders1.record;
                if (logType=="load") {
                     $('#latest_entry').text('');
                     console.log("sdsd",feeders.last_reading)
                 latest_entry=feeders1.last_reading?"Latest entry date: "+moment(feeders1.last_reading.created_at).format("DD-MM-YYYY")+" | Hour: "+feeders1.last_reading.hour+".00":"";
                } else {
                    $('#latest_entry').text('');
                    latest_entry=feeders1.last_reading?"Latest entry date: "+moment(feeders1.last_reading.created_at).format("DD-MM-YYYY")+" | Hour: "+feeders1.last_reading.hour+".00 ":""
            
                }
                
            } else {
                feeders=feeders1;
            }
            var temp = $.trim($('#feeder_temp').html());
            $('#tbody').html('');
            $('#feeder_name').html('');
            
            if (feeders.length>0) {
                //$('#incomer_div').show()
              
                var firstTr="<tr>";
                firstTr+="<td>INCOMMER";
                firstTr+="<input name='feeders[]' type='hidden' id='incommer' /><input type='hidden' name='isIncommer[]' id='isIncommer' /></td>";
                //firstTr+="<td>";
                firstTr+="<td><select class='status_feeder' name='status[]'>";
                 firstTr+="<option value='on'>On</option>";
                  firstTr+="<option value='EF'>EF</option>";
    firstTr+="<option value='OC'>OC</option>";
    firstTr+="<option value='IMB'>IMB</option>";
    firstTr+="<option value='LS'>LS</option>";
    firstTr+="<option value='LS'>LSG</option>";
    firstTr+="<option value='SG'>SG</option>";
    firstTr+="<option value='OUT'>OUT</option>";
    firstTr+="<option value='BF'>BF</option>";
    firstTr+="<option value='NS'>NS</option>";
    firstTr+="<option value='OFF'>OFF</option>";
    firstTr+="<option value='EMG'>EMG</option>";
    firstTr+="<option value='SS'>SS</option>";
    firstTr+="<option value='RF'>RF</option>";
    firstTr+="<option value='DCF'>DCF</option>";
                firstTr+="</select></td>";
                firstTr+="<td><input name='voltage[]' autocomplete='off' value='33' class='reading_input log_input voltage st_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='current[]' autocomplete='off' class=' log_input current st_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='pf[]' autocomplete='off' value='0.8' class='pf_input log_input st_input' placeholder='0.00' /></td>";
                
               
                
                firstTr+="<td><input name='frequency[]' autocomplete='off' value='50' class='reading_input log_input st_input frequency' placeholder='0.00' /></td>";
                firstTr+="<td><input name='loadmw' autocomplete='off' class='reading_input log_input loadmw st_input' readonly placeholder='0.00' /></td>";
                 firstTr+="<td><input name='load_mvr[]' autocomplete='off' value='0.00' class='reading_input log_input loadmvr st_input' readonly  placeholder='0.00' /></td>";
                firstTr+="<td><input name='remarks[]' autocomplete='off' class='remarks' placeholder=''  /></td>";
                firstTr+="</tr>";

                var energyIncomer="<tr>";
                energyIncomer+="<td>INCOMMER <input name='feeders[]' type='hidden' id='incommer' /><input type='hidden' name='isIncommer[]' id='isIncommer' /></td>";
                energyIncomer+="<td><input name='energy[]' autocomplete='off' class='reading_input' placeholder='0.00' /></td>";
                energyIncomer+="<td><input autocomplete='off' placeholder='optional' name='remarks[]' /></td>";
        
                energyIncomer+="</tr>";
                $('#feeder_name').append('<option value="" >All feeders</option>');
                if ($('#log_new').val()=="log_new") {
                     $('#feeder_name').append('<option value="'+incommer+'" >Incommer</option>');
                } 
               

            $.each(feeders,function(index,obj){
                //option
                opt="<option value='"+obj.id+"'>";
                opt+=obj.feeder_name
                opt+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#feeder_name').append(opt);
                //end
                

                var html=(logType=='load')?loadParameter(obj,33):energyParameter(obj,33)
                
                
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#tbody').append(html);
            })
            if (logType=="load") {
                $('#tbody').prepend(firstTr);
            } else {
                $('#tbody').prepend(energyIncomer);
            }
            
            $('#incommer').val(incommer);
            $('#isIncommer').val("true");
            $('#button-container').show();
            $('#latest_entry').text(latest_entry)
            
        }

        else{
            $('#tbody').html('<p class="text-danger">No feader found </p>');
        }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})


$('#transformer_iss').change(function(){
    if ($(this).val()!='') {
        var logType=$('#logType').val();
        var url=BASE_URL+"input/get_feeder_iss";
        $('#tbody').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>');
        $('#button-container').hide();
        //alert($(this).val())
        var incommer=$(this).val();
    $.ajax({
        url:url,
        type:'POST',
        data:{
            transformer_id:$(this).val(),logType:logType
        },
        success:function(response){
            console.log(response)
            var feeders1=JSON.parse(response);
            var feeders;
            var latest_entry="";
            if (logType) {
                feeders=feeders1.record;
                if (logType=="load") {
                     $('#latest_entry').text('');
                     console.log("sdsd",feeders.last_reading)
                 latest_entry=feeders1.last_reading?"Latest entry date: "+moment(feeders1.last_reading.created_at).format("DD-MM-YYYY")+" | Hour: "+feeders1.last_reading.hour+".00":"";
                } else {
                    $('#latest_entry').text('');
                    latest_entry=(feeders1.last_reading)?"Latest entry date: "+moment(feeders1.last_reading.created_at).format("DD-MM-YYYY")+" | Hour: "+feeders1.last_reading.hour+".00 ":""
            
                }
                
            } else {
                feeders=feeders1;
            }
            var temp = $.trim($('#feeder_temp').html());
            $('#tbody').html('');
           $('#feeder_name').html('');
            if (feeders.length>0) {
                var firstTr="<tr>";
                firstTr+="<td>INCOMMER";
                firstTr+="<input name='feeders[]' type='hidden' id='incommer' /><input type='hidden' name='isIncommer[]' id='isIncommer' /></td>";
                //firstTr+="<td>";

               


                firstTr+="<td><select class='status_feeder' name='status[]'>";
                 firstTr+="<option value='on'>On</option>";
               firstTr+="<option value='EF'>EF</option>";
    firstTr+="<option value='OC'>OC</option>";
    firstTr+="<option value='IMB'>IMB</option>";
    firstTr+="<option value='LS'>LS</option>";
    firstTr+="<option value='LS'>LSG</option>";
    firstTr+="<option value='SG'>SG</option>";
    firstTr+="<option value='OUT'>OUT</option>";
    firstTr+="<option value='BF'>BF</option>";
    firstTr+="<option value='NS'>NS</option>";
    firstTr+="<option value='OFF'>OFF</option>";
    firstTr+="<option value='EMG'>EMG</option>";
    firstTr+="<option value='SS'>SS</option>";
    firstTr+="<option value='RF'>RF</option>";
    firstTr+="<option value='DCF'>DCF</option>";
                firstTr+="</select></td>";
                firstTr+="<td><input name='voltage[]' autocomplete='off' class='reading_input log_input voltage st_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='current[]' autocomplete='off' class=' log_input current st_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='pf[]' autocomplete='off' class='pf_input log_input st_input' placeholder='0.00' /></td>";
                
                
                
                firstTr+="<td><input name='frequency[]' autocomplete='off' class='reading_input log_input st_input frequency' placeholder='0.00' /></td>";
                firstTr+="<td><input name='loadmw' autocomplete='off' class='reading_input log_input loadmw st_input' readonly placeholder='0.00' /></td>";
                firstTr+="<td><input name='load_mvr[]' autocomplete='off' value='0.00' class='reading_input log_input loadmvr st_input' readonly     placeholder='0.00' /></td>";
                
                firstTr+="<td><input name='remarks[]' autocomplete='off' class='remarks' placeholder=''  /></td>";
                firstTr+="</tr>";

                var energyIncomer="<tr>";
                energyIncomer+="<td>INCOMMER <input name='feeders[]' type='hidden' id='incommer' /><input type='hidden' name='isIncommer[]' id='isIncommer' /></td>";
                energyIncomer+="<td><input name='energy[]' class='reading_input' placeholder='0.00' /></td>";
                energyIncomer+="<td><input placeholder='optional' name='remarks[]' /></td>";
                energyIncomer+="</tr>";
                $('#feeder_name').append('<option value="" >All feeders</option>');
            $.each(feeders,function(index,obj){
                //populate select drop down
                opt="<option value='"+obj.id+"'>";
                opt+=obj.feeder_name
                opt+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#feeder_name').append(opt);
                //end //

                var html=(logType=='load')?loadParameter(obj,11):energyParameter(obj,11)
                
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#tbody').append(html);
            })
           if (logType=="load") {
                $('#tbody').prepend(firstTr);
            } else {
                $('#tbody').prepend(energyIncomer);
            }
            $('#incommer').val(incommer);
            $('#isIncommer').val("true");
            $('#button-container').show();
            $('#latest_entry').text(latest_entry)
        }else{
            $('#tbody').html('<p class="text-danger">No feader found </p>');
        }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})


$(document).on('blur','.reading_input',function(){
    if ($(this).val()!="") {
        var reading=parseFloat($(this).val());
    $(this).val(reading.toFixed(2));
}else{
    $(this).val("0.00");
}
    
})

// $(document).on('keydown','.reading_input', function (event) {
//      if (event.shiftKey == true) {
//                 event.preventDefault();
//             }

//             if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

//             } else {
//                 event.preventDefault();
//             }
            
//             if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
//                 event.preventDefault();

        
// });

$(document).on('change','.status_feeder',function(){

    var status=$(this).val();
   // alert(status)
    if (status!="on") {
        
         var $row = $(this).closest("tr");
         $row.find(".st_input").attr('readonly',true)

         //edit
         var $form=$(this).closest("form");
         $form.find('.reading_edit').attr('readonly',true)
         $form.find('.reading_edit').val('0.00')

        
         //$row.find("input").val("0.00");
    }else if(status=="on"){
        var $row = $(this).closest("tr");
         $row.find(".st_input").attr('readonly',false)
         $row.find(".st_input").val("");
         
         //edit
         var $form=$(this).closest("form");
         $form.find('.reading_edit').attr('readonly',false)
        // $form.find('.reading_edit').val('0.00')
         //$('#edit_reading').val('0.00')
    }
})

$(document).on('blur','.voltage', function (event){
    var voltage =$(this).val();
    if (voltage!="" && voltage!="0.00") {
        var $row = $(this).closest("tr");
    console.log($row)    // Find the row
    var current = parseFloat($row.find(".current").val()); // Find the text
    var pf_input = parseFloat($row.find(".pf_input").val()); // Find the text

    var $loadmw = $row.find(".loadmw");
    var $loadmvr = $row.find(".loadmvr");
    loadmwVal=$loadmw.val();
    
if (current!="" && (pf_input!="" && pf_input!="0.00")) {
      var compute=(Math.sqrt(3)*voltage*current*pf_input)/1000;
      var computeLMVR=Math.sqrt(3)*(Math.sqrt(1-(pf_input*pf_input)))*voltage*current;
    $loadmw.val(compute.toFixed(2))  
    $loadmvr.val(computeLMVR.toFixed(2))  
    }     // Find the text
    
    }
})

$(document).on('blur','.current', function (event){
    var current =$(this).val();
    if (current!="" && current!="0.00") {
        
        var $row = $(this).closest("tr");
    console.log($row)    // Find the row
    var voltage = parseFloat($row.find(".voltage").val()); // Find the text
    var pf_input = parseFloat($row.find(".pf_input").val()); // Find the text

    var $loadmw = $row.find(".loadmw");
    var $loadmvr = $row.find(".loadmvr");
    loadmwVal=$loadmw.val();
    
      if (voltage!="" && (pf_input!="" && pf_input!="0.00")) {
      var compute=(Math.sqrt(3)*voltage*current*pf_input)/1000;
        var computeLMVR=Math.sqrt(3)*(Math.sqrt(1-(pf_input*pf_input)))*voltage*current;
    $loadmw.val(compute.toFixed(2))  
    $loadmvr.val(computeLMVR.toFixed(2))  
    }    

     // Find the text
    
    }
})

$(document).on('blur','.pf_input', function (event) {
    if (isNaN($(this).val())) {

        event.preventDefault();
        $(this).val('')
        $(this).focus()
    }

    else if ($(this).val()!="") {

         if ($(this).val()>=0 && $(this).val()<=1 ) {

        //event.preventDefault();
        

        var reading=parseFloat($(this).val());
    $(this).val(reading.toFixed(2));

    //deduce loadmw
    var $row = $(this).closest("tr");
    console.log($row)    // Find the row
    var current = parseFloat($row.find(".current").val()); // Find the text
    var voltage = parseFloat($row.find(".voltage").val()); // Find the text
    var $loadmw = $row.find(".loadmw"); // Find the text
    var $loadmvr = $row.find(".loadmvr"); // Find the text
    var compute=(Math.sqrt(3)*voltage*current*reading)/1000;
      var computeLMVR=Math.sqrt(3)*(Math.sqrt(1-(reading*reading)))*voltage*current;
    $loadmw.val(compute.toFixed(2))
    $loadmvr.val(computeLMVR.toFixed(2))


        
    }else{
       
   iziToast.error({
    title: 'Info!',
    message: 'Power factor must be between 0 and 1',
    position: 'topRight'
  });
        $(this).val(0.00)  
    }
    }    
});


$('#show_report_click').click(function(){
  //$('#show_report_click').prop('disabled',true)
  $('#show_report_click_div').show()
})


// $('.day_picker').click(function(){
//     var year=$("#year_input").val();
//     var month=$('#month_input').val();
//     var day=$(this).text();
//     if (year=="") {
//         Swal.fire({
//           position: 'top-end',
//           type: 'error', 
//           title: 'Please choose year',
//           showConfirmButton: false,
//           timer: 1500
//         })
//     }else if(month==""){
//         Swal.fire({
//           position: 'top-end',
//           type: 'error',
//           title: 'Please choose month',
//           showConfirmButton: false,
//           timer: 1500
//         })
//     }else{
//         var url=BASE_URL+"input/get_reading_date";
        
//         $('#tbody-report').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>')
//         $.ajax({
//         url:url,
//         type:'POST',
//         data:{
//             year:year,
//             month:month,
//             day:day
//         },
//         success:function(response){
//             console.log(response)
//             $('#summary_title').show()
//             $('#show_date').html(day+" - "+month+' - '+year);
//             var record=JSON.parse(response);
//         //     $('#menu_names').html('');
//             if (record.length>0) {
//                 //var data='';
//                 $("#tbody-report").html('')
//                 // for (var i = 1; i <=24; i++) {
//                 //     data+="<th>"+i+"</th>";
//                 // }
//                 //data+="</tr></thead><tbody>";

//                 for (var td = 1; td <=24; td++) {
//                     var data="<tr>";
//                     data+="<td>"+td+":00"+"</td>";
//                     data+="<td>";
//                     if (record[td].hour==td) {
//                         data+="<span>"+record[td].reading+"</span>";
//                     }
//                     data+="</td></tr>";
//                     $("#tbody-report").append(data)
//                 }

//             }else{
//                  $('#tbody-report').html('<p>No hourly record for this date</p>')
//             }
//         },
//         error:function(error){
//             console.log(error)
//             console.log(url)
//         }
//     })
//     }
    
// });

$(document).on('submit','.update-reading',function(e){
    e.preventDefault();
    if (confirm('Do you want update this value')) {

        var url=BASE_URL+"input/update_reading";
        var form=$(this);
        var id=$(this).attr('id');
        $('#btn'+id).html("<span class='fa fa-circle-o-notch fa-spin'></span>");
        var data=form.serialize();
        $.ajax({
            type:'POST',
            url:url,
            data:data,
            
            cache:false,
            
            success:function(response){
                console.log(response)
                $('#btn'+id).html('Submit')
                var result=JSON.parse(response)
               if (result.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: result.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#btn'+id).html('Submit')
                $('#modal'+id).modal('hide')
                if (result.type=="energy") {
                    $('#data'+id).html(result.reading)
                } else {
                     if (result.feeder_status=="on" ) {
                     $('#data'+id).html(result.reading)
                } else {
                     $('#data'+id).html(result.feeder_status)
                }
                }
               
               
               } else {
                iziToast.error({
    title: 'Info!',
    message: result.message,
    position: 'topRight'
  });
                // Swal.fire({
                //   position: 'top-end',
                //   type: 'error',
                //   title: result.message,
                //   showConfirmButton: false,
                //   timer: 2500
                // });
                $('#btn'+id).html('Submit')
               }
                
            },
            error:function(error){
                console.log(error)
            }
        })
    }
})
$(document).on('click','.delete_reading',function(e){
    e.preventDefault();
    if (confirm('Do you want delete this value')) {

        var url=BASE_URL+"input/delete_reading";
       
        var id=$(this).attr('data-id');
        var type=$(this).attr('data-type');
        $('#btnn'+id).html("<span class='fa fa-circle-o-notch fa-spin'></span>");
        //var data=form.serialize();
        $.ajax({
            type:'POST',
            url:url,
            data:{reading_id:id,type:type},
            
            cache:false,
            
            success:function(response){
                console.log(response)
                //$('#btn'+id).html('Submit')
                var result=JSON.parse(response)
               if (result.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Delete is successfull",
                  showConfirmButton: false,
                  timer: 1500
                });
                
                $('#modal'+id).modal('hide')
                
                $('#data'+id).html("")
                
               
               } else {
                iziToast.error({
    title: 'Info!',
    message: result.message,
    position: 'topRight'
  });
                // Swal.fire({
                //   position: 'top-end',
                //   type: 'error',
                //   title: result.message,
                //   showConfirmButton: false,
                //   timer: 2500
                // });
                $('#btn'+id).html('Submit')
               }
                
            },
            error:function(error){
                console.log(error)
            }
        })
    }
})


$('#station_type').change(function(){
    if ($(this).val()!='') {
        var url=BASE_URL+"input/get_stations";
        $('#spinner').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>');
       
        //alert($(this).val())
        var type=$(this).val();
    $.ajax({
        url:url,
        type:'POST',
        data:{
            station_type:type
        },
        success:function(response){
            console.log(response)
            var station=JSON.parse(response);
            
            $('#station_name').html('');
            $('#spinner').html('')
            alert(type)
            if (type=="none") {
                html="<option value='none'>None</option>"
                $('#station_name').append(html);
            } else {
            if (station.length>0) {
                if (type=="TS") {
                    $.each(station,function(index,obj){
                   // var html='<option>';
                    html="<option value='"+obj.tsid+"'>";
                    html+=obj.tsname
                    html+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#station_name').append(html);
            })
                } else {
                     $.each(station,function(index,obj){
                    //var html='<option>';
                    html="<option value='"+obj.ISS_ID+"'>";
                    html+=obj.ISS
                    html+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#station_name').append(html);
            })
                }
            
            
            
        }else{
            //$('#tbody').html('<p class="text-danger">No feader for ibc '+$(this).val()+'</p>');
        }
    }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})


//remove menus or submenus
$(document).on('click','.delete_menu',function(){
    var id=$(this).attr('id');
    var type=$(this).attr('data-type');
    var role_id=$(this).attr('data-role');
    var url=BASE_URL+"admin/delete_menu";
    if (confirm('Do you want to delete menu?')) {
     $.ajax({
        url:url,
        type:'POST',
        data:{id:id,type:type,role_id:role_id},
        success:function(response){
            var data=JSON.parse(response);
            if (data.status) {
                alert("success");
                location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Cannot not delete",
                  showConfirmButton: false,
                  timer: 1500
                });
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
     })   
    }
})
//show select based on role selected
$(document).on('change','#role',function(){
    var role_id=$(this).val();
    
    if (role_id=="8") {
      //dso
      $('#iss_div').show()
      $('#33kv_div').hide()
      $('#transmission_div').hide()
      //$('#33kv_feeder').val('')
      $('#33kv_feeder').prop("selectedIndex",0);
      $('#trans_station').prop("selectedIndex",0);
    } else if(role_id=="12"){
      //feeder manager
      $('#iss_div').hide()
      $('#transmission_div').hide()
      $('#33kv_div').show()
      $('#iss').prop("selectedIndex",0);
      $('#trans_station').prop("selectedIndex",0);
    }else if(role_id=="35"){
      //transmission dso
      $('#iss_div').hide()
      $('#33kv_div').hide()
      $('#transmission_div').show()
      $('#iss').prop("selectedIndex",0);
      $('#33kv_div').prop("selectedIndex",0);
    }else{
      $('#iss_div').hide()
      $('#33kv_div').hide()
      $('#transmission_div').hide();
      $('#iss').prop("selectedIndex",0);
      $('#33kv_feeder').prop("selectedIndex",0);
      $('#trans_station').prop("selectedIndex",0);
    }
})

$('#btn-show-section').click(function(){
    $('#form-section').toggle()
})

$('.capture_type').change(function(){
    var type=$(this).val();
    switch(type){
       
        case 'ISS':
        $('.asset_name').attr('placeholder','Search ISS');
        $('.asset_name').val("");
        $('#iss_section').show();
        $('.fault-section').hide();
        break;
        case 'feeder_11':
        $('.asset_name').attr('placeholder','Search FEEDER 11 KV');
        $('.asset_name').val("");
        $('#iss_section').hide();
        $('.fault-section').show();
        break;
        case 'feeder_33':
        $('.asset_name').attr('placeholder','Search FEEDER 33 KV');
        $('.asset_name').val("");
        $('#iss_section').hide();
        $('.fault-section').show();
        break;
        case 'dtr':
        $('.asset_name').attr('placeholder','Search DTR');
        $('.asset_name').val("");
        break;
        default:
        $('.asset_name').attr('placeholder','Search ISS');
        $('.asset_name').val("");
        break;
    }
    // var url=BASE_URL+"tripping/get_asset_type";
    // $('#spinner').html('<center><span class="fa fa-circle-o-notch fa-spin fa-2x text-success"></span></center>');
       
    // $.ajax({
    //     url:url,
    //     type:'POST',
    //     data:{type:type},
    //     success:function(response){
    //         console.log(response)
    //         var station=JSON.parse(response);
    //         $('#asset_select').html('')
    //         $('#asset_select').append("<option value='all'>All "+type+"</option>");
    //         $('#spinner').html('')
    //         if (station.length>0) {
    //             //html="";
    //            //html+="<option value='all'>All "+type+"</option>"
    //             $.each(station,function(index,obj){
    //                 //var html='<option>';
    //             html="<option value='"+obj.name+"'>";
    //             html+=obj.name
    //             html+="</option>";
                    
    //             //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
    //             $('#asset_select').append(html);
    //         })
    //     }else{
    //         //$('#tbody').html('<p class="text-danger">No feader for ibc '+$(this).val()+'</p>');
    //     }
    //     },
    // error:function(error){
    //     console.log(error)
    // }
    // })
})

$('#date_type').change(function(){
    var type=$(this).val();
    switch(type){
       
        case 'day':
        $('#label_date').text('Choose day');
        //$('#date_picker').removeClass('date_picker');
        $('#date_picker').val('');
        $('#date_picker').attr("required",false);
        $('#date_picker').hide();
        $('#captured_date').show();
        $('#captured_date').attr("placeholder","Choose day");
        
        $('#captured_date').attr("required",true);
        break;
        case 'month':
         $('#label_date').text('Choose month');
        //$('#date_picker').addClass('date_picker');
        $('#date_picker').show();
        $('#date_picker').attr("required",true);
        $('#date_picker').attr("placeholder","Choose month");
        $('#date_picker').attr("required",false);
        $('#captured_date').val('');

        $('#captured_date').hide();
        break;
        case 'year':

        break;
       
        break;
        default:
        $('.asset_name').attr('placeholder','Search ISS');
        $('.asset_name').val("");
        break;
    }
    // var url=BASE_URL+"tripping/get_asset_type";
    // $('#spinner').html('<center><span class="fa fa-circle-o-notch fa-spin fa-2x text-success"></span></center>');
       
    // $.ajax({
    //     url:url,
    //     type:'POST',
    //     data:{type:type},
    //     success:function(response){
    //         console.log(response)
    //         var station=JSON.parse(response);
    //         $('#asset_select').html('')
    //         $('#asset_select').append("<option value='all'>All "+type+"</option>");
    //         $('#spinner').html('')
    //         if (station.length>0) {
    //             //html="";
    //            //html+="<option value='all'>All "+type+"</option>"
    //             $.each(station,function(index,obj){
    //                 //var html='<option>';
    //             html="<option value='"+obj.name+"'>";
    //             html+=obj.name
    //             html+="</option>";
                    
    //             //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
    //             $('#asset_select').append(html);
    //         })
    //     }else{
    //         //$('#tbody').html('<p class="text-danger">No feader for ibc '+$(this).val()+'</p>');
    //     }
    //     },
    // error:function(error){
    //     console.log(error)
    // }
    // })
})


$('.asset_name').autocomplete({
    appendTo : $('#faultModal'),
    // 'minLength':0,
    // 'search':function(event,ui){
    //     var newUrl=BASE_URL+"tripping/auto_complete?type="+$("input[name='type']:checked").val();
    //     $(this).autocomplete("option","source",newUrl)
    // },
     source: function( request, response ) {
        console.log("request",request.term);
   // Fetch data
   var url=BASE_URL+"tripping/auto_complete";
   $.ajax({
    url: url,
    type: 'post',
    dataType: "json",
    data: {
     term: request.term,
     type:$("input[name='asset_type']:checked").val()
    },
    success: function( data ) {
        console.log("res",data)
     response( data );
    }
    
   });
  },
  select: function (event, ui) {
        console.log("record",ui)
   // Set selection
      $('.asset_name').val(ui.item.label); // display the selected text
     $('#asset_id').val(ui.item.id); // save selected id to input
       return false;
    }
});


// $('.feeder_type_log').change(function(){
//     var type=$(this).val();
    
//     if (type=="TS") {

//         $('.iss_log_div').hide()
        
//         $('.ts_div_log').show()
//         $('#tbody').html('')
//         $('#button-container').hide();
//     } else {
//         $('.iss_log_div').show()
//         $('.ts_div_log').hide()
//         $('#tbody').html('')
//         $('#button-container').hide();
//     }
// })

//acknowledge plan outage tsm
$(document).on('click','.acknowled_plan_out_tsm',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"planned/acknowled_plan_out_tsm";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to approve this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Outage request approved! ",
                  showConfirmButton: false,
                  timer: 2500
                });
                 $('#modal'+id).modal('hide')
                $('#d'+id).hide()
               
                $('#text'+id).text('Waiting HSO approval')
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
     })   
    }
    })
})
//acknowledge plan outage cd
$(document).on('click','.approve_plan_out_cd',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"planned/approve_plan_out_cd";
    
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to approve this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Outage request approved! ",
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#d'+id).hide()
                $('#ms'+id).hide()
                $('#text'+id).text("Waiting HSO approval")
                $('#modal'+id).modal('hide')
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
     })   
    }
    })
})
//acknowledge plan outage ht supervisor
$(document).on('click','.acknowled_plan_out_ht_supervisor',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"planned/acknowled_plan_out_ht_supervisor";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to acknowledge this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Acknowledgement successfull",
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#d'+id).hide()
                $('#text'+id).text('Waiting HT Coordnitor acknowledgement...')
                $('#modal'+id).modal('hide')
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
     })   
    }
    })
})
//acknowledge plan outage ht coordinator
$(document).on('click','.acknowled_plan_out_ht_coordinator',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"planned/acknowled_plan_out_ht_coordinator";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to acknowledge this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Acknowledgement successfull",
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#text'+id).text('Waiting Central dispatch approval...')
                $('#'+id).hide()
                $('#modal'+id).modal('hide')
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
     })   
    }
    })
})
//acknowledge plan outage tsm
$(document).on('click','.acknowled_plan_out_cd',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"planned/acknowled_plan_out_cd";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to acknowledge this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Acknowledgement is successfull... Notification is sent to HSO",
                  showConfirmButton: false,
                  timer: 2000
                });
                $('#'+id).hide()
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error occured!",
                  showConfirmButton: false,
                  timer: 1500
                });
        }
     })   
    }
    })
})
//acknowledge fault response tso
$(document).on('submit','.acknowled_fault_resp_dso',function(e){
    e.preventDefault()
    var id=$(this).attr('id');
    //var type_resp=$(this).attr('data-type');
    
    var url=BASE_URL+"FaultResponse/acknowled_fault_resp_dso";
    // if (!$('#one').is(":checked")) {
    //     Swal.fire({
    //       position: 'top-end',
    //       type: 'error',
    //       title: "Tick all boxes!",
    //       showConfirmButton: false,
    //       timer: 1500
    //     });
    //     return;
    // }
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to continue",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#submit'+id).attr('disabled',true)
        $('#submit'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
     $.ajax({
        url:url,
        type:'POST',
        data:new FormData(this),  
         contentType: false,  
         cache: false,  
         processData:false,  
        
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Successfull... ",
                  showConfirmButton: false,
                  timer: 2000
                });
                //$('#'+id).hide()
                $('#btn'+id).hide()
                $('#text'+id).text('Waiting Coordinitor acknowledgement and BOQ')
                $('#modal'+id).modal('hide')
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#submit'+id).attr('disabled',false)
                $('#submit'+id).html('Upload')
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error occured!",
                  showConfirmButton: false,
                  timer: 1500
                });
           $('#submit'+id).attr('disabled',false)
                $('#submit'+id).html('Upload')
        }
     })   
    }
    })
})
//acknowledge fault response dso
$(document).on('clicks','.acknowled_fault_resp_dso',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"FaultResponse/acknowled_fault_resp_dso";
    if (!$('#one').is(":checked")) {
        Swal.fire({
          position: 'top-end',
          type: 'error',
          title: "Tick  box!",
          showConfirmButton: false,
          timer: 1500
        });
        return;
    }
    Swal.fire({
  title: 'Are you sure?',
  text: "Please make sure feeder is open and grounded",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Acknowledgement is successfull... ",
                  showConfirmButton: false,
                  timer: 2000
                });
                $('#'+id).hide()
                $('#div'+id).hide()
                $('#ms'+id).hide()
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#'+id).attr('disabled',false)
                $('#'+id).html('click')
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error occured!",
                  showConfirmButton: false,
                  timer: 1500
                });
            $('#'+id).attr('disabled',false)
            $('#'+id).html('click')
        }
     })   
    }
    })
})
//acknowledge fault response lines man
$(document).on('click','.acknowled_fault_resp_lines',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"FaultResponse/acknowled_fault_resp_linesman";
    if (!$('#one').is(":checked")||!$('#two').is(":checked")||!$('#three').is(":checked")||!$('#four').is(":checked")) {
        Swal.fire({
          position: 'top-end',
          type: 'error',
          title: "Tick all boxes!",
          showConfirmButton: false,
          timer: 1500
        });
        return;
    }
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to acknowledge",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Acknowledgement is successfull... Please prepare Bill of Quantity",
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#'+id).hide();
                
                location.assign(BASE_URL+'FaultResponse/prepare_boq/'+id);
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#'+id).attr('disabled',false)
                $('#'+id).html('click')
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error occured!",
                  showConfirmButton: false,
                  timer: 1500
                });
            $('#'+id).attr('disabled',false)
            $('#'+id).html('click')
        }
     })   
    }
    })
})
//acknowledge fault response agm nm
$(document).on('click','.acknowle_boq_agm',function(){
    var id=$(this).attr('id');
    var url=BASE_URL+"FaultResponse/acknowle_boq_agm";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to approve BOQ",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing... Processing...' )
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "BOQ is approved successfull...Notification sent to store manager",
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#'+id).hide();
                location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 2000
                });
                $('#'+id).attr('disabled',false)
                $('#'+id).html('click')
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error occured!",
                  showConfirmButton: false,
                  timer: 1500
                });
            $('#'+id).attr('disabled',false)
            $('#'+id).html('click')
        }
     })   
    }
    })
})
//approveal GM TEchinical fault response gm
$(document).on('click','.approve_boq_gm',function(){
    var id=$(this).attr('id');
    var url=BASE_URL+"FaultResponse/approve_boq_gm";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to approve BOQ",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Approval is successfull...",
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#'+id).hide();
                $('#modal'+id).modal('hide')
                $('#text'+id).text("Approved...waiting work completion")
                //location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 2000
                });
                $('#'+id).attr('disabled',false)
                $('#'+id).html('click')
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
            Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error occured!",
                  showConfirmButton: false,
                  timer: 1500
                });
            $('#'+id).attr('disabled',false)
            $('#'+id).html('click')
        }
     })   
    }
    })
})

//approval plan outage hibc
$(document).on('click','.action_plan_out_hibc',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"planned/approve_plan_out_hibc";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to approve this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#div'+id).hide()
                $('#modal'+id).modal('hide')
                // $('#d'+id).hide()
               
                $('#text'+id).text('Waiting Network manager approval')
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
     })   
    }
    })
})
//approval plan outage hso
$(document).on('click','.approve_plan_out_hso',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"planned/approve_plan_out_hso";
   
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to approve this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Approval is successfull...",
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#div'+id).hide()
                //$('#ms'+id).hide()
                $('#text'+id).text("Waiting to start")
                $('#modal'+id).modal('hide')
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
     })   
    }
    })
})
//approval plan outage hso
$(document).on('click','.approve_plan_out_tso',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"planned/approve_plan_out_tso";
    if(!$('#two').is(":checked")||!$('#three').is(":checked")) {
        Swal.fire({
          position: 'top-end',
          type: 'error',
          title: "Check all boxes!",
          showConfirmButton: false,
          timer: 1500
        });
        return;
    }
    if ($('#ptw_number').val()=="") {
        Swal.fire({
          position: 'top-end',
          type: 'error',
          title: "PTW number must be entered",
          showConfirmButton: false,
          timer: 1500
        });
        return;
    }
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to continue",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#'+id).attr('disabled',true)
        $('#'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id,ptw_number:$('#ptw_number').val()},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Success!",
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#div'+id).hide()
                $('#modal'+id).modal('hide')
                $('#text'+id).text('Outage started')
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
     })   
    }
    })
})
//approval plan outage hso
$(document).on('click','.acknowled_fault_resp_closure',function(){
    var id=$(this).attr('data-id');
    
    var url=BASE_URL+"FaultResponse/acknowled_fault_resp_closure";
   
  
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to continue",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#bt'+id).attr('disabled',true)
        $('#bt'+id).html('<span class="fa fa-spinner fa-pulse"></span> Submitting...')
     $.ajax({
        url:url,
        type:'POST',
        data:{outage_id:id},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Success! Request closed successfully",
                  showConfirmButton: false,
                  timer: 2500
                });
                //$('#div'+id).hide()
                $('#modal'+id).modal('hide')
                $('#text'+id).text('Request closed successfully')
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#bt'+id).attr('disabled',false)
        $('#bt'+id).html('confirm')
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
             $('#bt'+id).attr('disabled',false)
        $('#bt'+id).html('confirm')
        }
     })   
    }
    })
})
//confirm date and time central dispatch
$(document).on('submit','.cd_approve_date_plan_out',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"planned/cd_approve_date_plan_out";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to approve this outage date and time",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                $('#modal'+id).modal('hide')
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Approval is sucessful!",
                  showConfirmButton: false,
                  timer: 1500
                });
                 $('#div'+id).hide();
               // location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})//confirm date and time central dispatch
$(document).on('submit','#faultReponseForm',function(e){
    e.preventDefault();
    //var id=$(this).attr('data-id');
    //e.preventDefault()
    var url=BASE_URL+"FaultResponse/store_fault_response_request";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to continue",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
        var spinner = $('#loader_submit');
    spinner.show();

        // $('#sub'+id).attr('disabled',true)
        // $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
        var form=$(this);
    var data=form.serialize();
    console.log(data)
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                //$('#modal'+id).modal('hide')
                if (data.assetId!="") {
                $.post("http://10.10.25.31:8084/nomsapiwslim/v1/getCustomersPhoneByAssets",
  {
    assetid: data.assetId,
    assettype:data.assetType,

  },
  function(resp, status){
    console.log("rec",resp)
    $.post(BASE_URL+"FaultResponse/store_customers_contact",
      { records : JSON.stringify(resp) ,outage_id:JSON.stringify(data.outage_id)},
      function(result,status){
        spinner.hide();
         alert("Success! Your fault id is: "+data.outage_id);
                  $("#faultReponseForm")[0].reset()
      }
      )
  });
            }else{
              spinner.hide();
              alert("Success! Your fault id is: "+data.outage_id);
                  $("#faultReponseForm")[0].reset()
            }
               
  //                 iziToast.success({
  //   title: 'Success!',
  //   message: 'Request is successfull',
  //   position: 'topRight'
  // });
                  
                  //window.history.back();
                 //$('#div'+id).hide();
               // location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                // $('#sub'+id).attr('disabled',false)
                // $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            spinner.hide();
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})

$(document).on('submit','#transmissionFaultEntry',function(e){
    e.preventDefault();
    //var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"FaultResponse/transmission_fault_entry";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to continue",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
        var spinner = $('#loader_submit');
    spinner.show();

        // $('#sub'+id).attr('disabled',true)
        // $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            spinner.hide();
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                //$('#modal'+id).modal('hide')
               
                  iziToast.success({
    title: 'Success!',
    message: 'Request is successfull',
    position: 'topRight'
  });
                  alert("Success! Your outage id is: "+data.outage_id);
                 $("#transmissionFaultEntry")[0].reset()
                 //$('#div'+id).hide();
               // location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                // $('#sub'+id).attr('disabled',false)
                // $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            spinner.hide();
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})
$(document).on('submit','#planSubmitForm',function(e){
    e.preventDefault();
    //var id=$(this).attr('data-id');
   
    var url=BASE_URL+"planned/store_plan_outage_request";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to continue",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
        var spinner = $('#loader_submit');
    spinner.show();

        // $('#sub'+id).attr('disabled',true)
        // $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            spinner.hide();
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                //$('#modal'+id).modal('hide')
               
                  iziToast.success({
    title: 'Success!',
    message: 'Request is successfull',
    position: 'topRight'
  });
                  alert("Success! Your outage id is: "+data.outage_id);
                  window.history.back();
                 //$('#div'+id).hide();
               // location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                // $('#sub'+id).attr('disabled',false)
                // $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            spinner.hide();
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})
//confirm work is done plan outage
$(document).on('submit','.confirm_work_done_plan',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"planned/confirm_work_done_plan";
    Swal.fire({
  title: 'Are you sure?',
  text: "Work is complete",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                $('#modal'+id).modal('hide')
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Sucess...Report submitted!",
                  showConfirmButton: false,
                  timer: 1500
                });
                 $('#div'+id).hide();
               // location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})
//rejection plan outage hibc
$(document).on('submit','.hibc_reject_plan_out',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"planned/hibc_reject_plan_out";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to reject this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                $('#reject'+id).modal('hide')
                $('#d'+id).hide()
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Rejection is sucessful!",
                  showConfirmButton: false,
                  timer: 2000
                });
                location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})
//rejection plan outage dso
$(document).on('submit','.reject_plan_out_dso',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"planned/reject_plan_out_dso";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to reject this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                $('#reject'+id).modal('hide')
                $('#d'+id).hide()
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Rejection is sucessful!",
                  showConfirmButton: false,
                  timer: 2000
                });
                location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})
//rejection plan outage hibc
$(document).on('submit','.cd_reject_plan_out',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"planned/cd_reject_plan_out";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to reject this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                $('#reject'+id).modal('hide')
                $('#d'+id).hide()
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Rejection is sucessful!",
                  showConfirmButton: false,
                  timer: 1500
                });
                location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})
//rejection plan outage hibc
$(document).on('submit','.hso_reject_plan_out',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"planned/hso_reject_plan_out";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to reject this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                $('#modal'+id).modal('hide')
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Rejection is sucessful!",
                  showConfirmButton: false,
                  timer: 1500
                });
                location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})
//rejection plan outage tsm
$(document).on('submit','.tsm_reject_plan_out',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"planned/tsm_reject_plan_out";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to reject this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                $('#modal'+id).modal('hide')
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Rejection is sucessful!",
                  showConfirmButton: false,
                  timer: 1500
                });
                location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})
//submit report supervisor lines man
$(document).on('submit','.submit_report_lines_man',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"FaultResponse/submit_report_lines_man";
    Swal.fire({
  title: 'Are you sure?',
  text: "By Submiting this you acknowledge that work is complete and all documents has been returned",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span> Submiting...')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                $('#modal'+id).modal('hide')
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Submitted sucessful!",
                  showConfirmButton: false,
                  timer: 1500
                });
                location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})
var allowSubmit = false;
$(document).on('submit','#showLoadReportForm',function(e){
 
  if (!allowSubmit) {
  if ($('#feeder_name').val()=="") {
    if($('#date_type').val()=="month"){
      iziToast.error({
    title: 'Info!',
    message: 'Please choose daily to show this report',
    position: 'topRight'
  });
       e.preventDefault();
    }else{
        allowSubmit = true;
//$('#showLoadReportForm').submit();
    }
  }else{
     allowSubmit = true;
    //$('#showLoadReportForm').submit();

  }
}
})
//rejection plan outage TSO
$(document).on('submit','.tso_reject_plan_out',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"planned/tso_reject_plan_out";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to reject this request",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span> Processing...')
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            if (data.status) {
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Rejection is sucessfull!",
                  showConfirmButton: false,
                  timer: 1000
                });
                location.reload();
            }else{
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
            }
        },
        error:function(error){
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#sub'+id).attr('disabled',false)
                $('#sub'+id).html("Submit")
        }
     })   
    }
    })
})


$('.report_type').change(function(){
  $('#show_report_click').prop('disabled',false)
  if ($('.report_type option:selected').val()=="coincidental") {
        $('.ts_div_log').show();
    } else {
        $('.ts_div_log').hide();
    }
})


$('#feeder_name').change(function(){
    var url=BASE_URL+"input/getLatestFeederReading";
    //alert($('#feeder_name option:selected').text())
    if ($('#feeder_name option:selected').text()=="Incommer") {
        $('#isIncommer').val('true');
    } else {
        $('#isIncommer').val('false');
    }

$.ajax({
        url:url,
        type:'POST',
        data:{
            feeder_id:$(this).val()
        },
        success:function(response){
            console.log(response)

            // $('#station_id').val(station_id)
            // $('#station_type').val("TS")
            var last_reading=JSON.parse(response);
           
            var latest_entry="";
                
                     $('#latest_entry').text('');
                    
                 latest_entry=last_reading?"Latest entry date: "+moment(last_reading.created_at).format("DD-MM-YYYY")+" | Hour: "+last_reading.hour+".00":"";
                $('#latest_entry').text(latest_entry)
             }
         })

})

$('.feeder_type_log').change(function(){
    var type=$(this).val();
    
    var url=BASE_URL+"mis/get_station_type";
    $('#spinner').html('<center><span class="fa fa-circle-o-notch fa-spin fa-2x text-success"></span></center>');
       $('#latest_entry').text('')
    $.ajax({
        url:url,
        type:'POST',
        data:{type:type},
        success:function(response){
            console.log(response)
            var station=JSON.parse(response);
            $('#feeder_name').html('')
            //$('#feeder_name').append("<option value='all'>All "+type+"</option>");
            $('#spinner').html('')
            if (station.length>0) {


                if (type=="TS") {

                    $('.iss_log_div').hide()
                    
                    $('.ts_div_log').show()
                    $('#tbody').html('')
                    $('#button-container').hide();
                     $('#trans_st').html('');
                     $('#trans_st').prepend('<option value="">Select</option>');
                    $.each(station,function(index,obj){
                    //var html='<option>';
                html="<option value='"+obj.id+"'>";
                html+=obj.tsname
                html+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#trans_st').append(html);
            })
                } else {
                    $('.iss_log_div').show()
                    $('.ts_div_log').hide()
                    $('#tbody').html('')
                    $('#button-container').hide();
                    $('#iss_name').html('')
                    $('#iss_name').prepend('<option value="">Select</option>');
                    $.each(station,function(index,obj){
                    //var html='<option>';
                html="<option value='"+obj.id+"'>";
                html+=obj.iss_names
                html+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#iss_name').append(html);
            })
                }
                //html="";
               //html+="<option value='all'>All "+type+"</option>"
                
        }else{
            //$('#tbody').html('<p class="text-danger">No feader for ibc '+$(this).val()+'</p>');
        }
        },
    error:function(error){
        console.log(error)
    }
    })
})

$('#zone_map').change(function(){
    var zone_id=$(this).val();
    
    var url=BASE_URL+"mis/get_feeders_by_zone_voltage";
    
    $.ajax({
        url:url,
        type:'POST',
        data:{zone_id:zone_id,voltage_level:$('#voltage_level_map').val()},
        success:function(response){
            console.log(response)
            var station=JSON.parse(response);
           // $('#feeder_id').html('')
            //$('#feeder_name').append("<option value='all'>All "+type+"</option>");
            //$('#spinner').html('')
            if (station.length>0) {

              $('#feeder_id').html('');
                    // $('#feeder_id').prepend('<option value="">Select</option>');
                    $.each(station,function(index,obj){
                    //var html='<option>';
                html="<option value='"+obj.enum_id+"'>";
                html+=obj.feeder_name
                html+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#feeder_id').append(html);
                //html="";
               //html+="<option value='all'>All "+type+"</option>"
       
        })
      }else{
        iziToast.error({
    title: 'Info!',
    message: "No "+$('#voltage_level_map').val()+" feeder on fault in this zone",
    position: 'topRight'
  });
      }
    },
    error:function(error){
        console.log(error)
    }
    })
})
  
$('#voltage_level_map').change(function(){
    var zone_id=$('#zone_map').val();
    var voltage_level=$(this).val();
    
    var url=BASE_URL+"mis/get_feeders_by_zone_voltage";
    
    $.ajax({
        url:url,
        type:'POST',
        data:{zone_id:zone_id,voltage_level:voltage_level},
        success:function(response){
            console.log(response)
            var station=JSON.parse(response);
            $('#feeder_id').html('')
            //$('#feeder_name').append("<option value='all'>All "+type+"</option>");
            //$('#spinner').html('')
            if (station.length>0) {

              $('#feeder_id').html('');
                    // $('#feeder_id').prepend('<option value="">Select</option>');
                    $.each(station,function(index,obj){
                    //var html='<option>';
                html="<option value='"+obj.enum_id+"'>";
                html+=obj.feeder_name
                html+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#feeder_id').append(html);
                //html="";
               //html+="<option value='all'>All "+type+"</option>"
       
        })
      }else{
        iziToast.error({
    title: 'Info!',
    message: "No "+voltage_level+" feeder on fault in this zone",
    position: 'topRight'
  });
      }
    },
    error:function(error){
        console.log(error)
    }
    })
})
  



 var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 5 ?
                        data.replace( /[$,]/g, '' ) :
                        data;
                }
            }
        }
    };
$('#add_component').click(function(){
                       
    var div='<br/><div class="row"><div class="col-12">';
    
    div+='<input type="text" class="form-control feeder" name="feeder[]">';
    
    div+='</div></div>'
        $('#container_div').append(div);
});


$('#myTable').DataTable({
    dom: 'Bfrtip',
    "pageLength": 25,
    buttons: [
          {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
           
    ]
});
$('#activity_tablesa').DataTable({
  "order": [[ 0, "desc" ]],
    dom: 'Bfrtip',
    "pageLength": 25,
    buttons: [
          {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
           
    ]
});

$('#simpleTable').DataTable();
$('#simpleTable1').DataTable({
        "order": [[ 6, "desc" ]],
         dom: 'Bfrtip',
        buttons: [
               {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
           
        ]
    } );


$('#simpleTable2').DataTable({
        "order": [[ 4, "desc" ]],
         dom: 'Bfrtip',
        buttons: [
               {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
           
        ]
    } );
$('#simpleTable_fualt').DataTable({
        "order": [[ 3, "desc" ]],
         dom: 'Bfrtip',
        buttons: [
               {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
           
        ]
    } );
$('#simpleTable_fualt2').DataTable({
        "order": [[ 3, "desc" ]],
         dom: 'Bfrtip',
        buttons: [
               {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
           
        ]
    } );

// console.log(moment("10-04-2020","YYYY-MM-DD").format("YYYY-MM-DD"))

  $('#date_range_picker').daterangepicker();
  $('#datetime_range_picker').daterangepicker({
    timePicker: true,
    locale: {
      format: 'YYYY-MM-DD H:mm:ss'
    }
  });
  // $('#date_range_picker').on('apply.daterangepicker',function(ev,picker){
  //   console.log(picker.startDate.format('YYYY-MM-DD'));
  // console.log(picker.endDate.format('YYYY-MM-DD'));
  // })
//DoubleScroll(document.getElementById('doublescroll'));
flatpickr('#captured_date_time',{
   enableTime:true,
  enableSeconds:true,
});
flatpickr('#captured_date',{
  enableTime:false,
  enableSeconds:false,
  
});

flatpickr('#captured_time',{
 
  enableTime:true,
  enableSeconds:true,
  noCalendar: true,
  
});
 $('.multiple-selector').select2();

 $('.date_picker').MonthPicker({Button:false});
 $('[data-toggle="tooltip"]').tooltip();
})

function DoubleScroll(element) {
    var scrollbar = document.createElement('div');
    scrollbar.appendChild(document.createElement('div'));
    scrollbar.style.overflow = 'auto';
    scrollbar.style.overflowY = 'hidden';
    scrollbar.firstChild.style.width = element.scrollWidth+'px';
    scrollbar.firstChild.style.paddingTop = '1px';
    scrollbar.firstChild.appendChild(document.createTextNode('\xA0'));
    scrollbar.onscroll = function() {
        element.scrollLeft = scrollbar.scrollLeft;
    };
    element.onscroll = function() {
        scrollbar.scrollLeft = element.scrollLeft;
    };
    element.parentNode.insertBefore(scrollbar, element);
}

//  function handleAllocate(id){
//   var form=document.getElementById('allocateForm');
//   $('#allocateModal').modal('show');
//   //console.log(form.elements[1].value)
// }
function loadParameter(obj,type){
    console.log('ll',type)
    //var name=(type==33)?obj.feeder_name:obj.feeder_name;
    var html='<tr>';
    html+="<td>"+obj.feeder_name;
    html+="<input type='hidden' value='"+obj.id+"' placeholder='0.00' name='feeders[]'/></td>"
   // html+="<td><input name='INCOMMER[]' class='reading_input' placeholder='0.00' class='form-control' /></td>";
    //html+="<td><input name='readings[]' class='reading_input' placeholder='0.00'  /></td>";


    html+="<td><select class='status_feeder' name='status[]'>";
    html+="<option value='on'>On</option>";
    html+="<option value='EF'>EF</option>";
    html+="<option value='OC'>OC</option>";
    html+="<option value='IMB'>IMB</option>";
    html+="<option value='LS'>LS</option>";
    html+="<option value='LS'>LSG</option>";
    html+="<option value='SG'>SG</option>";
    html+="<option value='OUT'>OUT</option>";
    html+="<option value='BF'>BF</option>";
    html+="<option value='NS'>NS</option>";
    html+="<option value='OFF'>OFF</option>";
    html+="<option value='EMG'>EMG</option>";
    html+="<option value='SS'>SS</option>";
    html+="<option value='RF'>RF</option>";
    html+="<option value='DCF'>DCF</option>";
    
    html+="</select></td>";
    if(type==33){
         html+="<td><input name='voltage[]' autocomplete='off' value='33' class='reading_input log_input voltage st_input' placeholder='0.00'  /></td>";
    html+="<td><input name='current[]' autocomplete='off' class=' log_input current st_input' placeholder='0.00'  /></td>";
    html+="<td><input name='pf[]' autocomplete='off' class='pf_input log_input st_input' value='0.8' placeholder='0.00' /></td>";

    html+="<td><input name='frequency[]' autocomplete='off' class='reading_input log_input st_input frequency' value='50' placeholder='0.00'  /></td>";
    }else{
         html+="<td><input name='voltage[]' autocomplete='off' class='reading_input log_input  voltage st_input' placeholder='0.00'  /></td>";
    html+="<td><input name='current[]' autocomplete='off' class='reading_input log_input current st_input' placeholder='0.00'  /></td>";
    html+="<td><input name='pf[]' autocomplete='off' class='pf_input log_input st_input' placeholder='0.00' /></td>";

    html+="<td><input name='frequency[]' autocomplete='off' class='reading_input log_input frequency st_input' placeholder='0.00'  /></td>";
    }
   
     html+="<td><input name='load_mw[]' autocomplete='off' class='reading_input log_input loadmw st_input' readonly placeholder='0.00'  /></td>";
   html+="<td><input name='load_mvr[]' autocomplete='off' class='reading_input log_input st_input loadmvr' readonly  placeholder='0.00'  /></td>";
    
    html+="<td><input name='remarks[]' autocomplete='off' type='text' class='remarks' /></td>";
    html+="</tr>"
    return html;
}
// function getLatestFeederEnergyReading()

function energyParameter(obj,type){
    var name=(type==33)?obj.feeder_name:obj.feeder_name;
    var html='<tr>';
    html+="<td>"+name;
    html+="<input type='hidden' value='"+obj.id+"' placeholder='0.00' name='feeders[]'/></td>"
    
    html+="<td><input name='energy[]' autocomplete='off' class='reading_input' placeholder='0.00' /></td>";
    html+="<td><input name='remarks[]' autocomplete='off' placeholder='optional' /></td>";
    html+="</tr>"
    return html;
}


function updateTableTotals() {
  $('td:not(:first-child):not(:last-child)',
    '#activity_table tr:eq(1)').each(function() {
    var ci= this.cellIndex;
    var total = 0;
    $('td', 
      '#activity_table tr:gt(0)')
      .filter(function() {
        return this.cellIndex === ci;
      })
      .each(function() {
        var inp= $('input', this);
        if(inp.length) {
          if(!$(this).closest('tr').is(':last-child')) {
            total+= $('input', this).val()*1;
          }
          else {
            $('input', this).val(total.toFixed(2));
          }
        }
      });
  });

  $('#activity_table tr:gt(0)').each(function() {
    var total = 0;
    $('td:not(:first-child):not(:last-child)',
      this).each(function() {
      total+= $('input', this).val()*1;
    });
    $('input', this).last().val(total.toFixed(2));
  });
};


updateTableTotals();