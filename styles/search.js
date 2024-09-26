var search = $("#search_bar");

$(document).ready(function(){

    search.keyup(function (e) {
        // $("#disp_result").html(search.val());
        // alert("hello");
        e.preventDefault();
        $.ajax({
            url: "processing.php",
            method: "post",
            data: $("#search_bar").serialize(),
            success: function (data) {
                $("#disp_result").html(data);
                
            }
        });
    });
});