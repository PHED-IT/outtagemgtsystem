
$(document).ready(function(){

    //get menus from 
$('#choose_role').change(function(){
    if ($(this).val()!='') {
        var url=BASE_URL+"admin/get_menus_role_id";
    $.ajax({
        url:url,
        type:'POST',
        data:{
            role_id:$(this).val()
        },
        success:function(response){
            console.log(response)
            var menus=JSON.parse(response);
            $('#menu_names').html('');
            if (menus.length>0) {
            $.each(menus,function(index,value){
                $('#menu_names').append('<option value="'+value.menu_id+'">'+value.name_alias+'</option>')
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

$(document).on('submit','#logForm',function(e){
    e.preventDefault();
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
                $('#tbody').html('');
            $('#station_id').val('')
            $('#station_type').val("")
            $('#button-container').hide();
                $("#logForm")[0].reset()

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
})

$(document).on('submit','#energyLogForm',function(e){
    e.preventDefault();
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
                $('#tbody').html('');
            $('#station_id').val('')
            $('#station_type').val("")
            $('#button-container').hide();
                
                $("#energyLogForm")[0].reset()
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

$('#trans_st').change(function(){
    if ($(this).val()!='') {
        //var logType=$('#logType').val()
        var url=BASE_URL+"input/get_transformer_ts";
        //$('#tbody').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>');
        
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
            $('#station_type').val("TS")
            $('#button-container').hide();
           
            $('#transformer_33').html('');
            $('#transformer_33').append('<option value="" >Select Transformer</option>');
             $.each(transformers,function(index,obj){
                    //var html='<option>';
                html="<option value='"+obj.transformer_id+"'>";
                html+=obj.transformer
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
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
})
$('#transformer_33').change(function(){
    if ($(this).val()!='') {
        var logType=$('#logType').val()
        var url=BASE_URL+"input/get_feeders_ts";
        $('#tbody').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>');
        $('#button-container').hide();
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

            // $('#station_id').val(station_id)
            // $('#station_type').val("TS")
            var feeders=JSON.parse(response);
            var temp = $.trim($('#feeder_temp').html());
            $('#tbody').html('');
            $('#feeder_name').html('');
            if (feeders.length>0) {
                //$('#incomer_div').show()

                var firstTr="<tr>";
                firstTr+="<td>INCOMMER</td>";
                firstTr+="<td><input name='load_mw_in' placeholder='0.00' class='reading_input' /></td>";
                firstTr+="<td><input name='load_mvr_in' class='reading_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='pf_in' class='pf_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='voltage_in' class='reading_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='current_in' class='reading_input' placeholder='0.00' /></td>";
                firstTr+="<td><input name='frequency_in' class='reading_input' placeholder='0.00' /></td>";
                firstTr+="</tr>";

                var energyIncomer="<tr>";
                energyIncomer+="<td>INCOMMER</td>";
                energyIncomer+="<td><input name='energy_in' class='reading_input' placeholder='0.00' /></td>";
                energyIncomer+="<td><input placeholder='optional' /></td>";
        
                energyIncomer+="</tr>";
            $.each(feeders,function(index,obj){
                //option
                opt="<option value='"+obj.feeder_name+"'>";
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
            
            $('#button-container').show();
            
        }else{
            $('#tbody').html('<p class="text-danger">No feader found '+$(this).val()+'</p>');
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

$(document).on('keydown','.reading_input', function (event) {
     if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }
            
            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();

        
});

$(document).on('blur','.pf_input', function (event) {
    if (isNaN($(this).val())) {

        event.preventDefault();
        $(this).val('')
        $(this).focus()
    }
    else if ($(this).val()!="") {
         if ($(this).val()!=-1 && $(this).val()!=1 ) {
        event.preventDefault();
        alert("Power factor must be between -1 or 1")
        $(this).focus()
        $(this).val(0.00)
    }else{
        var reading=parseFloat($(this).val());
    $(this).val(reading.toFixed(2));
    }
    }
   
     
        
});
$('#iss_name').change(function(){
    if ($(this).val()!='') {
        var logType=$('#logType').val();
        var url=BASE_URL+"input/get_feeder_iss";
        $('#tbody').html('<center><span class="fa fa-circle-o-notch fa-spin fa-3x text-success"></span></center>');
        $('#button-container').hide();
        //alert($(this).val())
        var station_id=$(this).val();
    $.ajax({
        url:url,
        type:'POST',
        data:{
            iss_name:$(this).val()
        },
        success:function(response){
            console.log(response)
            $('#station_id').val(station_id)
            $('#station_type').val("ISS")
            var feeders=JSON.parse(response);
            var temp = $.trim($('#feeder_temp').html());
            $('#tbody').html('');
            $('#feeder_sel').html('');
            if (feeders.length>0) {
                var firstTr="<tr>";
                firstTr+="<td>INCOMMER</td>";
                firstTr+="<td><input name='load_mw_in' placeholder='0.00' class='reading_input'/></td>";
                firstTr+="<td><input name='load_mvr_in' placeholder='0.00' class='reading_input'/></td>";
                firstTr+="<td><input name='pf_in' placeholder='0.00' class='pf_input'/></td>";
                firstTr+="<td><input name='voltage_in' placeholder='0.00' class='reading_input'/></td>";
                firstTr+="<td><input name='current_in' placeholder='0.00' class='reading_input'/></td>";
                firstTr+="<td><input name='frequency_in' placeholder='0.00' class='reading_input'/></td>";
                firstTr+="<td><input name='remarks_in' /></td>";
                firstTr+="</tr>";

                var energyIncomer="<tr>";
                energyIncomer+="<td>INCOMMER</td>";
                energyIncomer+="<td><input name='energy_in' placeholder='0.00' class='reading_input'/></td>";
                energyIncomer+="<td><input name='remarks_in' placeholder='optional' /></td>";
                energyIncomer+="</tr>";
            $.each(feeders,function(index,obj){
                //populate select drop down
                opt="<option value='"+obj.feeder_id_11+"'>";
                opt+=obj.feeder_name_11
                opt+="</option>";
                    
                //var x = temp.replace(/{{feeder_name}}/ig, obj.feeder_name);
                $('#feeder_sel').append(opt);
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
            $('#button-container').show();
            
        }else{
            $('#tbody').html('<p class="text-danger">No feader found '+$(this).val()+'</p>');
        }
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
    })
}
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
                $('#data'+id).html(result.reading)
               } else {
                Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: result.message,
                  showConfirmButton: false,
                  timer: 2500
                });
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
                  title: data.message,
                  showConfirmButton: false,
                  timer: 2500
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
                  title: "Acknowledgement successfull",
                  showConfirmButton: false,
                  timer: 2500
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
                  title: "Acknowledgement successfull",
                  showConfirmButton: false,
                  timer: 2500
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
$(document).on('click','.acknowled_fault_resp_tso',function(){
    var id=$(this).attr('id');
    var type_resp=$(this).attr('data-type');
    
    var url=BASE_URL+"FaultResponse/acknowled_fault_resp_tso";
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
        data:{outage_id:id,type_response:type_resp},
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
//acknowledge fault response dso
$(document).on('click','.acknowled_fault_resp_dso',function(){
    var id=$(this).attr('id');
    
    var url=BASE_URL+"FaultResponse/acknowled_fault_resp_dso";
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
    Swal.fire({
  title: 'Are you sure?',
  text: "Station Guarantee is recieved",
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
                location.reload();
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
  text: "You want to acknowledge BOQ",
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
                  title: "Acknowledgement is successfull...Notification sent to store manager",
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
                $('#'+id).hide();
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
                  title: data.message,
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#div'+id).hide()
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
    Swal.fire({
  title: 'Are you sure?',
  text: "Please make sure you've given all required document to Permit Holder",
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
                  title: "Acknowledgement is successfull...",
                  showConfirmButton: false,
                  timer: 2500
                });
                $('#div'+id).hide()
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
//confirm date and time central dispatch
$(document).on('submit','.cd_approve_date_plan_out',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"planned/cd_approve_date_plan_out";
    Swal.fire({
  title: 'Are you sure?',
  text: "You want to approve this date",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
    
        $('#sub'+id).attr('disabled',true)
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
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
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
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
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
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
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
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
        $('#sub'+id).html('<span class="fa fa-spinner fa-pulse"></span>')
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
                  title: "Rejection is sucessful!",
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

$('.feeder_type_log').change(function(){
    var type=$(this).val();
    
    var url=BASE_URL+"mis/get_station_type";
    $('#spinner').html('<center><span class="fa fa-circle-o-notch fa-spin fa-2x text-success"></span></center>');
       
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
                    $.each(station,function(index,obj){
                    //var html='<option>';
                html="<option value='"+obj.tsid+"'>";
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
                    $.each(station,function(index,obj){
                    //var html='<option>';
                html="<option value='"+obj.ISS_ID+"'>";
                html+=obj.ISS
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

$('#myTable').DataTable({
    dom: 'Bfrtip',
    "pageLength": 25,
    buttons: [
        'copy', 'excel', 'pdf'
    ]
});

$('#simpleTable').DataTable();
// console.log(moment("10-04-2020","YYYY-MM-DD").format("YYYY-MM-DD"))

  $('#date_range_picker').daterangepicker();
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
    var name=(type==33)?obj.feeder_name:obj.feeder_name_11;
    var html='<tr>';
    html+="<td>"+name;
    html+="<input type='hidden' value='"+name+"' placeholder='0.00' name='feeders[]'/></td>"
   // html+="<td><input name='INCOMMER[]' class='reading_input' placeholder='0.00' class='form-control' /></td>";
    html+="<td><input name='readings[]' class='reading_input' placeholder='0.00' class='form-control' /></td>";
    html+="<td><input name='load_mvr[]' class='reading_input' placeholder='0.00' class='form-control' /></td>";
    html+="<td><input name='pf[]'  class='form-control pf_input' /></td>";
    html+="<td><input name='voltage[]' class='reading_input' placeholder='0.00' class='form-control' /></td>";
    html+="<td><input name='current[]' class='reading_input' placeholder='0.00' class='form-control' /></td>";
    html+="<td><input name='frequency[]' class='reading_input' placeholder='0.00' class='form-control' /></td>";
    html+="<td><input name='remarks[]' type='text' class='form-control' /></td>";
    html+="</tr>"
    return html;
}
// function getLatestFeederEnergyReading()

function energyParameter(obj,type){
    var name=(type==33)?obj.feeder_name:obj.feeder_name_11;
    var html='<tr>';
    html+="<td>"+name;
    html+="<input type='hidden' value='"+name+"' placeholder='0.00' name='feeders[]'/></td>"
    
    html+="<td><input name='energy[]' class='reading_input' placeholder='0.00' /></td>";
    html+="<td><input name='remarks[]'  placeholder='optional' /></td>";
    html+="</tr>"
    return html;
}
