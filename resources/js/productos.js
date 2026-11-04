$(document).on('click','.form-crear' ,function(e){
    e.preventDefault();
    
    form =
    $.ajax({
        url: '/productos',
        mothod: 'POST',
        data: form,
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).
    done((res) =>{
        console.log(res);
    });
});