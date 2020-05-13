$(document).ready(function(){
	$('#add_component').click(function(){
                       
    var div='<div class="row"><div class="col-7">';
    div+='<div class="form-group">';
    div+='<input type="text" class="form-control" name="item[]">';
    div+="</div></div>";
    div+='<div class="col-2"><div class="form-group">';
    div+=' <input type="number" class="form-control" name="quantity[]"></div></div>'
    div+='<div class="col-3"><div class="form-group">';
    div+='<input type="number" class="form-control" name="price[]"></div></div>'
    
    div+='</div>'
        $('#container_div').append(div);
});
	$('#add_component_edit').click(function(){
                       
    var div='<tr ><td><td >';
    div+='<div class="form-group">';
    div+='<input type="text" class="form-control" name="item[]">';
    div+="</div></td>";
    div+='<td ><div class="form-group">';
    div+=' <input type="number" class="form-control" name="price[]"></div></td>'
    div+='<td ><div class="form-group">';
    div+='<input type="number" class="form-control" name="quantity[]"></div></td><td></td>'
    
    div+='</tr>'
        $('#container_div').append(div);
        $('#submit_btn').show()
});


	//submit boq
$(document).on('submit','#boq_form',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"FaultResponse/store_boq";
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
        
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            spinner.hide();
            if (data.status) {
                //$('#modal'+id).modal('hide')
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Submission succesfull",
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#boq_form')[0].reset()
                location.assign(BASE_URL+"FaultResponse/lines_man");
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
                
        }
     })   
    }
    })
})
	//approve boq materials
$(document).on('submit','#approve_boq_material',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"FaultResponse/approve_boq_material";
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
        
        var form=$(this);
    var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            spinner.hide();
            if (data.status) {
                //$('#modal'+id).modal('hide')
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Approval succesfull",
                  showConfirmButton: false,
                  timer: 1500
                });
                
                location.assign(BASE_URL+"FaultResponse/store_manager");
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
                
        }
     })   
    }
    })
})


	//edit boq
$(document).on('click','.edit_boq',function(e){
    var id=$(this).attr('data-id');
    e.preventDefault()
    var url=BASE_URL+"FaultResponse/update_boq";
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
    //var spinner = $('#loader_submit');
   // spinner.show();
        var boq_id=$('#id'+id).val();
        var item=$('#item'+id).val();
        var price=$('#p'+id).val();
        var quantity=$('#q'+id).val();
    //     var form=$(this);
    // var data=form.serialize();
     $.ajax({
        url:url,
        type:'POST',
        data:{boq_id:boq_id,item:item,price:price,quantity:quantity},
        success:function(response){
            console.log(response)
            var data=JSON.parse(response);
            //spinner.hide();
            if (data.status) {
                //$('#modal'+id).modal('hide')
                Swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: "Edit is succesfull",
                  showConfirmButton: false,
                  timer: 1000
                });
                // $('#boq_form')[0].reset()
                location.reload();
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
        	//spinner.hide();
            console.log(error)
            console.log(url)
              Swal.fire({
                  position: 'top-end',
                  type: 'error',
                  title: "Oops Error!!",
                  showConfirmButton: false,
                  timer: 1500
                });
                
        }
     })   
    }
    })
})

})