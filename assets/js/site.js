
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
})
