$(document).ready(function () {
    $('.parallax').parallax();
    $(".button-collapse").sideNav();
    
    $(document).on("submit",".contact-form",function(e){
        e.preventDefault();
        sendMessage(this);
    });
    
    
});

var sendMessage=function(form){
    var data=$(form).serializeArray();
    
    $.ajax({
        url: "index.php?",
        type: "POST",
        dataType: "JSON",
        data: data,
        success: function (data, status)        {
           
        }
    });
}
        