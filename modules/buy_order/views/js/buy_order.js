$(function(){
    $(document).on("submit","#form_new_product",function(e){
        e.preventDefault();
        saveNewProduct(this);
    });
    $(document).on("submit","#form_add_category",function(e){
        e.preventDefault();
        saveNewCategory(this);
    });
    $(document).on("change","#searchbyCategory",function(e){
        searchProducts("#formFilterProduct");
    });
    $(document).on("keyup","#searchbyWord",function(e){
        searchProducts("#formFilterProduct");
    });
    $(document).on("click",".deleteProduct",function(e){
        deleteProduct(this);
    });
    $('.modal-trigger').leanModal();
})

var saveNewProduct=function(selector){
    $.ajax({
        url: "index.php?",
        type: "POST",
        dataType: "JSON",
        data: new FormData(selector),
        processData: false,
        contentType: false,
        success: function (data, status)        {
            if(data.resultado){
                swal({   title: "Producto Agregado",text: "Tu producto fue agregado exitosamente",   type: "success" }, 
                function(){  
                    location.href="?module=product";
                });
            }
        }
    });
}

var searchProducts=function(form){
    var data=$(form).serializeArray();
    $.ajax({
        url: "index.php?",
        type: "POST",
        dataType: "JSON",
        data: data,
        success: function (data, status)        {
            $(".tableProducts").parent().html(data.html);
            console.log(data);
        }
    });
}
var deleteProduct=function(selector){
    
    swal({
        title: "Deseas Eliminar este producto?",   
        text: "Al eliminar este producto ya no estara disponible en el sistema!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",  
        confirmButtonText: "Si, eliminarlo",
        cancelButtonText:"No cancelar",
        closeOnConfirm: false }, 
    function(){ 
        var idproduct=$(selector).data("idproduct");
        $.ajax({
            url: "index.php?",
            type: "POST",
            dataType: "JSON",
            data: {
                module:"product",
                action:"deleteProduct",
                idproduct:idproduct
            },
            success: function (data, status)        {
                if(data.resultado){
                    searchProducts("#formFilterProduct");
                    swal("Eliminado!", "El producto fue eliminado.", "success"); 
                }else{
                    swal("Error!", "No se pudo eliminar el producto.", "error"); 
                }
                
            }
        });
        
    });

}

var saveNewCategory=function(selector){
    $("#categoria").material_select('destroy');
    $.ajax({
        url: "index.php?",
        type: "POST",
        dataType: "JSON",
        data: $(selector).serializeArray(),
        success: function (data){
            if(data.resultado){
                var option="<option value='"+data.id+"' selected>"+$(selector).find("#categoryName").val()+"</option>";
                $("#categoria").append(option);
                $(".materializeSelect").siblings(" span.caret").remove();
                $('.materializeSelect').material_select();
                 $('#modalAddCategory').closeModal();
            }
           
        }
    });
}